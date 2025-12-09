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

    public function referral()
    {
        return view('referral');
    }

    public function commission()
    {
        return view('commission');
    }

    public function user_performance()
    {
        return view('user_performance');
    }

    public function top_earners()
    {
        return view('top_earners');
    }

    public function withdrawal()
    {
        return view('withdrawal');
    }

    public function activity_log()
    {
        return view('activity_log');
    }

    public function wallet_summary()
    {
        return view('wallet_summary');
    }
}
