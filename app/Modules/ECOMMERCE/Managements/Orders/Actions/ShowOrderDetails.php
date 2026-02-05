<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\ShippingInfo;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\BillingAddress;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class ShowOrderDetails
{
    public static function execute(string $slug)
    {
        $order = Order::where('slug', $slug)->with('orderDeliveryMen')->first();

        $userInfo = User::where('id', $order->user_id)->first();
        $shippingInfo = ShippingInfo::where('order_id', $order->id)->first();
        $billingAddress = BillingAddress::where('order_id', $order->id)->first();

        $orderDetails = DB::table('order_details')
            ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('units', 'order_details.unit_id', '=', 'units.id')
            ->leftJoin('product_warehouses', 'order_details.warehouse_id', '=', 'product_warehouses.id')
            ->leftJoin('product_warehouse_rooms', 'order_details.warehouse_room_id', '=', 'product_warehouse_rooms.id')
            ->leftJoin('product_warehouse_room_cartoons', 'order_details.warehouse_room_cartoon_id', '=', 'product_warehouse_room_cartoons.id')
            ->leftJoin('product_variants', function($join) {
                $join->on('product_variants.product_id', '=', 'order_details.product_id')
                     ->on('product_variants.color_id', '=', 'order_details.color_id')
                     ->on(function($query) {
                         $query->on('product_variants.size_id', '=', 'order_details.size_id')
                               ->orWhereNull('order_details.size_id');
                     });
            })
            ->select(
                'order_details.*',
                'products.name as product_name',
                'products.is_package',
                'products.image as product_image',
                'product_variants.image as variant_image',
                'units.name as unit_name',
                'categories.name as category_name',
                'product_warehouses.title as warehouse_title',
                'product_warehouse_rooms.title as warehouse_room_title',
                'product_warehouse_room_cartoons.title as warehouse_room_cartoon_title'
            )
            ->where('order_details.order_id', $order->id)
            ->get();

        // Process variant information
        foreach ($orderDetails as $detail) {
            if ($detail->color_id) {
                $detail->color_name = DB::table('colors')->where('id', $detail->color_id)->value('name');
            }
            if ($detail->storage_id) {
                $storage = DB::table('storage_types')->where('id', $detail->storage_id)->first(['ram', 'rom']);
                $detail->storage_info = $storage ? $storage->ram . '/' . $storage->rom : null;
            }
            if ($detail->sim_id) {
                $detail->sim_name = DB::table('sims')->where('id', $detail->sim_id)->value('name');
            }
            if ($detail->region_id) {
                $detail->region_name = DB::table('country')->where('id', $detail->region_id)->value('name');
            }
            if ($detail->warrenty_id) {
                $detail->warranty_name = DB::table('product_warrenties')->where('id', $detail->warrenty_id)->value('name');
            }
            if ($detail->device_condition_id) {
                $detail->device_condition_name = DB::table('device_conditions')->where('id', $detail->device_condition_id)->value('name');
            }
            if ($detail->size_id) {
                $detail->size_name = DB::table('product_sizes')->where('id', $detail->size_id)->value('name');
            }
        }

        $generalInfo = DB::table('general_infos')->select('logo', 'logo_dark', 'company_name', 'fav_icon', 'guest_checkout')->first();
        $delivery_man = User::where('user_type', 4)->get();

        // Prepare data for view
        $orderStatuses = Order::getOrderStatuses();
        $availableStatuses = $order->availableStatuses;

        $statusConstants = [
            'STATUS_DISPATCH' => Order::STATUS_DISPATCH,
            'STATUS_INTRANSIT' => Order::STATUS_INTRANSIT,
            'STATUS_CANCELLED' => Order::STATUS_CANCELLED,
            'STATUS_DELIVERED' => Order::STATUS_DELIVERED,
            'STATUS_RETURN' => Order::STATUS_RETURN,
        ];

        // Prepare badges
        $deliveryMethodBadge = self::getDeliveryMethodBadge($order->delivery_method);
        $paymentMethodBadge = self::getPaymentMethodBadge($order->payment_method);
        $paymentStatusBadge = self::getPaymentStatusBadge($order->payment_status);

        return compact(
            'order',
            'shippingInfo',
            'billingAddress',
            'orderDetails',
            'userInfo',
            'generalInfo',
            'delivery_man',
            'orderStatuses',
            'availableStatuses',
            'statusConstants',
            'deliveryMethodBadge',
            'paymentMethodBadge',
            'paymentStatusBadge'
        );
    }

    private static function getDeliveryMethodBadge($method)
    {
        if ($method == Order::DELIVERY_HOME) {
            return '<span class="badge badge-soft-success" style="padding: 3px 5px !important;">Home Delivery</span>';
        } elseif ($method == Order::DELIVERY_STORE_PICKUP) {
            return '<span class="badge badge-soft-success" style="padding: 3px 5px !important;">Store Pickup</span>';
        }
        return '';
    }

    private static function getPaymentMethodBadge($method)
    {
        if ($method == null) {
            return '<span class="badge badge-soft-danger" style="padding: 2px 10px !important;">Unpaid</span>';
        } elseif ($method == Order::PAYMENT_COD) {
            return '<span class="badge badge-soft-info" style="padding: 2px 10px !important;">COD</span>';
        } elseif ($method == Order::PAYMENT_BKASH) {
            return '<span class="badge badge-soft-success" style="padding: 2px 10px !important;">bKash</span>';
        } elseif ($method == Order::PAYMENT_NAGAD) {
            return '<span class="badge badge-soft-success" style="padding: 2px 10px !important;">Nagad</span>';
        }
        return '<span class="badge badge-soft-success" style="padding: 2px 10px !important;">Card</span>';
    }

    private static function getPaymentStatusBadge($status)
    {
        if ($status == Order::PAYMENT_STATUS_UNPAID) {
            return '<span class="badge badge-soft-warning" style="padding: 2px 10px !important;">Unpaid</span>';
        } elseif ($status == Order::PAYMENT_STATUS_PAID) {
            return '<span class="badge badge-soft-success" style="padding: 2px 10px !important;">Paid</span>';
        }
        return '<span class="badge badge-soft-danger" style="padding: 2px 10px !important;">Failed</span>';
    }
}
