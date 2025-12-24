<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Account\AccountsHelper;
use App\Http\Controllers\Account\Models\AccountsConfiguration;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderProgress;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;

class UpdateOrderInfo
{
    public static function execute(Request $request)
    {
        $data = Order::where('id', $request->order_id)->first();

        if (!$data) {
            Toastr::error('Order not found', 'Error');
            return redirect()->back();
        }

        // Validate delivery man requirement
        if ($request->order_status == Order::STATUS_DISPATCH && !$request->delivery_man_id) {
            Toastr::error('Delivery Man is required when setting status to Dispatch', 'Error');
            return redirect()->back();
        }

        if ($request->order_status) {
            // Store old status for logging
            $oldStatus = $data->order_status;

            // Handle COD delivery
            if ($request->order_status == Order::STATUS_DELIVERED && $data->payment_method == Order::PAYMENT_COD) {
                $data->payment_status = 1;
                self::generateVoucher($data);
            }

            $data->order_remarks = $request->order_remarks;

            // Handle cancellation
            if ($request->order_status == Order::STATUS_CANCELLED) {
                self::restoreStock($data->id);
            }

            // Update order status and estimated delivery date
            // IMPORTANT: Set order_status to trigger Observer for MLM commission distribution
            $data->order_status = $request->order_status;
            $data->estimated_dd = $request->estimated_dd;
            // Don't manually set updated_at - let Laravel handle it automatically
            // This ensures proper change tracking for the observer
            $saved = $data->save();

            // Log the update for debugging
            \Log::info('Order status update attempt', [
                'order_id' => $data->id,
                'order_no' => $data->order_no,
                'old_status' => $oldStatus,
                'new_status' => $request->order_status,
                'saved' => $saved,
                'changes' => $data->getChanges(),
            ]);

            OrderProgress::insert([
                'order_id' => $request->order_id,
                'order_status' => $request->order_status ?? $data->order_status,
                'created_at' => Carbon::now()
            ]);

            // Update delivery man
            self::updateDeliveryMan($request->order_id, $request->delivery_man_id);
        } else {
            $data->order_remarks = $request->order_remarks;
            $data->estimated_dd = $request->estimated_dd;
            $data->save();
        }

        Toastr::success('Order Information Updated', 'Success');
        return redirect()->back();
    }

    private static function generateVoucher($order)
    {
        try {
            $cashLedger = AccountsConfiguration::where(function ($q) {
                $q->where('account_type', 'Cash')
                    ->orWhere('account_name', 'like', '%Cash%');
            })->where('is_active', 1)->first();

            $salesLedger = AccountsConfiguration::where(function ($q) {
                $q->where('account_type', 'Sales')
                    ->orWhere('account_name', 'like', '%Sales%');
            })->where('is_active', 1)->first();

            if ($cashLedger && $salesLedger) {
                $voucherData = [
                    'voucher_no' => 'RV-' . $order->order_no,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'debit_ledger_id' => $cashLedger->id,
                    'credit_ledger_id' => $salesLedger->id,
                    'amount' => $order->total,
                    'narration' => 'Cash received for Order #' . $order->order_no,
                    'reference_no' => $order->order_no,
                ];

                $result = AccountsHelper::receiveVoucherStore($voucherData);
                if (!$result['success']) {
                    Toastr::error('Voucher generation failed', 'Error');
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Voucher generation failed: ' . $e->getMessage(), 'Error');
        }
    }

    private static function restoreStock($orderId)
    {
        $order_details = DB::table('order_details')->where('order_id', $orderId)->select('product_id', 'qty')->get();

        foreach ($order_details as $order_detail) {
            $product = Product::find($order_detail->product_id);
            if ($product) {
                $product->increment('stock', $order_detail->qty);
            }
        }
    }

    private static function updateDeliveryMan($orderId, $deliveryManId)
    {
        $existingDeliveryMan = DB::table('order_delivey_men')->where('order_id', $orderId)->first();

        if ($existingDeliveryMan) {
            DB::table('order_delivey_men')
                ->where('order_id', $orderId)
                ->update([
                    'delivery_man_id' => $deliveryManId,
                    'status' => 'pending',
                ]);
        } else {
            DB::table('order_delivey_men')->insert([
                'order_id' => $orderId,
                'delivery_man_id' => $deliveryManId,
                'status' => 'pending',
            ]);
        }
    }
}
