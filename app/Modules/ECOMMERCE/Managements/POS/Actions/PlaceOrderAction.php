<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Mail\OrderPlacedEmail;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\POS\Database\Models\Invoice;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderLog;
use App\Http\Controllers\Account\AccountsHelper;
use App\Modules\MLM\Service\MlmCommissionService;
use App\Modules\MLM\Service\ReferralActivityLogger;

class PlaceOrderAction
{
    /**
     * Execute POS order placement
     * 
     * @param Request $request
     * @return array ['success' => bool, 'order_id' => int|null, 'message' => string]
     */
    public static function execute(Request $request): array
    {

        // Ensure a delivery method exists (default to store pickup) to avoid intermittent missing-field issues
        if (!$request->has('delivery_method') || $request->input('delivery_method') === null || $request->input('delivery_method') === '') {
            $request->merge(['delivery_method' => Order::DELIVERY_STORE_PICKUP]);
        }

        // Validate request first (use Validator to avoid automatic redirect)
        $validationResult = self::validateRequest($request);
        if (is_array($validationResult) && isset($validationResult['success']) && $validationResult['success'] === false) {
            return $validationResult;
        }

        if (!self::hasValidCart()) {
            return [
                'success' => false,
                'order_id' => null,
                'message' => 'Cart is empty',
                'errors' => ['cart' => ['Cart is empty']]
            ];
        }

        if (!self::hasValidProducts($request)) {
            return [
                'success' => false,
                'order_id' => null,
                'message' => 'No valid products in request',
                'errors' => ['products' => ['No valid products in request']]
            ];
        }

        // Ensure timezone
        date_default_timezone_set("Asia/Dhaka");

        // Wrap DB operations in a transaction and handle exceptions
        DB::beginTransaction();
        try {
            $orderCalculations = self::calculateOrderTotals($request);
            $orderStatus = self::determineOrderStatus($request);
            $orderId = self::createOrder($request, $orderCalculations, $orderStatus);
            self::createOrderDetails($orderId, $request);
            self::createShippingInfo($request, $orderId);
            self::createBillingAddress($request, $orderId);
            self::createOrderPayment($orderId, $request);
            self::clearSession();
            // self::autoGenerateInvoice($orderId);
            // self::subscribeUserIfNeeded($request);
            // self::generateVoucher($orderId);
            // self::sendOrderNotifications($request, $orderId);

            DB::commit();

            // Distribute MLM commissions AFTER transaction commit (following OrderObserver pattern)
            // This ensures order data is fully persisted before commission distribution
            if ($orderStatus['status'] == Order::STATUS_DELIVERED) {
                self::distributeCommissionsAndActivities($orderId);
            }

            return [
                'success' => true,
                'order_id' => $orderId,
                'message' => 'Order placed successfully'
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('PlaceOrderAction failed: ' . $e->getMessage() . '\n' . $e->getTraceAsString());

            return [
                'success' => false,
                'order_id' => null,
                'message' => 'Failed to place order. Please try again or contact support.'
            ];
        }
    }

    /**
     * Validate incoming request based on delivery method
     */
    private static function validateRequest(Request $request): ?array
    {
        $validationRules = [
            'customer_id' => 'nullable|exists:users,id',
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_email' => 'nullable|email|max:255',
            'delivery_method' => 'required|in:' . Order::DELIVERY_HOME . ',' . Order::DELIVERY_STORE_PICKUP . ',' . Order::DELIVERY_POS_HANDOVER,
            'reference_code' => 'nullable|string|max:255',
            'customer_source_type_id' => 'nullable|exists:customer_source_types,id',
            'outlet_id' => 'nullable|exists:outlets,id',
            'special_note' => 'nullable|string|max:1000',
            'shipping_charge' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
        ];

        // Optimize validation based on selected delivery method:
        // - Home Delivery: require full shipping address (address + district + thana)
        // - Store Pickup / POS Handover: do NOT require shipping address fields (they are irrelevant)
        // Keep basic contact fields required (name/phone) so orders are identifiable.
        $delivery = $request->input('delivery_method');

        if ($delivery == Order::DELIVERY_HOME) {
            $validationRules = array_merge($validationRules, [
                'shipping_address' => 'required|string|max:500',
                'shipping_district_id' => 'required|exists:districts,id',
                'shipping_thana_id' => 'required|exists:upazilas,id',
                'shipping_postal_code' => 'nullable|string|max:20',
                // billing can be optional for home delivery (copied from shipping if blank)
                'billing_name' => 'nullable|string|max:255',
                'billing_phone' => 'nullable|string|max:20',
                'billing_address' => 'nullable|string|max:500',
                'billing_postal_code' => 'nullable|string|max:20',
            ]);
        } else {
            // For store pickup or POS handover, shipping address is not required
            $validationRules = array_merge($validationRules, [
                'shipping_address' => 'nullable|string|max:500',
                'shipping_district_id' => 'nullable|exists:districts,id',
                'shipping_thana_id' => 'nullable|exists:upazilas,id',
                'shipping_postal_code' => 'nullable|string|max:20',
                // Billing info is optional for pickup, but name/phone at top-level remain required
                'billing_name' => 'nullable|string|max:255',
                'billing_phone' => 'nullable|string|max:20',
                'billing_address' => 'nullable|string|max:500',
                'billing_postal_code' => 'nullable|string|max:20',
            ]);
        }

        // Use Validator so we can return errors instead of Laravel's automatic redirect
        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return [
                'success' => false,
                'order_id' => null,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        return null;
    }

    /**
     * Check if cart has valid items
     */
    private static function hasValidCart(): bool
    {
        return session('cart') && count(session('cart')) > 0;
    }

    /**
     * Check if request has valid products
     */
    private static function hasValidProducts(Request $request): bool
    {
        return is_array($request->products) && count($request->products) > 0;
    }

    /**
     * Calculate order totals including discounts and delivery costs
     * Uses submitted calculation values from the form
     */
    private static function calculateOrderTotals(Request $request): array
    {
        // Use calculated values from the form submission
        $subtotalGross = floatval($request->subtotal_gross ?? 0);
        $itemDiscountTotal = floatval($request->item_discount_total ?? 0);
        $discount = floatval($request->discount ?? 0);
        
        // Get delivery cost from the submitted form (user may have manually entered it)
        // Always use the shipping_charge value from the form, regardless of delivery method
        $deliveryCost = floatval($request->shipping_charge ?? 0);
        
        $couponCode = session('coupon') ? session('coupon') : null;
        $couponDiscount = floatval(session('pos_discount') ?? 0);

        // Use submitted total or recalculate
        $grandTotal = floatval($request->total ?? 0);
        if ($grandTotal <= 0) {
            // Fallback: recalculate if total not provided
            $grandTotal = ($subtotalGross + $deliveryCost) - ($itemDiscountTotal + $discount + $couponDiscount);
        }

        $roundOff = $grandTotal - floor($grandTotal);
        $grandTotalWithoutRoundOff = $grandTotal - $roundOff;

        // Calculate subtotal after item-level discounts
        $subtotalAfterItemDiscounts = $subtotalGross - $itemDiscountTotal;

        return [
            'subtotal_gross' => $subtotalGross,
            'item_discount_total' => $itemDiscountTotal,
            'subtotal_after_item_discounts' => $subtotalAfterItemDiscounts,
            'discount' => $discount,
            'delivery_cost' => $deliveryCost,
            'coupon_code' => $couponCode,
            'coupon_discount' => $couponDiscount,
            'grand_total' => $grandTotal,
            'round_off' => $roundOff,
            'grand_total_without_round_off' => $grandTotalWithoutRoundOff,
        ];
    }

    /**
     * Determine order status based on delivery method
     * Store pickup orders are marked as delivered and paid immediately
     */
    private static function determineOrderStatus(Request $request): array
    {
        $orderStatus = Order::STATUS_APPROVED;
        $paymentStatus = Order::PAYMENT_STATUS_UNPAID;

        if ($request->delivery_method == Order::DELIVERY_STORE_PICKUP) {
            $orderStatus = Order::STATUS_DELIVERED;
            $paymentStatus = Order::PAYMENT_STATUS_PAID;
        }

        return [
            'status' => $orderStatus,
            'payment_status' => $paymentStatus
        ];
    }

    /**
     * Create order record in database
     */
    private static function createOrder(Request $request, array $calculations, array $status): int
    {
        // Use the delivery cost from calculations (which comes from the form's shipping_charge field)
        // This respects the manually entered shipping charge by the user
        $deliveryFeeToSave = $calculations['delivery_cost'];
        $totalToSave = $calculations['grand_total_without_round_off'];

        return DB::table('orders')->insertGetId([
            'user_id' => $request->customer_id,
            'order_no' => rand(100000, 999999),
            'order_date' => Carbon::now(),
            'sub_total' => $calculations['subtotal_after_item_discounts'], // Subtotal after item-level discounts
            'discount' => $calculations['discount'], // Order-level discount
            'coupon_discount' => $calculations['coupon_discount'],
            'delivery_fee' => $deliveryFeeToSave,
            'total' => $totalToSave,
            'round_off' => $calculations['round_off'],
            'coupon_code' => $calculations['coupon_code'],
            'payment_method' => Order::PAYMENT_COD,
            'payment_status' => $status['payment_status'],
            'order_from' => Order::ORDER_FROM_POS, // POS order
            'order_source' => Order::ORDER_SOURCE_POS, // Source is POS system
            'delivery_method' => $request->delivery_method ?? Order::DELIVERY_HOME,
            'order_status' => $status['status'],
            'reference_code' => $request->reference_code,
            'customer_src_type_id' => $request->customer_source_type_id,
            'outlet_id' => $request->outlet_id,
            'complete_order' => $status['status'] == Order::STATUS_DELIVERED ? Order::COMPLETE_ORDER_COMPLETE : Order::COMPLETE_ORDER_INCOMPLETE,
            'order_note' => $request->special_note,
            'slug' => time() . rand(999999, 100000),
            'created_by' => auth()->id(),
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Create order progress record
     */


    /**
     * Create order details for each cart item and decrement stock
     * Matches order_details table schema from migration
     * Now uses products array from request instead of session cart
     */
    private static function createOrderDetails(int $orderId, Request $request): void
    {
        foreach ($request->products as $product) {
            $productInfo = DB::table('products')->where('id', $product['product_id'])->first();

            if (!$productInfo) {
                Log::warning("Product not found: {$product['product_id']}");
                continue;
            }

            $price = floatval($product['price']);
            $quantity = intval($product['quantity']);
            $discountPrice = floatval($product['discount_price'] ?? 0);

            // Calculate reward points for this item
            $rewardPoints = 0;
            if (isset($productInfo->reward_point) && $productInfo->reward_point > 0) {
                $rewardPoints = intval($productInfo->reward_point) * $quantity;
            }

            // Get average cost price if available
            $avgCostPrice = isset($productInfo->avg_cost_price) ? floatval($productInfo->avg_cost_price) : null;

            DB::table('order_details')->insert([
                'order_id' => $orderId,
                'product_id' => intval($product['product_id']),
                'store_id' => $request->outlet_id ? intval($request->outlet_id) : null,
                'warehouse_id' => !empty($product['purchase_product_warehouse_id']) ? intval($product['purchase_product_warehouse_id']) : null,
                'warehouse_room_id' => !empty($product['purchase_product_warehouse_room_id']) ? intval($product['purchase_product_warehouse_room_id']) : null,
                'warehouse_room_cartoon_id' => !empty($product['purchase_product_warehouse_room_cartoon_id']) ? intval($product['purchase_product_warehouse_room_cartoon_id']) : null,
                'special_discount' => $discountPrice, // Item-level discount
                'reward_points' => $rewardPoints,
                'color_id' => !empty($product['color_id']) ? intval($product['color_id']) : null,
                'size_id' => !empty($product['size_id']) ? intval($product['size_id']) : null,
                'unit_id' => 1, // Default unit
                'qty' => $quantity,
                'unit_price' => $price, // Per unit price (not per_unit_price)
                'avg_cost_price' => $avgCostPrice, // Average cost at time of order
                'total_price' => ($price * $quantity) - $discountPrice, // Final price after discount
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Decrement stock
            $colorId = !empty($product['color_id']) ? intval($product['color_id']) : 0;
            $sizeId = !empty($product['size_id']) ? intval($product['size_id']) : 0;

            if ($colorId > 0 || $sizeId > 0) {
                // Variant product - decrement variant stock
                $variantQuery = DB::table('product_variants')->where('product_id', $product['product_id']);

                if ($colorId > 0) {
                    $variantQuery->where('color_id', $colorId);
                }

                if ($sizeId > 0) {
                    $variantQuery->where('size_id', $sizeId);
                }

                $decremented = $variantQuery->decrement('stock', $quantity);

                if ($decremented === 0) {
                    Log::warning("Failed to decrement variant stock for product {$product['product_id']}, color: {$colorId}, size: {$sizeId}");
                }
            } else {
                // Simple product - decrement product stock
                $decremented = DB::table('products')
                    ->where('id', $product['product_id'])
                    ->decrement('stock', $quantity);

                if ($decremented === 0) {
                    Log::warning("Failed to decrement product stock for product {$product['product_id']}");
                }
            }
        }
    }

    /**
     * Update customer's reward points balance
     */
    private static function updateCustomerRewardPoints(Request $request, int $totalRewardPoints): void
    {
        if ($request->customer_id && $totalRewardPoints > 0) {
            DB::table('users')->where('id', $request->customer_id)->increment('reward_points', $totalRewardPoints);
        }
    }

    /**
     * Create shipping information record
     */
    private static function createShippingInfo(Request $request, int $orderId): void
    {
        $shippingDistrictInfo = DB::table('districts')->where('id', $request->shipping_district_id)->first();
        $shippingThanaInfo = DB::table('upazilas')->where('id', $request->shipping_thana_id)->first();

        DB::table('shipping_infos')->insert([
            'order_id' => $orderId,
            'full_name' => $request->shipping_name,
            'phone' => $request->shipping_phone,
            'email' => $request->shipping_email,
            'address' => $request->shipping_address,
            'country' => 'Bangladesh',
            'city' => $shippingDistrictInfo ? $shippingDistrictInfo->name : null,
            'thana' => $shippingThanaInfo ? $shippingThanaInfo->name : null,
            'post_code' => $request->shipping_postal_code,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Create billing address record
     */
    private static function createBillingAddress(Request $request, int $orderId): void
    {
        $billingDistrictInfo = DB::table('districts')->where('id', $request->billing_district_id)->first();
        $billingThanaInfo = DB::table('upazilas')->where('id', $request->billing_thana_id)->first();

        DB::table('billing_addresses')->insert([
            'order_id' => $orderId,
            'full_name' => $request->billing_name ?? $request->shipping_name,
            'phone' => $request->billing_phone ?? $request->shipping_phone,
            'email' => $request->billing_email ?? $request->shipping_email,
            'gender' => $request->billing_gender ?? null,
            'address' => $request->billing_address ?? $request->shipping_address,
            'thana' => $billingThanaInfo ? $billingThanaInfo->name : ($request->billing_thana_id ? null : null),
            'post_code' => $request->billing_postal_code ?? $request->shipping_postal_code,
            'city' => $billingDistrictInfo ? $billingDistrictInfo->name : null,
            'country' => $request->billing_country ?? 'Bangladesh',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Subscribe user to mailing list if not already subscribed
     */
    // private static function subscribeUserIfNeeded(Request $request): void
    // {
    //     if ($request->shipping_email && !DB::table('subscribed_users')->where('email', $request->shipping_email)->exists()) {
    //         DB::table('subscribed_users')->insert([
    //             'email' => $request->shipping_email,
    //             'created_at' => Carbon::now()
    //         ]);
    //     }
    // }

    /**
     * Create order payment record
     * Matches order_payments table schema from migration
     */
    private static function createOrderPayment(int $orderId, Request $request): void
    {
        $orderInfo = DB::table('orders')->where('id', $orderId)->first();

        // Generate unique transaction ID for POS cash payment
        $transactionId = 'POS_CASH_' . time() . '_' . rand(100000, 999999);

        DB::table('order_payments')->insert([
            'order_id' => $orderId,
            'payment_through' => 'POS', // Payment gateway/method name
            'tran_id' => $transactionId, // Transaction ID
            'val_id' => $transactionId, // Validation ID (same as tran_id for POS)
            'amount' => strval($orderInfo->total), // String as per migration
            'card_type' => 'Cash', // POS cash payment
            'bank_tran_id' => $transactionId, // Bank transaction ID
            'status' => $orderInfo->payment_status == Order::PAYMENT_STATUS_PAID ? 'VALID' : 'PENDING', // Payment status
            'tran_date' => Carbon::now()->format('Y-m-d H:i:s'), // Transaction date
            'currency' => 'BDT', // Currency
            'store_id' => $request->outlet_id ? strval($request->outlet_id) : null, // Store/outlet ID
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Generate accounting voucher for paid orders
     */
    private static function generateVoucher(int $orderId): void
    {
        try {
            $orderInfo = DB::table('orders')->where('id', $orderId)->first();

            if ($orderInfo && $orderInfo->payment_status == Order::PAYMENT_STATUS_PAID) {
                AccountsHelper::newCustomerReceiptVoucher(
                    customerId: $orderInfo->user_id,
                    amount: $orderInfo->total,
                    note: "POS Payment received for Order #{$orderInfo->order_no}",
                    invoiceId: $orderId
                );
            }
        } catch (\Exception $e) {
            Log::error('Voucher generation failed for order ' . $orderId . ': ' . $e->getMessage());
        }
    }

    /**
     * Send order notifications via SMS and Email
     */
    private static function sendOrderNotifications(Request $request, int $orderId): void
    {
        // Send SMS notification
        if ($request->shipping_phone && env('APP_ENV') != 'local') {
            try {
                $phone = self::formatBangladeshiPhoneNumber($request->shipping_phone);
                $message = "Thank you for your order! Your order has been placed successfully. Order ID: #{$orderId}";

                Http::get('https://api.greenweb.com.bd/api.php', [
                    'token' => env('SMS_API_TOKEN'),
                    'to' => $phone,
                    'message' => $message
                ]);
            } catch (\Exception $e) {
                Log::error('SMS sending failed for order ' . $orderId . ': ' . $e->getMessage());
            }
        }

        // Send email notification
        try {
            if ($request->shipping_email) {
                Mail::to($request->shipping_email)->send(new OrderPlacedEmail($orderId));
            }
        } catch (\Exception $e) {
            Log::error('Email sending failed for order ' . $orderId . ': ' . $e->getMessage());
        }
    }

    /**
     * Clear POS session data
     */
    private static function clearSession(): void
    {
        session()->forget('coupon');
        session()->forget('pos_discount');
        session()->forget('shipping_charge');
        session()->forget('cart');
        session()->forget('discount');
    }

    /**
     * Auto-generate invoice for completed POS orders
     */
    private static function autoGenerateInvoice(int $orderId): void
    {
        try {
            $order = DB::table('orders')->where('id', $orderId)->first();

            if ($order && $order->order_from == Order::ORDER_FROM_POS && $order->complete_order == Order::COMPLETE_ORDER_COMPLETE) {
                if (!Invoice::hasInvoice($orderId)) {
                    $invoice = new Invoice();
                    $invoice->id = $orderId;
                    $invoice->markAsInvoiced();
                }
            }
        } catch (\Exception $e) {
            Log::error('Invoice generation failed for order ' . $orderId . ': ' . $e->getMessage());
        }
    }

    /**
     * Format phone number to Bangladeshi format with country code
     */
    private static function formatBangladeshiPhoneNumber(string $phoneNumber): string
    {
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        if (substr($phoneNumber, 0, 2) !== '88') {
            $phoneNumber = '88' . $phoneNumber;
        }

        return $phoneNumber;
    }

    /**
     * Distribute MLM commissions and log referral activities for POS orders
     * 
     * This is called after order is successfully placed and marked as delivered.
     * Follows the same logic as OrderObserver for ecommerce orders.
     * 
     * @param int $orderId
     * @return void
     */
    private static function distributeCommissionsAndActivities(int $orderId): void
    {
        try {
            // Get the order
            $order = Order::find($orderId);

            if (!$order) {
                Log::warning('POS Order not found for commission distribution', ['order_id' => $orderId]);
                return;
            }

            // Check if order has a customer with referrer
            if (!$order->user_id) {
                Log::info('POS Order has no customer, skipping commission distribution', [
                    'order_id' => $orderId,
                    'order_no' => $order->order_no
                ]);
                return;
            }

            Log::info('Processing MLM commission and activity logging for POS order', [
                'order_id' => $orderId,
                'order_no' => $order->order_no,
                'user_id' => $order->user_id,
                'order_status' => $order->order_status,
            ]);

            // 1. Log referral activities (similar to OrderObserverForMLM)
            try {
                $activityIds = ReferralActivityLogger::logOrderActivity($order);

                if (count($activityIds) > 0) {
                    Log::info('Referral activities created for POS order', [
                        'order_id' => $order->id,
                        'order_no' => $order->order_no,
                        'activities_count' => count($activityIds),
                        'activity_ids' => $activityIds
                    ]);

                    // Since order is already delivered, approve and mark as paid immediately
                    $approvedCount = ReferralActivityLogger::approveOrderActivities($order->id);
                    $paidCount = ReferralActivityLogger::markOrderActivitiesAsPaid($order->id);

                    Log::info('Referral activities approved and marked as paid for POS order', [
                        'order_id' => $order->id,
                        'approved_count' => $approvedCount,
                        'paid_count' => $paidCount,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error logging referral activities for POS order', [
                    'order_id' => $orderId,
                    'error' => $e->getMessage(),
                ]);
            }

            // 2. Initialize commission service and distribute commissions
            $commissionService = new MlmCommissionService();

            // Distribute commissions
            $result = $commissionService->distributeCommissions($order);

            if ($result['success']) {
                // Log to order logs
                OrderLog::logCommissionDistribution(
                    $order->id,
                    $result['commissions_count'] ?? 0,
                    auth()->id(),
                    $result['message']
                );

                Log::info('MLM commissions distributed successfully for POS order', [
                    'order_id' => $orderId,
                    'order_no' => $order->order_no,
                    'commissions_count' => $result['commissions_count'] ?? 0,
                    'message' => $result['message'],
                ]);
            } else {
                Log::warning('MLM commission distribution skipped or failed for POS order', [
                    'order_id' => $orderId,
                    'order_no' => $order->order_no,
                    'message' => $result['message'],
                    'idempotent' => $result['idempotent'] ?? false,
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't throw exception to prevent blocking order completion
            Log::error('MLM commission/activity distribution exception for POS order', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
