<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class GetRoutesByGroup
{
    public static function execute(Request $request)
    {
        $routeGroups = PermissionRoutes::selectRaw('route_group_name, route_module_name, COUNT(*) as count')
            ->groupBy('route_group_name', 'route_module_name')
            ->orderBy('route_group_name')
            ->orderBy('route_module_name')
            ->get();

        $groupedRoutes = [];
        foreach ($routeGroups as $group) {
            $routes = PermissionRoutes::where('route_group_name', $group->route_group_name)
                ->where('route_module_name', $group->route_module_name)
                ->orderBy('name')
                ->get();

            $groupKey = $group->route_group_name;
            $moduleKey = $group->route_module_name ?: 'Core';

            if (!isset($groupedRoutes[$groupKey])) {
                $groupedRoutes[$groupKey] = [
                    'total_count' => 0,
                    'modules' => []
                ];
            }

            $groupedRoutes[$groupKey]['modules'][$moduleKey] = [
                'count' => $group->count,
                'routes' => $routes
            ];
            $groupedRoutes[$groupKey]['total_count'] += $group->count;
        }

        return [
            'status' => 'success',
            'data' => $groupedRoutes
        ];
    }
}
