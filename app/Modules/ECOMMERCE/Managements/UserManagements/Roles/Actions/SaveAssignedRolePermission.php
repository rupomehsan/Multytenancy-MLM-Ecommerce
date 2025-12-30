<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\RolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class SaveAssignedRolePermission
{
    public static function execute(Request $request)
    {
        UserRolePermission::where('user_id', $request->user_id)->delete();

        if (isset($request->role_id) && count($request->role_id) > 0) {
            foreach ($request->role_id as $roleId) {
                $rolePermissions = RolePermission::where('role_id', $roleId)->get();
                foreach ($rolePermissions as $rolePermission) {
                    UserRolePermission::insert([
                        'user_id' => $request->user_id,
                        'role_id' => $rolePermission->role_id,
                        'role_name' => $rolePermission->role_name,
                        'permission_id' => $rolePermission->permission_id,
                        'route' => $rolePermission->route,
                        'route_name' => $rolePermission->route_name,
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        if (isset($request->permission_id) && count($request->permission_id) > 0) {
            foreach ($request->permission_id as $permissionId) {
                $routeInfo = PermissionRoutes::where('id', $permissionId)->first();

                $existingPermission = UserRolePermission::where('user_id', $request->user_id)
                    ->where('permission_id', $permissionId)
                    ->first();

                if ($existingPermission) {
                    $existingPermission->update([
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    UserRolePermission::insert([
                        'user_id' => $request->user_id,
                        'role_id' => null,
                        'role_name' => null,
                        'permission_id' => $permissionId,
                        'route' => $routeInfo->route,
                        'route_name' => $routeInfo->name,
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        return [
            'status' => 'success',
            'message' => 'User Role Updated'
        ];
    }
}
