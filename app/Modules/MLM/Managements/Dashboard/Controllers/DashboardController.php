<?php

namespace App\Modules\MLM\Managements\Dashboard\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;



class DashboardController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Dashboard');
    }
    public function dashboard()
    {
        return view('dashboard');
    }
}
