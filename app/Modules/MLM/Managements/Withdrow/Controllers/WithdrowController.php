<?php

namespace App\Modules\MLM\Managements\Withdrow\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Modules\MLM\Managements\Withdrow\Actions\ViewWithdrawRequest;
use App\Modules\MLM\Managements\Withdrow\Actions\ViewWithdrawHistory;


class WithdrowController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Withdrow');
    }

    public function withdrow_request(Request $request)
    {
        if ($request->ajax()) {
            return ViewWithdrawRequest::execute($request);
        }
        return view('withdrow_request');
    }

    public function withdrow_history(Request $request)
    {
        if ($request->ajax()) {
            return ViewWithdrawHistory::execute($request);
        }
        return view('withdrow_history');
    }
}
