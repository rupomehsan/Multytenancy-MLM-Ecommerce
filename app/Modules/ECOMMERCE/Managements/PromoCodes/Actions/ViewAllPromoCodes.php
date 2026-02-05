<?php

namespace App\Modules\ECOMMERCE\Managements\PromoCodes\Actions;

use Illuminate\Http\Request;
use DataTables;
use App\Modules\ECOMMERCE\Managements\PromoCodes\Database\Models\PromoCode;

class ViewAllPromoCodes
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = PromoCode::orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->editColumn('type', function ($data) {
                    if ($data->type == 1) {
                        return "Amount (৳)";
                    } else {
                        return "Percentage (%)";
                    }
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="alert alert-success p-0 pl-2 pr-2">Active</span>';
                    } else {
                        return '<span class="alert alert-danger p-0 pl-2 pr-2">Inactive</span>';
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . route('EditPromoCode', $data->slug) . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        // Auto-expire promo codes
        $data = PromoCode::orderBy('id', 'desc')->get();
        $today = strtotime(date("Y-m-d"));
        foreach ($data as $item) {
            if (strtotime($item->expire_date) < $today) {
                $item->status = 0;
                $item->save();
            }
        }

        return [
            'status' => 'success'
        ];
    }
}
