<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Controllers\PermissionRoutesController;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRole;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\RolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class GetUserRoleForEdit
{
    public static function execute(Request $request, $id)
    {
        $moduleGroupRoutes = [];
        $permissionController = new PermissionRoutesController();
        try {
            $moduleGroupRoutes = $permissionController->getRoutesByModuleAndGroup();
        } catch (\Throwable $e) {
            \Log::error('Failed to get module group routes: ' . $e->getMessage());
        }

        $homeRoute = PermissionRoutes::where('route', 'home')->first();
        $userRoleInfo = UserRole::where('id', $id)->first();

        $selectedPermissions = [];
        if ($userRoleInfo) {
            try {
                $selectedPermissions = RolePermission::where('role_id', $userRoleInfo->id)
                    ->pluck('permission_id')
                    ->toArray();
            } catch (\Throwable $e) {
                \Log::error('Failed to fetch selected permissions for role ' . $id . ': ' . $e->getMessage());
            }
        }

        return [
            'status' => 'success',
            'data' => [
                'userRoleInfo' => $userRoleInfo,
                'moduleGroupRoutes' => $moduleGroupRoutes,
                'homeRoute' => $homeRoute,
                'selectedPermissions' => $selectedPermissions
            ]
        ];
    }
}
