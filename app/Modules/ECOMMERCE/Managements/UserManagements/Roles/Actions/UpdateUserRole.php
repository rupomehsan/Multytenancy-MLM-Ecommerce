<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRole;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\RolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class UpdateUserRole
{
    public static function execute(Request $request)
    {
        UserRole::where('id', $request->role_id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_at' => Carbon::now()
        ]);

        $users = UserRolePermission::where('role_id', $request->role_id)
            ->select('user_id')
            ->distinct()
            ->get();

        if ($users->count() > 0) {
            RolePermission::where('role_id', $request->role_id)->delete();
            UserRolePermission::where('role_id', $request->role_id)->delete();

            if (isset($request->permission_id) && count($request->permission_id) > 0) {
                foreach ($users as $user) {
                    foreach ($request->permission_id as $permissionId) {
                        $routeInfo = PermissionRoutes::where('id', $permissionId)->first();

                        RolePermission::insert([
                            'role_id' => $request->role_id,
                            'role_name' => $request->name,
                            'permission_id' => $permissionId,
                            'route' => $routeInfo->route,
                            'route_name' => $routeInfo->name,
                            'created_at' => Carbon::now()
                        ]);

                        UserRolePermission::insert([
                            'user_id' => $user->user_id,
                            'role_id' => $request->role_id,
                            'role_name' => $request->name,
                            'permission_id' => $permissionId,
                            'route' => $routeInfo->route,
                            'route_name' => $routeInfo->name,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    }
                }
            }
        } else {
            RolePermission::where('role_id', $request->role_id)->delete();

            if (isset($request->permission_id) && count($request->permission_id) > 0) {
                foreach ($request->permission_id as $permissionId) {
                    $routeInfo = PermissionRoutes::where('id', $permissionId)->first();

                    RolePermission::insert([
                        'role_id' => $request->role_id,
                        'role_name' => $request->name,
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
