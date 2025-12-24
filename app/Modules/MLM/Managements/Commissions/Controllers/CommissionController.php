<?php

namespace App\Modules\MLM\Managements\Commissions\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;


use App\Modules\MLM\Managements\Commissions\Actions\Create;
use App\Modules\MLM\Managements\Commissions\Actions\Update;
use App\Modules\MLM\Managements\Commissions\Actions\ViewCommissionRecords;

class CommissionController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Commissions');
    }
    public function settings()
    {
        $result = Create::execute();

        return view('settings', compact('result'));
    }
    public function update(Request $request)
    {
        $result = Update::execute($request);

        return redirect()->back()->with('success', $result['message'] ?? 'Settings updated successfully.');
    }
    public function record(Request $request)
    {
        if ($request->ajax()) {
            return ViewCommissionRecords::execute($request);
        }
        return view('records');
    }
}
