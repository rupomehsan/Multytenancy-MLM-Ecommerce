<?php

namespace App\Modules\CRM\Managements\ContactRequest\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\CRM\Managements\ContactRequest\Database\Models\ContactRequest;

class ViewAllContactRequests
{
    public static function execute(Request $request)
    {
        $data = ContactRequest::orderBy('id', 'desc')->get();

        return DataTables::of($data)
            ->editColumn('status', function ($data) {
                if ($data->status == 0) {
                    return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Chnage Status" class="btn btn-sm btn-warning changeStatus">Not Served</a>';
                } else {
                    return '<a href="javascript:void(0)" class="btn btn-sm btn-success">Served</a>';
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
