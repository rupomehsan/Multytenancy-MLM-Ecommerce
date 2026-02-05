<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class ViewAllTrashedOrders
{
    public static function execute(Request $request)
    {
        $data = Order::onlyTrashed()
            ->leftJoin('shipping_infos', 'shipping_infos.order_id', '=', 'orders.id')
            ->leftJoin('order_details', 'order_details.order_id', '=', 'orders.id')
            ->select(
                'orders.*',
                'shipping_infos.full_name as customer_name',
                'shipping_infos.email as customer_email',
                'shipping_infos.phone as customer_phone',
                'order_details.qty as quantity'
            )
            ->orderByDesc('orders.id')
            ->get();

        return Datatables::of($data)
            ->editColumn('order_status', function ($data) {
                if ($data->order_status == 0) {
                    return '<span class="alert alert-warning" style="padding: 2px 10px !important;">Pending</span>';
                } elseif ($data->order_status == 1) {
                    return '<span class="alert alert-info" style="padding: 2px 10px !important;">Approved</span>';
                } elseif ($data->order_status == 2) {
                    return '<span class="alert alert-primary" style="padding: 2px 10px !important;">Dispatch</span>';
                } elseif ($data->order_status == 3) {
                    return '<span class="alert alert-secondary" style="padding: 2px 10px !important;">Intransit</span>';
                } elseif ($data->order_status == 4) {
                    return '<span class="alert alert-success" style="padding: 2px 10px !important;">Delivered</span>';
                } elseif ($data->order_status == 5) {
                    return '<span class="alert alert-dark" style="padding: 2px 10px !important;">Return</span>';
                } else {
                    return '<span class="alert alert-danger" style="padding: 2px 10px !important;">Cancelled</span>';
                }
            })
            ->editColumn('payment_method', function ($data) {
                if ($data->payment_method == NULL) {
                    return '<span class="alert alert-danger" style="padding: 2px 10px !important;">Unpaid</span>';
                } elseif ($data->payment_method == 1) {
                    return '<span class="alert alert-info" style="padding: 2px 10px !important;">COD</span>';
                } elseif ($data->payment_method == 2) {
                    return '<span class="alert alert-success" style="padding: 2px 10px !important;">bKash</span>';
                } elseif ($data->payment_method == 3) {
                    return '<span class="alert alert-success" style="padding: 2px 10px !important;">Nagad</span>';
                } else {
                    return '<span class="alert alert-success" style="padding: 2px 10px !important;">Card</span>';
                }
            })
            ->editColumn('payment_status', function ($data) {
                if ($data->payment_status == 0) {
                    return '<span class="alert alert-danger" style="padding: 2px 10px !important;">Unpaid</span>';
                } elseif ($data->payment_status == 1) {
                    return '<span class="alert alert-success" style="padding: 2px 10px !important;">Paid</span>';
                } else {
                    return '<span class="alert alert-danger" style="padding: 2px 10px !important;">Failed</span>';
                }
            })
            ->editColumn('total', function ($data) {
                return "৳ " . number_format($data->total, 2);
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = '';
                if (Auth::user()->user_type == 1) {
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" data-id="' . $data->slug . '" data-original-title="Delete" class="d-inline-block btn-sm btn-danger rounded deleteBtn"><i class="fas fa-undo"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'order_status', 'payment_method', 'payment_status'])
            ->make(true);
    }
}
