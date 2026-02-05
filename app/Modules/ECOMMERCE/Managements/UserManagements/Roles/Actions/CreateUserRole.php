<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRole;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\RolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class CreateUserRole
{
    public static function execute(Request $request)
    {
        $roleId = UserRole::insertGetId([
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => Carbon::now()
        ]);

        if ($request->permission_id && is_array($request->permission_id)) {
            foreach ($request->permission_id as $permissionId) {
                $routeInfo = PermissionRoutes::where('id', $permissionId)->first();
                RolePermission::insert([
                    'role_id' => $roleId,
                    'role_name' => $request->name,
                    'permission_id' => $permissionId,
                    'route' => $routeInfo->route,
                    'route_name' => $routeInfo->name,
                    'created_at' => Carbon::now()
                ]);
            }
        }

        return [
            'status' => 'success',
            'message' => 'New Role Created'
        ];
    }
}
