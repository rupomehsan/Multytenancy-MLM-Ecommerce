<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderDetails;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderPayment;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\ShippingInfo;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\BillingAddress;

class UpdateOrder
{
    public static function execute($request)
    {
        $orderInfo = Order::where('id', $request->order_id)->first();

        // order items
        if (isset($request->product_id)) {

            OrderDetails::where('order_id', $request->order_id)->delete();
            $index = 0;
            $totalOrderAmount = 0;
            foreach ($request->product_id as $product_id) {

                $color_id = isset($request->color_id[$index]) ? $request->color_id[$index] : '';
                $size_id = isset($request->size_id[$index]) ? $request->size_id[$index] : '';
                $region_id = isset($request->region_id[$index]) ? $request->region_id[$index] : '';
                $sim_id = isset($request->sim_id[$index]) ? $request->sim_id[$index] : '';
                $storage_id = isset($request->storage_id[$index]) ? $request->storage_id[$index] : '';
                $warrenty_id = isset($request->warrenty_id[$index]) ? $request->warrenty_id[$index] : '';
                $device_condition_id = isset($request->device_condition_id[$index]) ? $request->device_condition_id[$index] : '';

                OrderDetails::insert([
                    'order_id' => $request->order_id,
                    'product_id' => $product_id,
                    'color_id' => $color_id,
                    'size_id' => $size_id,
                    'region_id' => $region_id,
                    'sim_id' => $sim_id,
                    'storage_id' => $storage_id,
                    'warrenty_id' => $warrenty_id,
                    'device_condition_id' => $device_condition_id,
                    'unit_id' => $request->unit_id[$index],
                    'qty' => $request->qty[$index],
                    'unit_price' => $request->unit_price[$index],
                    'total_price' => $request->qty[$index] * $request->unit_price[$index],
                    'updated_at' => Carbon::now()
                ]);
                $totalOrderAmount = $totalOrderAmount + ($request->qty[$index] * $request->unit_price[$index]);
                $index++;
            }

            $orderInfo->sub_total = $totalOrderAmount;
            $orderInfo->total = $totalOrderAmount - $orderInfo->discount;
            $orderInfo->save();
        } else {
            Toastr::error('Sorry No Item Exists', 'Failed');
            return back();
        }

        // shipping info
        $shippingInfo = ShippingInfo::where('order_id', $request->order_id)->first();
        if ($shippingInfo) {

            $deliveryCharge = 100;
            $districtWiseDeliveryCharge = DB::table('districts')->select('delivery_charge')->where('name', strtolower(trim($request->shipping_city)))->first();
            if ($districtWiseDeliveryCharge) {
                $deliveryCharge = $districtWiseDeliveryCharge->delivery_charge;
            }

            $orderInfo->delivery_fee = $deliveryCharge;
            $orderInfo->total = $orderInfo->total + $deliveryCharge;
            $orderInfo->save();


            $shippingInfo->full_name = $request->shipping_name;
            $shippingInfo->phone = $request->shipping_phone;
            $shippingInfo->email = $request->shipping_email;
            $shippingInfo->address = $request->shipping_address;
            $shippingInfo->post_code = $request->shipping_post_code;
            $shippingInfo->city = $request->shipping_city;
            $shippingInfo->country = $request->shipping_country;
            $shippingInfo->thana = $request->shipping_thana;
            $shippingInfo->updated_at = Carbon::now();
            $shippingInfo->save();
        } else {

            $deliveryCharge = 100;
            $districtWiseDeliveryCharge = DB::table('districts')->select('delivery_charge')->where('name', strtolower(trim($request->shipping_city)))->first();
            if ($districtWiseDeliveryCharge) {
                $deliveryCharge = $districtWiseDeliveryCharge->delivery_charge;
            }

            $orderInfo->delivery_fee = $deliveryCharge;
            $orderInfo->total = $orderInfo->total + $deliveryCharge;
            $orderInfo->save();

            ShippingInfo::insert([
                'order_id' => $orderInfo->id,
                'full_name' => $request->shipping_name,
                'phone' => $request->shipping_phone,
                'email' => $request->shipping_email,
                'address' => $request->shipping_address,
                'post_code' => $request->shipping_post_code,
                'city' => $request->shipping_city,
                'country' => $request->shipping_country,
                'created_at' => Carbon::now()
            ]);
        }

        // billing info
        $billingInfo = BillingAddress::where('order_id', $request->order_id)->first();
        if ($billingInfo) {
            $billingInfo->address = $request->billing_address;
            $billingInfo->post_code = $request->billing_post_code;
            $billingInfo->city = $request->billing_city;
            $billingInfo->country = $request->billing_country;
            $billingInfo->thana = $request->billing_thana;
            $billingInfo->updated_at = Carbon::now();
            $billingInfo->save();
        } else {
            BillingAddress::insert([
                'order_id' => $orderInfo->id,
                'address' => $request->billing_address,
                'post_code' => $request->billing_post_code,
                'city' => $request->billing_city,
                'country' => $request->billing_country,
                'created_at' => Carbon::now()
            ]);
        }

        if (isset($request->payment_method) && $request->payment_method == 1) {
            $orderInfo->bank_tran_id = "Not Available (COD)";
            $orderInfo->payment_method = Order::PAYMENT_COD;
            $orderInfo->payment_status = Order::PAYMENT_STATUS_PAID;
            $orderInfo->save();

            OrderPayment::insert([
                'order_id' => $orderInfo->id,
                'payment_through' => "COD",
                'tran_id' => $orderInfo->tran_id,
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
        }

        Toastr::success('Order Information Updated', 'Success');
        return back();
    }
}
