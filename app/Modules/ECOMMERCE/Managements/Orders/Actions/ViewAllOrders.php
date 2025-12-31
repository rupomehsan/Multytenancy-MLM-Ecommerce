<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class ViewAllOrders
{


    public static function execute($request)
    {
        try {
            if ($request->ajax()) {

                // $data = DB::table('orders')
                //     ->leftJoin('shipping_infos', 'shipping_infos.order_id', '=', 'orders.id')
                //     ->leftJoin('order_details', 'order_details.order_id', '=', 'orders.id')
                //     ->select('orders.*', 'shipping_infos.full_name as customer_name', 'shipping_infos.email as customer_email', 'shipping_infos.phone as customer_phone', 'order_details.qty as quantity')
                //     ->orderBy('id', 'desc')
                //     ->whereNull('orders.deleted_at')
                //     ->get();

                $qtySub = DB::table('order_details')
                    ->select('order_id', DB::raw('SUM(qty) as total_qty'))
                    ->groupBy('order_id');

                // Subquery to get latest shipping_info per order
                $shippingSub = DB::table('shipping_infos as si1')
                    ->select('si1.*')
                    ->whereRaw('si1.id = (
                    SELECT MAX(si2.id)
                    FROM shipping_infos si2
                    WHERE si2.order_id = si1.order_id
                )');

                $data = DB::table('orders')
                    ->leftJoinSub($shippingSub, 'shipping_infos', function ($join) {
                        $join->on('shipping_infos.order_id', '=', 'orders.id');
                    })
                    ->leftJoinSub($qtySub, 'order_qty', function ($join) {
                        $join->on('order_qty.order_id', '=', 'orders.id');
                    })
                    ->select(
                        'orders.*',
                        'shipping_infos.full_name as customer_name',
                        'shipping_infos.email as customer_email',
                        'shipping_infos.phone as customer_phone',
                        'order_qty.total_qty as quantity'
                    )
                    ->whereNull('orders.deleted_at')
                    ->orderByDesc('orders.id')
                    ->get();

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
                        } elseif ($data->order_status == Order::STATUS_CANCELLED) {
                            return '<span class="alert alert-warning" style="padding: 2px 10px !important;">Cancelled</span>';
                        } elseif ($data->order_status == Order::STATUS_DELIVERED) {
                            return '<span class="alert alert-success" style="padding: 2px 10px !important;">Delivered</span>';
                        } elseif ($data->order_status == Order::STATUS_RETURN) {
                            return '<span class="alert alert-dark" style="padding: 2px 10px !important;">Return</span>';
                        } else {
                            return '<span class="alert alert-secondary" style="padding: 2px 10px !important;">Unknown</span>';
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
                    ->editColumn('total', function ($data) {
                        return "৳ " . number_format($data->total, 2);
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {

                        $btn = ' <a href="' . route('adminOrderDetails', $data->slug) . '" title="Order Details" class="d-inline-block btn-sm btn-info rounded"><i class="fas fa-list-ul"></i></a>';
                        // $btn .= ' <a href="' . url('admin/edit/place/order') . '/' . $data->slug . '" title="Edit" class="d-inline-block btn-sm btn-info rounded"><i class="fas fa-pencil-alt"></i></a>';

                        if ($data->order_status == Order::STATUS_PENDING) {
                            $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Cancel" data-id="' . $data->slug . '" data-original-title="Cancel" class="d-inline-block btn-sm btn-danger rounded cancelBtn"><i class="fa fa-times"></i></a>';
                            $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Approve" data-id="' . $data->slug . '" data-original-title="Check" class="d-inline-block btn-sm btn-success rounded approveBtn"><i class="fas fa-check"></i></a>';
                        }

                        if ($data->order_status == Order::STATUS_APPROVED) {
                            $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Cancel" data-id="' . $data->slug . '" data-original-title="Cancel" class="d-inline-block btn-sm btn-danger rounded cancelBtn"><i class="fa fa-times"></i></a>';
                            // $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Approve" data-id="'.$data->slug.'" data-original-title="Check" class="d-inline-block btn-sm btn-success rounded intransitBtn"><i class="fas fa-check"></i></a>';
                        }

                        if ($data->order_status == Order::STATUS_DISPATCH) {
                            $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Deliver" data-id="' . $data->slug . '" data-original-title="Delivery" class="d-inline-block btn-sm btn-success rounded deliveryBtn"><i class="fas fa-truck"></i></a>';
                        }

                        if (Auth::user()->user_type == 1) {
                            $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" data-id="' . $data->slug . '" data-original-title="Delete" class="d-inline-block btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action', 'order_status', 'payment_method', 'payment_status'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
