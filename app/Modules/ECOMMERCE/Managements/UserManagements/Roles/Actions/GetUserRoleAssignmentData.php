<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Controllers\PermissionRoutesController;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRole;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\RolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class GetUserRoleAssignmentData
{
    public static function execute(Request $request, $userId)
    {
        $userRoles = UserRole::orderBy('id', 'desc')->get();
        $rolesForView = [];
        foreach ($userRoles as $role) {
            $permissions = [];
            try {
                $permissions = RolePermission::where('role_id', $role->id)->pluck('route_name')->toArray();
            } catch (\Throwable $e) {
                \Log::error('Failed to fetch role permissions for role ' . $role->id . ': ' . $e->getMessage());
            }

            $assigned = false;
            try {
                $assigned = UserRolePermission::where('user_id', $userId)->where('role_id', $role->id)->exists();
            } catch (\Throwable $e) {
                \Log::error('Failed to check user role assignment for user ' . $userId . ' role ' . $role->id . ': ' . $e->getMessage());
            }

            $rolesForView[] = (object) [
                'id' => $role->id,
                'name' => $role->name,
                'permissionsUnderRole' => implode(', ', $permissions),
                'assigned' => $assigned,
            ];
        }

        $moduleGroupRoutes = [];
        try {
            $permissionController = new PermissionRoutesController();
            $moduleGroupRoutes = $permissionController->getRoutesByModuleAndGroup();
        } catch (\Throwable $e) {
            \Log::error('Failed to get module group routes: ' . $e->getMessage());
        }

        $userPermissions = [];
        try {
            $userPermissions = UserRolePermission::where('user_id', $userId)->pluck('permission_id')->toArray();
        } catch (\Throwable $e) {
            \Log::error('Failed to fetch user permissions for user ' . $userId . ': ' . $e->getMessage());
        }

        $homeRoute = PermissionRoutes::where('route', 'home')->first();

        return [
            'status' => 'success',
            'data' => [
                'userId' => $userId,
                'rolesForView' => $rolesForView,
                'moduleGroupRoutes' => $moduleGroupRoutes,
                'userPermissions' => $userPermissions,
                'homeRoute' => $homeRoute
            ]
        ];
    }
}
