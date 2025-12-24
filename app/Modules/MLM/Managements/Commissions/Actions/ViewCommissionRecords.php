<?php

namespace App\Modules\MLM\Managements\Commissions\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Modules\MLM\Managements\Commissions\Database\Models\MlmCommission;

class ViewCommissionRecords
{
    public static function execute(Request $request)
    {
        // Build query for commission records
        $query = DB::table('mlm_commissions as mc')
            ->leftJoin('users as referrer', 'mc.referrer_id', '=', 'referrer.id')
            ->leftJoin('users as buyer', 'mc.buyer_id', '=', 'buyer.id')
            ->leftJoin('orders as o', 'mc.order_id', '=', 'o.id')
            ->select(
                'mc.id',
                'mc.order_id',
                'o.order_no',
                'o.slug as order_slug',
                'mc.referrer_id',
                'referrer.name as referrer_name',
                'referrer.email as referrer_email',
                'mc.buyer_id',
                'buyer.name as buyer_name',
                'buyer.email as buyer_email',
                'mc.level',
                'mc.commission_amount',
                'mc.status',
                'mc.created_at'
            )
            ->orderByDesc('mc.created_at');

        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('referrer_name', function ($data) {
                $html = '<strong>' . ($data->referrer_name ?? 'N/A') . '</strong><br>';
                $html .= '<small class="text-muted">ID: ' . $data->referrer_id . '</small>';
                if ($data->referrer_email) {
                    $html .= '<br><small class="text-muted">' . $data->referrer_email . '</small>';
                }
                return $html;
            })
            ->editColumn('buyer_name', function ($data) {
                $html = ($data->buyer_name ?? 'N/A') . '<br>';
                $html .= '<small class="text-muted">ID: ' . $data->buyer_id . '</small>';
                if ($data->buyer_email) {
                    $html .= '<br><small class="text-muted">' . $data->buyer_email . '</small>';
                }
                return $html;
            })
            ->editColumn('order_no', function ($data) {
                if ($data->order_no && $data->order_slug) {
                    return '<a href="' . url('admin/order/details/' . $data->order_slug) . '" target="_blank" class="text-primary font-weight-bold">#' . $data->order_no . '</a>';
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('level', function ($data) {
                $badges = [
                    1 => '<span class="badge badge-primary">Level 1</span>',
                    2 => '<span class="badge badge-success">Level 2</span>',
                    3 => '<span class="badge badge-warning">Level 3</span>',
                ];
                return $badges[$data->level] ?? '<span class="badge badge-secondary">Level ' . $data->level . '</span>';
            })
            ->editColumn('commission_amount', function ($data) {
                return '৳ ' . number_format($data->commission_amount, 2);
            })
            ->editColumn('status', function ($data) {
                $badges = [
                    MlmCommission::STATUS_PENDING => '<span class="badge badge-warning">Pending</span>',
                    MlmCommission::STATUS_APPROVED => '<span class="badge badge-info">Approved</span>',
                    MlmCommission::STATUS_PAID => '<span class="badge badge-success">Paid</span>',
                    MlmCommission::STATUS_REJECTED => '<span class="badge badge-danger">Rejected</span>',
                ];
                return $badges[$data->status] ?? '<span class="badge badge-secondary">' . ucfirst($data->status) . '</span>';
            })
            ->editColumn('created_at', function ($data) {
                return \Carbon\Carbon::parse($data->created_at)->format('d M, Y');
            })
            ->rawColumns(['referrer_name', 'buyer_name', 'order_no', 'level', 'status', 'commission_amount'])
            ->make(true);
    }
}
