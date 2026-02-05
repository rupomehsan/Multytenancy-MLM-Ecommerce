<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use DataTables;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class ViewUserRolePermission
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('user_type', 2)->orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . route('AssignRolePermission',$data->id) . '" class="btn-sm btn-warning rounded"><i class="fas fa-edit"></i> Assign</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'user_type'])
                ->make(true);
        }

        return [
            'status' => 'success'
        ];
    }
}
