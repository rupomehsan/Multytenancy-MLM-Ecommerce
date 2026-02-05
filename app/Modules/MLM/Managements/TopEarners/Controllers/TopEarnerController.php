<?php

namespace App\Modules\MLM\Managements\TopEarners\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Modules\MLM\Managements\TopEarners\Actions\ViewTopEarners;


class TopEarnerController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/TopEarners');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return ViewTopEarners::execute($request);
        }
        return view('index');
    }
}
