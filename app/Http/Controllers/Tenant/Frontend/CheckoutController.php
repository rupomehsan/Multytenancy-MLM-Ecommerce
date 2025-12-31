<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\MLM\Service\ReferralActivityLogger;



use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    protected $baseRoute = 'tenant.frontend.pages.checkout.';
    protected $rootRoute = 'tenant.frontend.pages.';
    public function checkout()
    {

        if (session('order_failed') == true) {
            Toastr::error('Failed to Place Order. Please try again!', 'Order Failed');
            session()->forget('order_failed');
            return redirect('/checkout');
        }

        if (!session('cart') || (session('cart') && count(session('cart')) <= 0)) {
            Toastr::error('No Products Found in Cart', 'Failed to Checkout');
            return redirect('/');
        }

        return view($this->baseRoute . 'checkout');
    }

    public function applyCoupon(Request $request)
    {

        $couponCode = $request->coupon_code;
        $couponInfo = DB::table('promo_codes')->where('code', $couponCode)->first();
        if ($couponInfo) {

            if (Auth::user() && DB::table('orders')->where('coupon_code', $couponInfo->code)->where('user_id', Auth::user()->id)->exists()) {
                session([
                    'coupon' => $couponCode,
                    'discount' => 0
                ]);
                session()->forget('original_subtotal');
                $checkoutTotalAmount = view($this->baseRoute . 'order_total')->render();
                return response()->json(['message' => 'Coupon Already Used', 'status' => 0, 'checkoutTotalAmount' => $checkoutTotalAmount]);
            }

            if ($couponInfo->expire_date < date("Y-m-d")) {
                session([
                    'coupon' => $couponCode,
                    'discount' => 0
                ]);
                session()->forget('original_subtotal');
                $checkoutTotalAmount = view($this->baseRoute . 'order_total')->render();
                return response()->json(['message' => 'Coupon is Expired', 'status' => 0, 'checkoutTotalAmount' => $checkoutTotalAmount]);
            }

            $subTotal = 0;
            foreach ((array) session('cart') as $id => $details) {
                $subTotal += ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity'];
            }

            if ($couponInfo->minimum_order_amount && $couponInfo->minimum_order_amount > $subTotal) {
                session([
                    'coupon' => $couponCode,
                    'discount' => 0
                ]);
                session()->forget('original_subtotal');
                $checkoutTotalAmount = view($this->baseRoute . 'order_total')->render();
                return response()->json(['message' => 'Sorry! Minimum Order Amount is ' . $couponInfo->minimum_order_amount, 'status' => 0, 'checkoutTotalAmount' => $checkoutTotalAmount]);
            }

            $discount = 0;
            if ($couponInfo->type == 1) {
                $discount = $couponInfo->value;
            } else {
                $discount = ($subTotal * $couponInfo->value) / 100;
            }

            session([
                'coupon' => $couponCode,
                'discount' => $discount,
                'original_subtotal' => $subTotal,  // Store original subtotal for percentage calculation
                'coupon_type' => $couponInfo->type,  // Store coupon type (1 = fixed, else = percentage)
                'coupon_minimum_order_amount' => $couponInfo->minimum_order_amount ?? 0  // Store minimum order amount
            ]);

            $checkoutTotalAmount = view($this->baseRoute . 'order_total')->render();
            $checkoutCoupon = view($this->baseRoute . 'coupon')->render();
            return response()->json(['message' => 'Coupon Applied Successfully', 'status' => 1, 'checkoutTotalAmount' => $checkoutTotalAmount, 'checkoutCoupon' => $checkoutCoupon]);
        } else {
            session([
                'coupon' => $couponCode,
                'discount' => 0
            ]);
            session()->forget(['original_subtotal', 'coupon_type', 'coupon_minimum_order_amount']);
            $checkoutTotalAmount = view($this->baseRoute . 'order_total')->render();
            $checkoutCoupon = view($this->baseRoute . 'coupon')->render();
            return response()->json(['message' => 'Sorry No Coupon Found', 'status' => 0, 'checkoutTotalAmount' => $checkoutTotalAmount, 'checkoutCoupon' => $checkoutCoupon]);
        }
    }

    public function districtWiseThana(Request $request)
    {

        $districtWiseDeliveryCharge = 0;
        $districtInfo = DB::table('districts')->where('id', $request->district_id)->first();
        if ($districtInfo) {
            // Check if any cart item has 'is_product_qty_multiply' set to true
            $countIsProductQtyMultiply = 0;
            foreach ((array) session('cart') as $cartItem) {
                if (isset($cartItem['is_product_qty_multiply']) && $cartItem['is_product_qty_multiply']) {
                    $countIsProductQtyMultiply += $cartItem['quantity'];
                }
            }

            if ($countIsProductQtyMultiply) {
                $districtWiseDeliveryCharge = $districtInfo->delivery_charge * $countIsProductQtyMultiply;
            } else {
                $districtWiseDeliveryCharge = $districtInfo->delivery_charge;
            }
        }

        session(['delivery_cost' => $districtWiseDeliveryCharge]);

        $data = DB::table('upazilas')->where("district_id", $request->district_id)->select('name', 'id')->orderBy('name', 'asc')->get();
        $checkoutTotalAmount = view($this->baseRoute . 'order_total')->render();
        return response()->json(['data' => $data, 'checkoutTotalAmount' => $checkoutTotalAmount]);
    }

    function changeDeliveryMethod(Request $request)
    {
        // Store delivery method and district ID in session for later use
        session(['delivery_method' => $request->delivery_method]);
        if ($request->district_id) {
            session(['district_id' => $request->district_id]);
        }

        if ($request->delivery_method == 1) { //home delivery and charge applicable
            $districtInfo = DB::table('districts')->where('id', $request->district_id)->first();

            if ($districtInfo) {
                // Check if any cart item has 'is_product_qty_multiply' set to true

                $countIsProductQtyMultiply = 0;
                foreach ((array) session('cart') as $cartItem) {
                    if (isset($cartItem['is_product_qty_multiply']) && $cartItem['is_product_qty_multiply']) {
                        $countIsProductQtyMultiply += $cartItem['quantity'];
                    }
                }

                if ($countIsProductQtyMultiply) {
                    session(['delivery_cost' => $districtInfo->delivery_charge * $countIsProductQtyMultiply]);
                } else {
                    session(['delivery_cost' => $districtInfo->delivery_charge]);
                }
            } else {
                session(['delivery_cost' => 0]);
            }
        } else {
            session(['delivery_cost' => 0]);
        }
        $checkoutTotalAmount = view($this->baseRoute . 'order_total')->render();
        return response()->json(['checkoutTotalAmount' => $checkoutTotalAmount]);
    }

    public function recalculateDeliveryCost()
    {
        $deliveryMethod = session('delivery_method');
        $districtId = session('district_id');

        if ($deliveryMethod == 1 && $districtId) { //home delivery and charge applicable
            $districtInfo = DB::table('districts')->where('id', $districtId)->first();

            if ($districtInfo) {
                // Check if any cart item has 'is_product_qty_multiply' set to true
                $countIsProductQtyMultiply = 0;
                foreach ((array) session('cart') as $cartItem) {
                    if (isset($cartItem['is_product_qty_multiply']) && $cartItem['is_product_qty_multiply']) {
                        $countIsProductQtyMultiply += $cartItem['quantity'];
                    }
                }

                if ($countIsProductQtyMultiply) {
                    session(['delivery_cost' => $districtInfo->delivery_charge * $countIsProductQtyMultiply]);
                } else {
                    session(['delivery_cost' => $districtInfo->delivery_charge]);
                }
            } else {
                session(['delivery_cost' => 0]);
            }
        } else {
            session(['delivery_cost' => 0]);
        }
    }

    public function placeOrder(Request $request)
    {

        if (!session('cart') || (session('cart') && count(session('cart')) <= 0)) {
            Toastr::error('No Products Found in Checkout', 'Failed to Place Order');
            return redirect('/');
        }

        // common tasks to do for every order (not dependent on any payment gateway)
        date_default_timezone_set("Asia/Dhaka");
        $total = 0;
        foreach ((array) session('cart') as $id => $details) {
            $total += ($details['price'] ? $details['discount_price'] : $details['price']) * $details['quantity'];
        }
        $discount = session('discount') ? session('discount') : 0;
        $deliveryCost = session('delivery_cost') ? session('delivery_cost') : 0;
        $couponCode = session('coupon') ? session('coupon') : 0;

        $grandTotal = $total + $deliveryCost - $discount;
        $roundOff = $grandTotal - floor($grandTotal);
        $grandTotalwithoutRoundOff = $grandTotal - $roundOff;

        // dd(
        //     $request->all(),
        //     'discount ' . $discount,
        //     'deliveryCost ' . $deliveryCost,
        //     'couponCode ' . $couponCode,
        //     'total ' . $total,
        //     'grandTotal ' . $grandTotal,
        //     'roundOff ' . $roundOff,
        //     'grandTotalwithoutRoundOff ' . $grandTotalwithoutRoundOff
        // );

        $orderId = DB::table('orders')->insertGetId([
            'order_no' => time() . rand(100, 999),
            'order_from' => 1,
            'user_id' => Auth::guard('customer')->check() ? Auth::guard('customer')->user()->id : null,
            'order_date' => date("Y-m-d H:i:s"),
            'estimated_dd' => date('Y-m-d', strtotime("+7 day", strtotime(date("Y-m-d")))),
            'delivery_method' => $request->delivery_method,
            'outlet_id' => $request->delivery_method == 2 ? $request->outlet_id : null,
            'payment_method' => 1,
            'payment_status' => 0,
            'trx_id' => time() . str::random(5),
            'order_status' => 0,
            'sub_total' => $total,
            'coupon_code' => $couponCode,
            'discount' => $discount,
            'delivery_fee' => $request->delivery_method == 1 ? $deliveryCost : 0,
            'vat' => 0,
            'tax' => 0,
            // 'total' => $request->delivery_method == 1 ? $total + $deliveryCost - $discount : $total - $discount,
            'total' => $grandTotalwithoutRoundOff,
            'round_off' => $roundOff ?? 0,
            'order_note' => $request->special_note,
            'complete_order' => 1,
            'slug' => str::random(5) . time(),
            'created_at' => Carbon::now()
        ]);


        foreach (session('cart') as $id => $details) {

            $productInfo = DB::table('products')->where('id', $id)->first();

            // Check if this is a package product
            if (isset($details['is_package']) && $details['is_package']) {
                // Handle package stock deduction
                $packageId = $details['product_id'] ?? $id;

                // Add package order detail (package as single item)
                DB::table('order_details')->insert([
                    'order_id' => $orderId,
                    'product_id' => $packageId,

                    // Package doesn't have variants at the package level
                    'color_id' => null,
                    'region_id' => null,
                    'sim_id' => null,
                    'size_id' => null,
                    'storage_id' => null,
                    'warrenty_id' => null,
                    'device_condition_id' => null,

                    'qty' => $details['quantity'],
                    'unit_id' => $productInfo->unit_id,
                    'unit_price' => $details['discount_price'] > 0 ? $details['discount_price'] : $details['price'],
                    'total_price' => ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity'],
                    'created_at' => Carbon::now()
                ]);

                // Get package items to reduce their stock
                $packageItems = DB::table('package_product_items')
                    ->join('products', 'package_product_items.product_id', '=', 'products.id')
                    ->select('package_product_items.*', 'products.stock as product_stock')
                    ->where('package_product_items.package_product_id', $packageId)
                    ->get();

                // Reduce stock for each item in the package
                foreach ($packageItems as $packageItem) {
                    $requiredQuantity = $packageItem->quantity * $details['quantity'];

                    // Check if package item has variants (color/size)
                    if ($packageItem->color_id || $packageItem->size_id) {
                        // Reduce variant stock
                        $variantQuery = DB::table('product_variants')
                            ->where('product_id', $packageItem->product_id);

                        if ($packageItem->color_id) {
                            $variantQuery->where('color_id', $packageItem->color_id);
                        }
                        if ($packageItem->size_id) {
                            $variantQuery->where('size_id', $packageItem->size_id);
                        }

                        $variant = $variantQuery->first();
                        if ($variant && $variant->stock >= $requiredQuantity) {
                            // Reduce variant stock
                            DB::table('product_variants')->where('id', $variant->id)->update([
                                'stock' => $variant->stock - $requiredQuantity
                            ]);
                        }
                    }

                    // Always reduce main product stock
                    if ($packageItem->product_stock >= $requiredQuantity) {
                        DB::table('products')->where('id', $packageItem->product_id)->update([
                            'stock' => $packageItem->product_stock - $requiredQuantity
                        ]);
                    }
                }
            } else {
                // Handle regular product stock deduction (existing logic)

                // stock out operation start
                if ($details['color_id'] || $details['size_id']) {

                    $productVariantQuery = DB::table('product_variants')->where('product_id', $productInfo->id);
                    if ($details['color_id']) {
                        $productVariantQuery->where('color_id', $details['color_id']);
                    }
                    if ($details['size_id']) {
                        $productVariantQuery->where('size_id', $details['size_id']);
                    }
                    $productVariant = $productVariantQuery->first();

                    if ($productVariant->stock >= $details['quantity']) {
                        DB::table('order_details')->insert([
                            'order_id' => $orderId,
                            'product_id' => $id,

                            // VARIANT
                            'color_id' => $details['color_id'],
                            'region_id' => null,
                            'sim_id' => null,
                            'size_id' => $details['size_id'],
                            'storage_id' => null,
                            'warrenty_id' => null,
                            'device_condition_id' => null,

                            'qty' => $details['quantity'],
                            'unit_id' => $productInfo->unit_id,
                            'unit_price' => $details['discount_price'] > 0 ? $details['discount_price'] : $details['price'],
                            'total_price' => ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity'],
                            'created_at' => Carbon::now()
                        ]);

                        DB::table('product_variants')->where('id', $productVariant->id)->update([
                            'stock' => $productVariant->stock - $details['quantity']
                        ]);
                        DB::table('products')->where('id', $id)->update([
                            'stock' => $productInfo->stock - $details['quantity'],
                        ]);
                    }
                } else {

                    if ($productInfo->stock >= $details['quantity']) {
                        DB::table('order_details')->insert([
                            'order_id' => $orderId,
                            'product_id' => $id,

                            // VARIANT
                            'color_id' => $details['color_id'],
                            'region_id' => null,
                            'sim_id' => null,
                            'size_id' => $details['size_id'],
                            'storage_id' => null,
                            'warrenty_id' => null,
                            'device_condition_id' => null,

                            'qty' => $details['quantity'],
                            'unit_id' => $productInfo->unit_id,
                            'unit_price' => $details['discount_price'] > 0 ? $details['discount_price'] : $details['price'],
                            'total_price' => ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity'],
                            'created_at' => Carbon::now()
                        ]);

                        DB::table('products')->where('id', $id)->update([
                            'stock' => $productInfo->stock - $details['quantity'],
                        ]);
                    }
                }
                // stock out operation end
            }
        }

        $shippingDistrictInfo = DB::table('districts')->where('id', $request->shipping_district_id)->first();
        $shippingThanaInfo = DB::table('upazilas')->where('id', $request->shipping_thana_id)->first();
        DB::table('shipping_infos')->insert([
            'order_id' => $orderId,
            'full_name' => $request->name ?? '',
            'phone' => $request->phone,
            'email' => $request->email ?? '',
            'gender' => null,
            'address' => $request->shipping_address ?? '',
            'thana' => $shippingThanaInfo->name ?? '',
            'post_code' => $request->shipping_postal_code ?? '',
            'city' => $shippingDistrictInfo->name ?? '',
            'country' => 'Bangladesh',
            'created_at' => Carbon::now()
        ]);

        // if user logged in
        if (Auth::user()) {
            // updating null phone number after first registration
            if (Auth::user()->phone == '' || Auth::user()->phone == null) {
                DB::table('users')->where('id', Auth::user()->id)->update([
                    'phone' => $request->phone,
                ]);
            }

            // updating null address after first registration
            if (DB::table('user_addresses')->where('user_id', Auth::user()->id)->count() <= 0) {
                DB::table('user_addresses')->insert([
                    'user_id' => Auth::user()->id,
                    'address_type' => 'Home',
                    'name' => $request->name,
                    'address' => $request->shipping_address,
                    'country' => 'Bangladesh',
                    'city' => $shippingDistrictInfo ? $shippingDistrictInfo->name : '',
                    'state' => $shippingThanaInfo ? $shippingThanaInfo->name : '',
                    'post_code' => $request->shipping_postal_code,
                    'phone' => $request->phone,
                    'slug' => str::random(5) . time(),
                    'created_at' => Carbon::now()
                ]);
            }
        }

        DB::table('billing_addresses')->insert([
            'order_id' => $orderId,
            'address' => $request->shipping_address ?? '', //$request->billing_address,
            'post_code' => $request->shipping_postal_code ?? '', //$request->billing_postal_code,
            'thana' => $shippingThanaInfo->name ?? '', //$billingThanaInfo->name,
            'city' => $shippingDistrictInfo->name ?? '', //$billingDistrictInfo->name,
            'country' => 'Bangladesh',
            'created_at' => Carbon::now()
        ]);

        if ($request->payment_method == 'cod') {

            $orderInfo = DB::table('orders')->where('id', $orderId)->first();
            DB::table('order_payments')->insert([
                'order_id' => $orderId,
                'payment_through' => "COD",
                'tran_id' => $orderInfo->trx_id,
                'val_id' => NULL,
                'amount' => $orderInfo->total,
                'card_type' => NULL,
                'store_amount' => $orderInfo->total,
                'card_no' => NULL,
                'status' => "VALID",
                'tran_date' => date("Y-m-d H:i:s"),
                'currency' => "BDT",
                'card_issuer' => NULL,
                'card_brand' => NULL,
                'card_sub_brand' => NULL,
                'card_issuer_country' => NULL,
                'created_at' => Carbon::now()
            ]);

            // Log referral activities for ecommerce orders (since raw DB insert doesn't trigger observer)
            $this->logReferralActivitiesForOrder($orderId);

            $this->sendOrderEmail($request->email, $orderInfo);
            session()->forget('coupon');
            session()->forget('discount');
            session()->forget('delivery_cost');
            session()->forget('cart');

            // Redirect authenticated users to their orders page, guests to order preview
            if (Auth::guard('customer')->check()) {
                return redirect('/my/orders')->with('success', 'Order placed successfully!');
            }
            return redirect('order/' . $orderInfo->slug);
        }

        if ($request->payment_method == 'sslcommerz') {
            session([
                'order_id' => $orderId,
                'customer_name' => $request->name,
                'customer_email' => $request->email,
            ]);
            return redirect('sslcommerz/order');
        }
    }

    // public static function sendOrderEmail($userEmail, $orderInfo){
    //     try {
    //         $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();
    //         if($emailConfig && $userEmail){
    //             $decryption = "";
    //             if($emailConfig){

    //                 $ciphering = "AES-128-CTR";
    //                 $options = 0;
    //                 $decryption_iv = '1234567891011121';
    //                 $decryption_key = "GenericCommerceV1";
    //                 $decryption = openssl_decrypt ($emailConfig->password, $ciphering, $decryption_key, $options, $decryption_iv);

    //                 config([
    //                     // 'mail.mailers.smtp.host' => $emailConfig->host,
    //                     // 'mail.mailers.smtp.port' => $emailConfig->port,
    //                     'mail.mailers.smtp.username' => $emailConfig->email,
    //                     'mail.mailers.smtp.password' => $decryption != "" ? $decryption : '',
    //                     // 'mail.mailers.smtp.encryption' => $emailConfig ? ($emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : '')) : '',
    //                     'mail.from.name' => $emailConfig->mail_from_name,
    //                 ]);

    //                 Mail::to(trim($userEmail))->send(new OrderPlacedEmail($orderInfo));
    //             }
    //         }

    //     } catch(\Exception $e) {
    //         // write code for handling error from here
    //     }
    // }

    public static function sendOrderEmail($userEmail, $orderInfo)
    {
        try {
            $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();

            if (!$emailConfig) {
                \Log::error('❌ No active email configuration found.');
                return;
            }

            // if ($emailConfig && $userEmail) {
            //     $ciphering = "AES-128-CTR";
            //     $options = 0;
            //     $decryption_iv = '1234567891011121';
            //     $decryption_key = "GenericCommerceV1";
            //     $decryption = openssl_decrypt(
            //         $emailConfig->password,
            //         $ciphering,
            //         $decryption_key,
            //         $options,
            //         $decryption_iv
            //     );

            config([
                'mail.mailers.smtp.host' => $emailConfig->host,
                'mail.mailers.smtp.port' => $emailConfig->port,
                'mail.mailers.smtp.username' => $emailConfig->email,
                'mail.mailers.smtp.password' => $emailConfig->password,
                'mail.mailers.smtp.encryption' => $emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : null),
                'mail.from.address' => $emailConfig->email,
                'mail.from.name' => $emailConfig->mail_from_name,
            ]);

            Mail::to(trim($userEmail))->send(new OrderPlacedEmail($orderInfo));
        } catch (\Exception $e) {
            \Log::error('Order email sending failed: ' . $e->getMessage());
        }
    }



    public function orderPreview($slug)
    {

        $orderInfo = DB::table('orders')->where('orders.slug', $slug)->first();

        if ($orderInfo) {

            // for data layer start
            $orderdItems = DB::table('order_details')
                ->join('orders', 'order_details.order_id', 'orders.id')
                ->join('products', 'order_details.product_id', 'products.id')
                ->leftJoin('brands', 'products.brand_id', 'brands.id')
                ->leftJoin('categories', 'products.category_id', 'categories.id')
                ->select('products.name as product_name', 'order_details.product_id', 'order_details.total_price', 'brands.name as brand_name', 'categories.name as category_name', 'order_details.qty')
                ->where('orders.id', $orderInfo->id)
                ->get();

            $shippingInfo = DB::table('shipping_infos')->where('order_id', $orderInfo->id)->first();
            $billingInfo = DB::table('billing_addresses')->where('order_id', $orderInfo->id)->first();
            // for data layer end

            return view($this->rootRoute . 'order_preview', compact('orderInfo', 'orderdItems', 'shippingInfo', 'billingInfo'));
        } else {
            Toastr::error('No Order Found');
            return redirect('/');
        }
    }



    public function cancelOrder($slug)
    {
        $data = DB::table('orders')->where('slug', $slug)->first();

        if (!$data) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        DB::table('orders')->where('slug', $slug)->update([
            'order_status' => 6,
            'payment_status' => 2,
            'updated_at' => Carbon::now()
        ]);

        $order_details = DB::table('order_details')->where('order_id', $data->id)->select('product_id', 'qty')->get();

        foreach ($order_details as $order_detail) {
            DB::table('products')->where('id', $order_detail->product_id)->increment('stock', $order_detail->qty);
        }

        DB::table('order_progress')->insert([
            'order_id' => $data->id,
            'order_status' => 6,
            'created_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }

    public function removeCoupon(Request $request)
    {
        // Remove coupon from session
        session()->forget(['coupon', 'discount', 'original_subtotal', 'coupon_type', 'coupon_minimum_order_amount']);

        // Get updated order total and coupon section for response
        $checkoutTotalAmount = view($this->baseRoute . 'order_total')->render();
        $checkoutCoupon = view($this->baseRoute . 'coupon')->render();

        return response()->json([
            'message' => 'Coupon removed successfully',
            'status' => 1,
            'checkoutTotalAmount' => $checkoutTotalAmount,
            'checkoutCoupon' => $checkoutCoupon
        ]);
    }

    /**
     * Log referral activities for an ecommerce order
     * 
     * Called after order creation since raw DB inserts don't trigger Eloquent observers
     * 
     * @param int $orderId
     * @return void
     */
    protected function logReferralActivitiesForOrder(int $orderId): void
    {
        try {
            // Get the order using Eloquent model
            $order = Order::find($orderId);

            if (!$order) {
                Log::warning('Ecommerce order not found for referral activity logging', [
                    'order_id' => $orderId
                ]);
                return;
            }

            // Check if order has a customer
            if (!$order->user_id) {
                Log::info('Ecommerce order has no customer, skipping referral activity logging', [
                    'order_id' => $orderId,
                    'order_no' => $order->order_no
                ]);
                return;
            }

            Log::info('Logging referral activities for ecommerce order', [
                'order_id' => $orderId,
                'order_no' => $order->order_no,
                'user_id' => $order->user_id,
            ]);

            // Log referral activities
            $activityIds = ReferralActivityLogger::logOrderActivity($order);

            if (count($activityIds) > 0) {
                Log::info('Referral activities created for ecommerce order', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'activities_count' => count($activityIds),
                    'activity_ids' => $activityIds
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't throw exception to prevent blocking order completion
            Log::error('Error logging referral activities for ecommerce order', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
