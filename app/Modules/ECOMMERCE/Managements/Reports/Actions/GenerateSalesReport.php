<?php

namespace App\Modules\ECOMMERCE\Managements\Reports\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class GenerateSalesReport
{
    public static function execute(Request $request)
    {
        $startDate = date("Y-m-d", strtotime(str_replace("/", "-", $request->start_date))) . " 00:00:00";
        $endDate = date("Y-m-d", strtotime(str_replace("/", "-", $request->end_date))) . " 23:59:59";
        $orderStatus = $request->order_status;
        $paymentStatus = $request->payment_status;
        $paymentMethod = $request->payment_method;

        $query = Order::query();
        $query->whereBetween('order_date', [$startDate, $endDate]);

        if ($orderStatus != '') {
            $query->where('order_status', $orderStatus);
        }
        if ($paymentStatus != '') {
            $query->where('payment_status', $paymentStatus);
        }
        if ($paymentMethod != '') {
            $query->where('payment_method', $paymentMethod);
        }
        $data = $query->orderBy('id', 'desc')->get();

        return [
            'status' => 'success',
            'data' => [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'orders' => $data
            ]
        ];
    }
}
