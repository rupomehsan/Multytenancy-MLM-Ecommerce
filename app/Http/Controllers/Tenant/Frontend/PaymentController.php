<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Gateways\SSLCommerz\SSLCommerz;


use App\Http\Controllers\Tenant\Frontend\CheckoutController;


use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function order()
    {
        //  DO YOU ORDER SAVING PROCESS TO DB OR ANYTHING
        $orderData = DB::table('orders')->where('id', session('order_id'))->first();
        $sslc = new SSLCommerz();
        $sslc->amount($orderData->total)
            ->trxid($orderData->trx_id)
            ->product('Products From Ecommerce')
            ->customer(session('customer_name'), session('customer_email'));

        return $sslc->make_payment();
    }
    public function paymentConfirm(request $request)
    {
        $orderId = $request->order_id;

        $shippingInfo = DB::table('shipping_infos')->where('order_id', $orderId)->first();

        //  Handle different payment methods
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

            CheckoutController::sendOrderEmail($shippingInfo->email, $orderInfo);
            return redirect('order/' . $orderInfo->slug);
        }

        if ($request->payment_method == 'sslcommerz') {
            session([
                'order_id' => $orderId,
                'customer_name' => $shippingInfo->full_name,
                'customer_email' => $shippingInfo->email,
            ]);
            return redirect('sslcommerz/order');
        }
    }

    public function success(Request $request)
    {
        $validate = SSLCommerz::validate_payment($request);
        if ($validate) {
            $bankID = $request->bank_tran_id;   //  KEEP THIS bank_tran_id FOR REFUNDING ISSUE
            //  Do the rest database saving works
            //  take a look at dd($request->all()) to see what you need

            $orderInfo = DB::table('orders')->where('trx_id', $request->tran_id)->first();

            DB::table('orders')->where('id', $orderInfo->id)->update([
                'payment_method' => 4,
                'payment_status' => 1,
                'order_status' => 1
            ]);

            DB::table('order_progress')->insert([
                'order_id' => $orderInfo->id,
                'order_status' => 1,
                'created_at' => Carbon::now()
            ]);

            DB::table('order_payments')->insert([
                'order_id' => $orderInfo->id,
                'payment_through' => "SSLCommerz",
                'tran_id' => $orderInfo->trx_id,
                'bank_tran_id' => $bankID,
                'val_id' => $request->val_id,
                'amount' => $orderInfo->total,
                'card_type' => $request->card_type,
                'store_amount' => $orderInfo->total,
                'card_no' => $request->card_no,
                'status' => "VALID",
                'tran_date' => date("Y-m-d H:i:s"),
                'currency' => "BDT",
                'card_issuer' => $request->card_issuer,
                'card_brand' => $request->card_brand,
                'card_sub_brand' => $request->card_sub_brand,
                'card_issuer_country' => $request->card_issuer_country,
                'created_at' => Carbon::now()
            ]);

            $shippingInfo = DB::table('shipping_infos')->where('order_id', $orderInfo->id)->first();
            if ($shippingInfo && $shippingInfo->email) {
                CheckoutController::sendOrderEmail($shippingInfo->email, $orderInfo);
            }

            session()->forget('customer_email');
            session()->forget('customer_name');
            session()->forget('coupon');
            session()->forget('discount');
            session()->forget('delivery_cost');
            session()->forget('cart');
            session()->forget('order_data');
            return redirect('order/' . $orderInfo->slug);
        }
    }

    public function failure(Request $request)
    {
        $auth = auth()->user();

        if (!$auth) {
            $this->cancel($request);
            return redirect('/login');
        }

        session()->put('order_failed', true);
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('trx_id', $tran_id)
            ->select('trx_id', 'payment_status', 'order_status', 'total')->first();

        if ($order_details->order_status == 0) {
            $update_product = DB::table('orders')
                ->where('trx_id', $tran_id)
                ->update(['order_status' => 0, 'payment_status' => 2, 'payment_method' => 4]); // 6 => Cancelled, 2 => Failed

            session()->forget('customer_email');
            session()->forget('customer_name');
            session()->forget('coupon');
            session()->forget('discount');
            session()->forget('delivery_cost');
            session()->forget('cart');
            session()->forget('order_data');

            Toastr::error('Transaction Cancled');
            return session('cart') && count(session('cart')) > 0
                ? redirect('/checkout')
                : redirect('/home');
        } else {
            Toastr::error('Transaction Cancled');
            Log::info('else log', []);
            return redirect('/checkout');
        }
    }

    public function cancel(Request $request)
    {
        session()->put('order_failed', true);
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('trx_id', $tran_id)
            ->select('trx_id', 'payment_status', 'order_status', 'total', 'id')->first();

        if ($order_details->order_status == 0) {
            // $update_product = DB::table('orders')
            //     ->where('trx_id', $tran_id)
            //     ->update(['order_status' => 6, 'payment_status' => 2, 'payment_method' => 4]); // 6 => Cancelled, 2 => Failed

            // Adjust stock for products and product_variants
            $orderItems = DB::table('order_details')
                ->where('order_id', $order_details->id)->get();

            foreach ($orderItems as $item) {
                // Check if product has variants
                $hasVariant = DB::table('products')
                    ->where('id', $item->product_id)
                    ->value('has_variant');

                if ($hasVariant) {
                    // Adjust variant stock
                    DB::table('product_variants')
                        ->where('product_id', $item->product_id)
                        ->when($item->color_id, function ($query) use ($item) {
                            return $query->where('color_id', $item->color_id);
                        })
                        ->when($item->size_id, function ($query) use ($item) {
                            return $query->where('size_id', $item->size_id);
                        })
                        ->increment('stock', $item->qty);
                } else {
                    // Adjust product stock
                    DB::table('products')
                        ->where('id', $item->product_id)
                        ->increment('stock', $item->qty);
                }
            }

            $deleteProduct = DB::table('orders')
                ->where('trx_id', $tran_id)
                ->delete();

            $orderProgress = DB::table('order_progress')
                ->where('order_id', $order_details->id)
                ->delete();

            $orderDetails = DB::table('order_details')
                ->where('order_id', $order_details->id)
                ->delete();

            $orderShipping = DB::table('shipping_infos')
                ->where('order_id', $order_details->id)
                ->delete();

            $orderBilling = DB::table('billing_addresses')
                ->where('order_id', $order_details->id)
                ->delete();

            $orderPayment = DB::table('order_payments')
                ->where('order_id', $order_details->id)
                ->delete();


            Toastr::error('Transaction Cancled');
            return session('cart') && count(session('cart')) > 0
                ? redirect('/checkout')
                : redirect('/home');
        } else {
            Toastr::error('Transaction Cancled');

            return redirect('/checkout');
        }
    }

    public function refund($bankID)
    {
        /**
         * SSLCommerz::refund($bank_trans_id, $amount [,$reason])
         */

        $refund = SSLCommerz::refund($bankID, 1500); // 1500 => refund amount

        if ($refund->status) {
            /**
             * States:
             * success : Refund request is initiated successfully
             * failed : Refund request is failed to initiate
             * processing : The refund has been initiated already
             */

            $state  = $refund->refund_state;

            /**
             * RefID will be used for post-refund status checking
             */

            $refID  = $refund->ref_id;

            /**
             *  To get all the outputs
             */

            dd($refund->output);
        } else {
            return $refund->message;
        }
    }

    public function check_refund_status($refID)
    {
        $refund = SSLCommerz::query_refund($refID);

        if ($refund->status) {
            /**
             * States:
             * refunded : Refund request has been proceeded successfully
             * processing : Refund request is under processing
             * cancelled : Refund request has been proceeded successfully
             */

            $state  = $refund->refund_state;

            /**
             * RefID will be used for post-refund status checking
             */

            $refID  = $refund->ref_id;

            /**
             *  To get all the outputs
             */

            dd($refund->output);
        } else {
            return $refund->message;
        }
    }

    public function get_transaction_status($trxID)
    {
        $query = SSLCommerz::query_transaction($trxID);

        if ($query->status) {
            dd($query->output);
        } else {
            $query->message;
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
