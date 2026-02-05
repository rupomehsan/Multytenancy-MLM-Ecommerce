<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderLog;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class ViewOrderLogs
{
    public static function execute(Request $request)
    {
        // Build query for DataTables - use query builder, not get()
        $query = DB::table('order_logs as ol')
            ->leftJoin('orders as o', 'ol.order_id', '=', 'o.id')
            ->leftJoin('users as u', 'ol.performed_by', '=', 'u.id')
            ->select(
                'ol.id',
                'ol.order_id',
                'o.order_no',
                'o.slug',
                'ol.activity_type',
                'ol.old_status',
                'ol.new_status',
                'ol.performed_by',
                'u.name as performed_by_name',
                'ol.action_source',
                'ol.title',
                'ol.description',
                'ol.metadata',
                'ol.ip_address',
                'ol.created_at'
            )
            ->orderByDesc('ol.created_at');

        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('order_no', function ($data) {
                if ($data->order_no && $data->slug) {
                    return '<a href="' . url('admin/order/details/' . $data->slug) . '" target="_blank" class="text-primary font-weight-bold">' . $data->order_no . '</a>';
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('activity_type', function ($data) {
                $badges = [
                    OrderLog::TYPE_STATUS_CHANGE => '<span class="badge badge-info">Status Change</span>',
                    OrderLog::TYPE_CREATED => '<span class="badge badge-success">Created</span>',
                    OrderLog::TYPE_UPDATED => '<span class="badge badge-primary">Updated</span>',
                    OrderLog::TYPE_CANCELLED => '<span class="badge badge-danger">Cancelled</span>',
                    OrderLog::TYPE_DELIVERED => '<span class="badge badge-success">Delivered</span>',
                    OrderLog::TYPE_PAYMENT_UPDATE => '<span class="badge badge-warning">Payment Update</span>',
                    OrderLog::TYPE_COMMISSION_DISTRIBUTED => '<span class="badge badge-success">Commission Distributed</span>',
                    OrderLog::TYPE_COMMISSION_REVERSED => '<span class="badge badge-danger">Commission Reversed</span>',
                    OrderLog::TYPE_OTHER => '<span class="badge badge-secondary">Other</span>',
                ];

                return $badges[$data->activity_type] ?? '<span class="badge badge-secondary">' . ucfirst($data->activity_type) . '</span>';
            })
            ->editColumn('action_source', function ($data) {
                $badges = [
                    OrderLog::SOURCE_ADMIN => '<span class="badge badge-primary">Admin</span>',
                    OrderLog::SOURCE_CUSTOMER => '<span class="badge badge-info">Customer</span>',
                    OrderLog::SOURCE_SYSTEM => '<span class="badge badge-warning">System</span>',
                    OrderLog::SOURCE_API => '<span class="badge badge-secondary">API</span>',
                    OrderLog::SOURCE_OBSERVER => '<span class="badge badge-dark">Observer</span>',
                    OrderLog::SOURCE_MANUAL => '<span class="badge badge-success">Manual</span>',
                ];

                return $badges[$data->action_source] ?? '<span class="badge badge-secondary">' . ucfirst($data->action_source) . '</span>';
            })
            ->editColumn('performed_by_name', function ($data) {
                if ($data->performed_by_name) {
                    return '<span class="text-dark font-weight-bold">' . $data->performed_by_name . '</span>';
                }
                return '<span class="text-muted">System</span>';
            })
            ->editColumn('title', function ($data) {
                $html = '<strong>' . $data->title . '</strong>';

                if ($data->old_status && $data->new_status) {
                    $html .= '<br><small class="text-muted">' . ucfirst($data->old_status) . ' → ' . ucfirst($data->new_status) . '</small>';
                }

                return $html;
            })
            ->editColumn('description', function ($data) {
                if ($data->description) {
                    $desc = strlen($data->description) > 100
                        ? substr($data->description, 0, 100) . '...'
                        : $data->description;
                    return '<small class="text-muted">' . $desc . '</small>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->editColumn('created_at', function ($data) {
                return '<span class="text-muted">' . \Carbon\Carbon::parse($data->created_at)->format('M d, Y h:i A') . '</span>';
            })
            ->addColumn('action', function ($data) {
                $btn = '<button class="btn btn-sm btn-info view-details-btn" data-id="' . $data->id . '" data-toggle="tooltip" title="View Details"><i class="fas fa-eye"></i></button>';
                return $btn;
            })
            ->rawColumns(['order_no', 'activity_type', 'action_source', 'performed_by_name', 'title', 'description', 'created_at', 'action'])
            ->make(true);
    }
}
