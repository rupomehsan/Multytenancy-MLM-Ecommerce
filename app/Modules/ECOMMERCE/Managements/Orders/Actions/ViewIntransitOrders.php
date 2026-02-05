<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class ViewIntransitOrders
{
    public static function execute($request)
    {
        $data = Order::where('order_status', Order::STATUS_INTRANSIT)->orderBy('id', 'desc')->get();

        return Datatables::of($data)
            ->editColumn('order_status', function ($data) {
                if ($data->order_status == Order::STATUS_PENDING) {
                    return '<span class="alert alert-warning" style="padding: 2px 10px !important;">Pending</span>';
                } elseif ($data->order_status == Order::STATUS_APPROVED) {
                    return '<span class="alert alert-info" style="padding: 2px 10px !important;">Approved</span>';
                } elseif ($data->order_status == Order::STATUS_DISPATCH) {
                    return '<span class="alert alert-primary" style="padding: 2px 10px !important;">Dispatch</span>';
                } elseif ($data->order_status == Order::STATUS_INTRANSIT) {
                    return '<span class="alert alert-secondary" style="padding: 2px 10px !important;">Intransit</span>';
                } elseif ($data->order_status == Order::STATUS_DELIVERED) {
                    return '<span class="alert alert-success" style="padding: 2px 10px !important;">Delivered</span>';
                } elseif ($data->order_status == Order::STATUS_RETURN) {
                    return '<span class="alert alert-dark" style="padding: 2px 10px !important;">Return</span>';
                } else {
                    return '<span class="alert alert-danger" style="padding: 2px 10px !important;">Cancelled</span>';
                }
            })
            ->editColumn('payment_method', function ($data) {
                if ($data->payment_method == NULL) {
                    return '<span class="alert alert-danger" style="padding: 2px 10px !important;">Unpaid</span>';
                } elseif ($data->payment_method == Order::PAYMENT_COD) {
                    return '<span class="alert alert-info" style="padding: 2px 10px !important;">COD</span>';
                } elseif ($data->payment_method == Order::PAYMENT_BKASH) {
                    return '<span class="alert alert-success" style="padding: 2px 10px !important;">bKash</span>';
                } elseif ($data->payment_method == Order::PAYMENT_NAGAD) {
                    return '<span class="alert alert-success" style="padding: 2px 10px !important;">Nagad</span>';
                } else {
                    return '<span class="alert alert-success" style="padding: 2px 10px !important;">Card</span>';
                }
            })
            ->editColumn('payment_status', function ($data) {
                if ($data->payment_status == Order::PAYMENT_STATUS_UNPAID) {
                    return '<span class="alert alert-danger" style="padding: 2px 10px !important;">Unpaid</span>';
                } elseif ($data->payment_status == Order::PAYMENT_STATUS_PAID) {
                    return '<span class="alert alert-success" style="padding: 2px 10px !important;">Paid</span>';
                } else {
                    return '<span class="alert alert-danger" style="padding: 2px 10px !important;">Failed</span>';
                }
            })
            ->editColumn('sub_total', function ($data) {
                return "৳ " . number_format($data->sub_total, 2);
            })
            ->editColumn('discount', function ($data) {
                return "৳ " . number_format($data->discount, 2);
            })
            ->editColumn('delivery_fee', function ($data) {
                return "৳ " . number_format($data->delivery_fee, 2);
            })
            ->editColumn('total', function ($data) {
                return "৳ " . number_format($data->total, 2);
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="' . url('admin/order/details') . '/' . $data->slug . '" title="Order Details" class="d-inline-block btn-sm btn-info rounded"><i class="fas fa-list-ul"></i></a>';

                if ($data->order_status == Order::STATUS_APPROVED) {
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Cancel" data-id="' . $data->slug . '" data-original-title="Delete" class="d-inline-block btn-sm btn-danger rounded cancelBtn"><i class="fa fa-times"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Approve" data-id="' . $data->slug . '" data-original-title="Delete" class="d-inline-block btn-sm btn-success rounded intransitBtn"><i class="fas fa-check"></i></a>';
                }
                if ($data->order_status == Order::STATUS_DISPATCH) {
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Deliver" data-id="' . $data->slug . '" data-original-title="Delete" class="d-inline-block btn-sm btn-success rounded deliveryBtn"><i class="fas fa-truck"></i></a>';
                }

                if (Auth::user()->user_type == 1) {
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" data-id="' . $data->slug . '" data-original-title="Delete" class="d-inline-block btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['action', 'order_status', 'payment_method', 'payment_status'])
            ->make(true);
    }
}
