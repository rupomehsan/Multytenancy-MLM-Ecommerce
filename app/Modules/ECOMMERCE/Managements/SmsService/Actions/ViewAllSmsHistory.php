<?php

namespace App\Modules\ECOMMERCE\Managements\SmsService\Actions;

use Illuminate\Http\Request;
use DataTables;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsHistory;

class ViewAllSmsHistory
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = SmsHistory::orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->editColumn('sending_type', function ($data) {
                    if ($data->sending_type == 1)
                        return "Individual";
                    else
                        return "Everyone";
                })
                ->editColumn('sms_receivers', function ($data) {
                    if ($data->sms_receivers == 1)
                        return "No Order";
                    elseif ($data->sms_receivers == 2)
                        return "Have Order";
                    else
                        return "";
                })
                ->editColumn('min_order', function ($data) {
                    if ($data->min_order > 0)
                        return "<b>Min:</b> " . $data->min_order . ($data->max_order > 0 ? "<b>; Max:</b> " . $data->max_order : '');
                    if ($data->min_order <= 0 && $data->max_order > 0)
                        return " <b>Max:</b> " . $data->max_order;
                })
                ->editColumn('min_order_value', function ($data) {
                    if ($data->min_order_value > 0)
                        return "<b>Min:</b> " . $data->min_order_value . ($data->max_order_value > 0 ? "<b>; Max:</b> " . $data->max_order_value : '');
                    if ($data->min_order_value <= 0 && $data->max_order_value > 0)
                        return " <b>Max:</b> " . $data->max_order_value;
                })
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status', 'min_order', 'min_order_value'])
                ->make(true);
        }

        return [
            'status' => 'success'
        ];
    }
}
