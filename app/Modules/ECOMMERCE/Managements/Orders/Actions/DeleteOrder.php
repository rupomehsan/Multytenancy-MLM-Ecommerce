<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class DeleteOrder
{
    public static function execute(string $slug)
    {
        $orderInfo = Order::where('slug', $slug)->first();
        $orderInfo->delete();

        return response()->json(['success' => 'Order Deleted Successfully.']);
    }
}
