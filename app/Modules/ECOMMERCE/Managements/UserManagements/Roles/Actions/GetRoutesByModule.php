<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class GetRoutesByModule
{
    public static function execute(Request $request)
    {
        $routeModules = PermissionRoutes::selectRaw('route_module_name, COUNT(*) as count')
            ->groupBy('route_module_name')
            ->orderBy('route_module_name')
            ->get();

        $moduleRoutes = [];
        foreach ($routeModules as $module) {
            $routes = PermissionRoutes::where('route_module_name', $module->route_module_name)
                ->orderBy('route_group_name')
                ->orderBy('name')
                ->get();
            $moduleRoutes[$module->route_module_name ?: 'Core'] = [
                'count' => $module->count,
                'routes' => $routes
            ];
        }

        return [
            'status' => 'success',
            'data' => $moduleRoutes
        ];
    }
}
