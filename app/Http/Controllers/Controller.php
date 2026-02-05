<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function loadModuleViewPath($moduleName)
    {
        $path = app_path("Modules/{$moduleName}/Views");

        if (is_dir($path)) {
            // Dynamically add the view path for the module
            View::addLocation($path);
        }
    }
}
