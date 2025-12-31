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
use App\Modules\MLM\Managements\Withdrow\Actions\UpdateWithdrawStatus;


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

    /**
     * Update withdrawal request status (approve/reject/complete).
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_status(Request $request)
    {
        $result = UpdateWithdrawStatus::execute($request);

        if ($result['success']) {
            Toastr::success($result['message'], 'Success');
            return response()->json($result, 200);
        }

        Toastr::error($result['message'], 'Error');
        return response()->json($result, 400);
    }
}
