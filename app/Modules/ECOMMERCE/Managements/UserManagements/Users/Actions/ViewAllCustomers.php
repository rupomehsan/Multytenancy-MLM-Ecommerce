<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions;

use Illuminate\Http\Request;
use DataTables;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class ViewAllCustomers
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('user_type', 3)->orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->editColumn('image', function ($data) {
                    if ($data->image && file_exists(public_path($data->image)))
                        return $data->image;
                })
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->editColumn('delete_request_submitted', function ($data) {
                    if ($data->delete_request_submitted == 1) {
                        return "<span style='background: #b00; padding: 2px 10px; border-radius: 4px; color: white'>Yes</span> On <b>" .  date("Y-m-d", strtotime($data->delete_request_submitted_at)) . "</b>";
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'icon', 'delete_request_submitted'])
                ->make(true);
        }

        return [
            'status' => 'success'
        ];
    }
}
