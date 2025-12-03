<?php

namespace App\Modules\MLM\Managements\Reports\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;



class ReportController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Reports');
    }
    public function index()
    {
        return view('index');
    }
}
