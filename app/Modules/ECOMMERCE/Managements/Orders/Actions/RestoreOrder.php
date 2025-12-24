<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class RestoreOrder
{
    public static function execute(string $slug)
    {
        $orderInfo = Order::withTrashed()->where('slug', $slug)->first();
        $orderInfo->restore();

        return response()->json(['success' => 'Order Restored Successfully.']);
    }
}
