<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class ViewAllPermissionRoutes
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = PermissionRoutes::orderBy('route_group_name', 'asc')
                ->orderBy('route_module_name', 'asc')
                ->orderBy('name', 'asc')
                ->get();

            return DataTables::of($data)
                ->editColumn('route_group_name', function ($data) {
                    return '<span class="badge badge-primary">' . ($data->route_group_name ?: 'General') . '</span>';
                })
                ->editColumn('route_module_name', function ($data) {
                    return '<span class="badge badge-info">' . ($data->route_module_name ?: 'Core') . '</span>';
                })
                ->editColumn('method', function ($data) {
                    $methodColors = [
                        'GET' => 'success',
                        'POST' => 'primary',
                        'PUT' => 'warning',
                        'PATCH' => 'info',
                        'DELETE' => 'danger'
                    ];
                    $color = $methodColors[$data->method] ?? 'secondary';
                    return '<span class="badge badge-' . $color . '">' . $data->method . '</span>';
                })
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->editColumn('updated_at', function ($data) {
                    if ($data->updated_at) {
                        return date("Y-m-d h:i:s a", strtotime($data->updated_at));
                    }
                    return '-';
                })
                ->rawColumns(['route_group_name', 'route_module_name', 'method'])
                ->addIndexColumn()
                ->make(true);
        }

        return [
            'status' => 'success'
        ];
    }
}
