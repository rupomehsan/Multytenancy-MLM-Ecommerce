<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Controllers\PermissionRoutesController;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class GetRoleFormData
{
    public static function execute(Request $request)
    {
        $permissionController = new PermissionRoutesController();
        $moduleGroupRoutes = [];
        try {
            $moduleGroupRoutes = $permissionController->getRoutesByModuleAndGroup();
        } catch (\Throwable $e) {
            \Log::error('Failed to get module group routes: ' . $e->getMessage());
        }

        $homeRoute = PermissionRoutes::where('route', 'home')->first();

        return [
            'status' => 'success',
            'data' => [
                'moduleGroupRoutes' => $moduleGroupRoutes,
                'homeRoute' => $homeRoute
            ]
        ];
    }
}
