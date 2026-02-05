<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use DataTables;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRole;

class ViewAllUserRoles
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = UserRole::orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->editColumn('updated_at', function ($data) {
                    if ($data->updated_at) {
                        return date("Y-m-d h:i:s a", strtotime($data->updated_at));
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . route('EditUserRole',$data->id) . '" class="mb-1 btn-sm btn-warning rounded d-inline-block"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded d-inline-block deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return [
            'status' => 'success'
        ];
    }
}
