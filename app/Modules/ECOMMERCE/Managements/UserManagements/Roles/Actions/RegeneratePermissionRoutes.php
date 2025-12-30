<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegeneratePermissionRoutes
{
    public static function execute(Request $request)
    {
        // 1. Get all modules from web.php require statements
        $webFilePath = base_path('routes/web.php');
        $modules = [];
        if (file_exists($webFilePath)) {
            $content = file_get_contents($webFilePath);
            preg_match_all("/require\s+__DIR__\s*\.\s*'\/([^']+)\.php'\s*;/", $content, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $routeFile) {
                    $fileName = $routeFile . '.php';
                    if (preg_match('/Routes$/', $routeFile)) {
                        $moduleName = strtolower(preg_replace('/Routes$/', '', $routeFile));
                    } else {
                        $moduleName = strtolower($routeFile);
                    }
                    $modules[$moduleName] = base_path('routes/' . $fileName);
                }
            }
        }

        // 2. For each module file, scan for group comments and routes
        $allRoutes = [];
        foreach ($modules as $moduleName => $filePath) {
            if (!file_exists($filePath)) continue;
            $lines = file($filePath);
            $currentGroup = 'General';
            foreach ($lines as $line) {
                $trimmed = trim($line);
                // Detect group comment
                if (preg_match('/^\/\/\s*(.+?)(?:\s+routes?|\s+start|\s+begin)?\s*$/i', $trimmed, $m)) {
                    $groupName = trim($m[1]);
                    if ($groupName && stripos($groupName, 'route') === false) {
                        $currentGroup = ucwords($groupName);
                    }
                }
                // Detect Route::... definition
                if (preg_match('/Route::(get|post|put|patch|delete|options)\s*\(/i', $trimmed)) {
                    // Try to extract route name
                    $name = null;
                    if (preg_match("/->name\(['\"]([^'\"]+)['\"]\)/", $trimmed, $nm)) {
                        $name = $nm[1];
                    }
                    $allRoutes[] = [
                        'module' => $moduleName,
                        'group' => $currentGroup,
                        'line' => $trimmed,
                        'name' => $name
                    ];
                }
            }
        }

        // 3. Remove all old permission routes
        DB::table('permission_routes')->truncate();

        // 4. Insert new permission routes
        $now = now();
        foreach ($allRoutes as $route) {
            // Try to extract method and uri
            if (preg_match('/Route::(get|post|put|patch|delete|options)\s*\(\s*["\']([^"\']+)["\']/', $route['line'], $rm)) {
                $method = strtoupper($rm[1]);
                $uri = $rm[2];
            } else {
                continue;
            }
            DB::table('permission_routes')->insert([
                'route' => $uri,
                'name' => $route['name'] ?? '',
                'method' => $method,
                'route_group_name' => $route['group'],
                'route_module_name' => $route['module'],
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        return [
            'status' => 'success',
            'message' => 'Permission Routes Regenerated Successfully!'
        ];
    }
}
