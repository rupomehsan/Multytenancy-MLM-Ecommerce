<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\ViewAllPermissionRoutes;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\RegeneratePermissionRoutes;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\GetRoutesByGroup;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\GetRoutesByModule;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\GetRoutesByModuleAndGroup;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;

class PermissionRoutesController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/UserManagements/Roles');
    }
    public function viewAllPermissionRoutes(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllPermissionRoutes::execute($request);
        }
        return view('permisson_routes');
    }

    public function regeneratePermissionRoutes()
    {
        $result = RegeneratePermissionRoutes::execute(request());
        Toastr::success($result['message'], "Success");
        return back();
    }

    /**
     * Get all modules from web.php require statements
     */
    private function getModulesFromWebFile()
    {
        $webFilePath = base_path('routes/web.php');
        $modules = [];
        if (file_exists($webFilePath)) {
            $content = file_get_contents($webFilePath);
            // Match all require statements: require __DIR__.'/filename.php';
            preg_match_all("/require\s+__DIR__\s*\.\s*'\/([^']+)\.php'\s*;/", $content, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $routeFile) {
                    $fileName = $routeFile . '.php';
                    // Remove 'Routes' suffix only if present at the end, then convert to lowercase
                    if (preg_match('/Routes$/', $routeFile)) {
                        $moduleName = strtolower(preg_replace('/Routes$/', '', $routeFile));
                    } else {
                        $moduleName = strtolower($routeFile);
                    }
                    $modules[$fileName] = $moduleName;
                }
            }
        }
        return $modules;
    }

    /**
     * Extract group name from route file comments - reads comments sequentially
     */
    private function extractGroupFromRouteFile($routeFilePath, $routeName = null)
    {
        if (!file_exists($routeFilePath)) {
            return null;
        }

        $content = file_get_contents($routeFilePath);
        $lines = explode("\n", $content);
        $currentGroup = null;

        foreach ($lines as $line) {
            $line = trim($line);

            // Check for group comment patterns
            if (preg_match('/^\/\/\s*(.+?)(?:\s+routes?|\s+start|\s+begin)?(?:\s*$)/i', $line, $matches)) {
                $groupName = trim($matches[1]);

                // Skip lines that are clearly not group names
                if (
                    strpos(strtolower($groupName), 'route') === false &&
                    strlen($groupName) > 2 &&
                    !preg_match('/^\s*(use|include|require|namespace)/i', $groupName)
                ) {
                    $currentGroup = ucwords($groupName);
                }
            }

            // If we find the specific route name, return the current group
            if ($routeName && strpos($line, "'" . $routeName . "'") !== false) {
                return $currentGroup;
            }
        }

        // If no specific route name provided, return the first group found
        return $currentGroup;
    }

    /**
     * Determine the route group based on controller and file comments
     */
    private function determineRouteGroup($route)
    {
        $controller = $route->getController();
        if (!$controller) {
            return 'General';
        }

        $controllerClass = get_class($controller);
        $controllerName = class_basename($controllerClass);
        $routeName = $route->getName();

        // Get all module route files dynamically
        $modules = $this->getRouteModulesFromWebFile();

        foreach ($modules as $fileName => $module) {
            $filePath = base_path('routes/' . $fileName);
            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                // Check if this controller is used in this route file
                if (strpos($content, $controllerName) !== false) {
                    $group = $this->extractGroupFromRouteFile($filePath, $routeName);
                    if ($group) {
                        return $group;
                    }
                }
            }
        }

        // Fallback: extract from route name
        if ($routeName) {
            $parts = explode('.', $routeName);
            if (count($parts) > 1) {
                return ucfirst($parts[0]);
            }
        }

        return 'General';
    }

    /**
     * Determine the route module based on the file the route is defined in
     */
    private function determineRouteModule($route)
    {
        $modules = $this->getRouteModulesFromWebFile();
        $routeFilePath = '';
        if (method_exists($route, 'getAction')) {
            $action = $route->getAction();
            if (isset($action['file'])) {
                $routeFilePath = $action['file'];
            }
        }
        // Strictly match the file path to the module
        foreach ($modules as $fileName => $module) {
            if (!empty($routeFilePath) && str_ends_with($routeFilePath, DIRECTORY_SEPARATOR . $fileName)) {
                return $module;
            }
        }
        // If not found, it's not from a module file, so treat as 'general'
        return 'general';
    }

    /**
     * Get routes grouped by route group name and module name
     */
    public function getRoutesByGroup()
    {
        $result = GetRoutesByGroup::execute(request());
        return response()->json($result['data']);
    }

    /**
     * Get routes grouped by module name only
     */
    public function getRoutesByModule()
    {
        $result = GetRoutesByModule::execute(request());
        return response()->json($result['data']);
    }

    /**
     * Get routes organized by Module > Groups > Routes structure
     */
    public function getRoutesByModuleAndGroup()
    {
        $result = GetRoutesByModuleAndGroup::execute(request());
        return $result['data'];
    }
}
