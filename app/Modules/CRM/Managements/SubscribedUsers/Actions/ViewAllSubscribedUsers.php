<?php

namespace App\Modules\CRM\Managements\SubscribedUsers\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\CRM\Managements\SubscribedUsers\Database\Models\SubscribedUsers;

class ViewAllSubscribedUsers
{
    public static function execute(Request $request)
    {
        $data = SubscribedUsers::orderBy('id', 'desc')->get();

        return DataTables::of($data)
            ->editColumn('created_at', function ($data) {
                return date('l jS \o\f F Y h:i:s A', strtotime($data->created_at));
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
