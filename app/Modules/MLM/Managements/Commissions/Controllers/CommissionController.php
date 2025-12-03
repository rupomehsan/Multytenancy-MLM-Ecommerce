<?php

namespace App\Modules\MLM\Managements\Commissions\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;




class CommissionController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Commissions');
    }
    public function settings()
    {
        return view('settings');
    }
    public function record()
    {
        return view('records');
    }
}
