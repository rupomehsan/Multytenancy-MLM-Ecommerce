<?php

namespace App\Modules\MLM\Managements\PassiveIncome\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\MLM\Managements\PassiveIncome\Actions\Index as LoadIndexAction;
use App\Modules\MLM\Managements\PassiveIncome\Actions\SavePassiveIncomeAction;



class PassiveIncomeController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/PassiveIncome');
    }
    public function index(Request $request, LoadIndexAction $action)
    {
        $data = $action->handle($request);

        return view('index', $data);
    }

    /**
     * Update or create passive income stats from the submitted form.
     */
    public function update(Request $request, SavePassiveIncomeAction $action)
    {
        $userId = auth()->check() ? auth()->id() : null;

        $action->handle($request, $userId);

        Toastr::success('Passive income stats and content saved successfully.');

        return redirect()->route('mlm.passive.income');
    }
}
