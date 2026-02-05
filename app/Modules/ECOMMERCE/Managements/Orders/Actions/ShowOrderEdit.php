<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\ShippingInfo;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\BillingAddress;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class ShowOrderEdit
{
    public static function execute($slug)
    {
        $order = Order::where('slug', $slug)->first();
        $userInfo = User::where('id', $order->user_id)->first();
        $shippingInfo = ShippingInfo::where('order_id', $order->id)->first();
        $billingAddress = BillingAddress::where('order_id', $order->id)->first();

        $orderDetails = DB::table('order_details')
            ->leftJoin('products', 'order_details.product_id', 'products.id')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('units', 'order_details.unit_id', 'units.id')
            ->select('order_details.*', 'products.name as product_name', 'units.name as unit_name', 'categories.name as category_name')
            ->where('order_id', $order->id)
            ->get();

        $generalInfo = DB::table('general_infos')->select('logo', 'logo_dark', 'company_name', 'fav_icon', 'guest_checkout')->first();
        $districts = DB::table('districts')->get();
        $countries = DB::table('country')->get();
        $upazilas = DB::table('upazilas')->get();

        return compact('order', 'shippingInfo', 'billingAddress', 'orderDetails', 'userInfo', 'generalInfo', 'districts', 'countries', 'upazilas');
    }
}
