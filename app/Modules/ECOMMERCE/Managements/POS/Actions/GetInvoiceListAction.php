<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GetInvoiceListAction
{
    public function execute(Request $request)
    {
        $data = DB::table('orders')
            ->leftJoin('shipping_infos', 'shipping_infos.order_id', '=', 'orders.id')
            ->select(
                'orders.*',
                'shipping_infos.full_name as customer_name',
                'shipping_infos.phone as customer_phone'
            )
            ->where('orders.order_from', 3) // POS orders only
            ->where('orders.invoice_generated', 1) // Only invoiced orders
            ->orderBy('orders.id', 'desc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('invoice_date', function ($data) {
                return date('d M Y', strtotime($data->invoice_date));
            })
            ->editColumn('total', function ($data) {
                return "৳ " . number_format($data->total, 2);
            })
            ->addColumn('action', function ($data) {
                $btn = '';
                $btn .= '<a href="' . route('ShowInvoice', $data->id) . '" class="btn btn-sm btn-primary mr-1"><i class="fas fa-eye"></i> View</a>';
                $btn .= '<a href="javascript:void(0)" onclick="printInvoiceInline(' . $data->id . ')" class="btn btn-sm btn-success mr-1"><i class="fas fa-print"></i> Print</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
