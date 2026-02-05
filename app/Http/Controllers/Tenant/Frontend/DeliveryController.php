<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    public function deliveryOrders()
    {
        $userId = Auth::user()->id;
        $order_status = request()->order_status ?? '';

        $query = DB::table('order_delivey_men')
            ->join('orders', 'order_delivey_men.order_id', '=', 'orders.id')
            ->where('order_delivey_men.delivery_man_id', $userId)
            ->orderBy('order_delivey_men.id', 'desc')
            ->select('order_delivey_men.*', 'orders.*');

        // Apply status filter if provided
        if ($order_status !== '') {
            $query->where('order_delivey_men.status', $order_status);
        }

        $orders = $query->orderBy('orders.id', 'desc')->paginate(10);

        return view('dashboard.delivery.orders', [
            'orders' => $orders,
            'order_status' => $order_status,
        ]);
    }

    public function updateStatus()
    {

        // Validate the request
        request()->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'order_status' => 'required|string|in:pending,accepted,rejected,delivered,returned'
        ]);

        $orderId = request()->order_id;
        $status = request()->order_status;

        // Update the order status
        DB::table('order_delivey_men')
            ->where('order_id', $orderId)
            ->update([
                'status' => $status,
                'updated_at' => now(),
            ]);

        if ($status === 'accepted') {
            DB::table('orders')
                ->where('id', $orderId)
                ->update([
                    'order_status' => 3, // Assuming 3 is the status code for 'intransit'
                    'updated_at' => now(),
                ]);

            DB::table('order_progress')->insert([
                'order_id' => $orderId,
                'order_status' => 3,
                'created_at' => Carbon::now()
            ]);
        }

        // If the status is 'delivered', update the order status in the orders table
        if ($status === 'delivered') {
            DB::table('orders')
                ->where('id', $orderId)
                ->update([
                    'order_status' => 4, // Assuming 4 is the status code for 'delivered'
                    'payment_status' => 1, // Assuming payment is marked as paid on delivery
                    'updated_at' => now(),
                ]);
            DB::table('order_progress')->insert([
                'order_id' => $orderId,
                'order_status' => 4,
                'created_at' => Carbon::now()
            ]);
        }

        if ($status === 'returned') {
            DB::table('orders')
                ->where('id', $orderId)
                ->update([
                    'order_status' => 5, // Assuming 5 is the status code for 'returned'
                    'updated_at' => now(),
                ]);
            DB::table('order_progress')->insert([
                'order_id' => $orderId,
                'order_status' => 5,
                'created_at' => Carbon::now()
            ]);
        }

        // Redirect back with success message
        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
