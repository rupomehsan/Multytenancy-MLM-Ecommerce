<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderProgress;

class ApproveOrder
{
    public static function execute(string $slug)
    {
        $data = Order::where('slug', $slug)->first();
        $data->order_status = Order::STATUS_APPROVED;
        $data->updated_at = Carbon::now();
        $data->save();

        OrderProgress::insert([
            'order_id' => $data->id,
            'order_status' => Order::STATUS_APPROVED,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['success' => 'Order Approved successfully.']);
    }
}
