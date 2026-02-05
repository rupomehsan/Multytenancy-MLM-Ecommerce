<?php

namespace App\Modules\CRM\Managements\CustomerSourceType\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\CRM\Managements\CustomerSourceType\Database\Models\CustomerSourceType;

class ViewAllCustomerSource
{
    public static function execute(Request $request)
    {
        $data = CustomerSourceType::orderBy('id', 'desc')->get();

        return DataTables::of($data)
            ->editColumn('status', function ($data) {
                return $data->status == "active" ? 'Active' : 'Inactive';
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="' . route('EditCustomerSource', $data->slug) . '" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
