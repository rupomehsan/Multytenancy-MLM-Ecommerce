<?php

namespace App\Modules\MLM\Managements\Referral\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;



class ReferralController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Referral');
    }
    public function referral_list()
    {
        return view('referral_list');
    }
    public function referral_tree()
    {
        return view('referral_tree');
    }
    public function referral_activity_log()
    {
        return view('referral_activity_log');
    }
}
