<?php

namespace App\Modules\CRM\Managements\Customers\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\CRM\Managements\Customers\Database\Models\Customer;

class ViewAllCustomer
{
    public static function execute(Request $request)
    {
        $data = Customer::where('status', 'active')
            ->with(['customerCategory', 'customerSourceType', 'referenceBy'])
            ->orderBy('id', 'DESC')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('customer_category', function ($data) {
                return $data->customerCategory ? $data->customerCategory->title : 'N/A';
            })
            ->addColumn('customer_source_type', function ($data) {
                return $data->customerSourceType ? $data->customerSourceType->title : 'N/A';
            })
            ->addColumn('reference_by', function ($data) {
                return $data->referenceBy ? $data->referenceBy->name : 'N/A';
            })
            ->addColumn('action', function ($data) {
                $btn = '<a href="' . route('EditCustomers', $data->slug) . '" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
