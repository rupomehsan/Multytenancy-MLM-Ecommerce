<?php

namespace App\Modules\ECOMMERCE\Managements\PushNotification\Actions;

use Illuminate\Http\Request;
use DataTables;
use App\Modules\ECOMMERCE\Managements\PushNotification\Database\Models\Notification;

class ViewAllNotifications
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = Notification::orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return [
            'status' => 'success'
        ];
    }
}
