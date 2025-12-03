<?php

namespace App\Modules\MLM\Managements\Withdrow\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;



class WithdrowController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Withdrow');
    }
    public function withdrow_request()
    {
        return view('withdrow_request');
    }
    public function withdrow_history()
    {
        return view('withdrow_history');
    }
}
