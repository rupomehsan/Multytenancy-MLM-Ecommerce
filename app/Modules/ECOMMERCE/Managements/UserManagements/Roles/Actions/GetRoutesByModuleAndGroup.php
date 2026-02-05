<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class GetRoutesByModuleAndGroup
{
    public static function execute(Request $request)
    {
        $routes = PermissionRoutes::orderBy('route_module_name')
            ->orderBy('route_group_name')
            ->orderBy('name')
            ->get();

        $moduleGroupRoutes = [];

        foreach ($routes as $route) {
            $moduleName = $route->route_module_name ?: 'general';
            $groupName = $route->route_group_name ?: 'General';

            // Initialize module if not exists
            if (!isset($moduleGroupRoutes[$moduleName])) {
                $moduleGroupRoutes[$moduleName] = [
                    'total_count' => 0,
                    'groups' => []
                ];
            }

            // Initialize group if not exists
            if (!isset($moduleGroupRoutes[$moduleName]['groups'][$groupName])) {
                $moduleGroupRoutes[$moduleName]['groups'][$groupName] = [
                    'count' => 0,
                    'routes' => []
                ];
            }

            // Add route to group
            $moduleGroupRoutes[$moduleName]['groups'][$groupName]['routes'][] = $route;
            $moduleGroupRoutes[$moduleName]['groups'][$groupName]['count']++;
            $moduleGroupRoutes[$moduleName]['total_count']++;
        }

        return [
            'status' => 'success',
            'data' => $moduleGroupRoutes
        ];
    }
}
