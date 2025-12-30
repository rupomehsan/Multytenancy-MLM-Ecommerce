<?php

namespace App\Modules\CRM\Managements\NextDateContacts\Actions;

use DataTables;
use Illuminate\Http\Request;

use App\Modules\CRM\Managements\NextDateContacts\Database\Models\CustomerNextContactDate;

class ViewAllCustomerNextContactDate
{
    public static function execute(Request $request)
    {
        $data = CustomerNextContactDate::with(['customer'])
            ->orderBy('id', 'DESC')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('customer', function ($data) {
                return $data->customer ? $data->customer->name : 'N/A';
            })
            ->editColumn('contact_status', function ($data) {
                switch ($data->contact_status) {
                    case 'pending':
                        return 'Pending';
                    case 'missed':
                        return 'Missed';
                    case 'done':
                        return 'Done';
                    default:
                        return 'Unknown';
                }
            })
            ->addColumn('action', function ($data) {
                $btn = '<a href="' . url('edit/customer-next-contact-date') . '/' . $data->slug . '" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
