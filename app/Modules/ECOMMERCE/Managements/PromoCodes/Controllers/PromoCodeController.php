<?php

namespace App\Modules\ECOMMERCE\Managements\PromoCodes\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

use App\Modules\ECOMMERCE\Managements\PromoCodes\Actions\CreatePromoCode;
use App\Modules\ECOMMERCE\Managements\PromoCodes\Actions\ViewAllPromoCodes;
use App\Modules\ECOMMERCE\Managements\PromoCodes\Actions\GetPromoCodeForEdit;
use App\Modules\ECOMMERCE\Managements\PromoCodes\Actions\UpdatePromoCode;
use App\Modules\ECOMMERCE\Managements\PromoCodes\Actions\DeletePromoCode;

use App\Http\Controllers\Controller;

class PromoCodeController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/PromoCodes');
    }

    public function addPromoCode()
    {
        return view('create');
    }

    public function savePromoCode(Request $request)
    {
        $result = CreatePromoCode::execute($request);

        if ($result['status'] === 'success') {
            Toastr::success($result['message'], 'Success');
        } else {
            Toastr::error($result['message'], 'Error');
        }

        return back();
    }

    public function viewAllPromoCodes(Request $request)
    {
        $result = ViewAllPromoCodes::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view('view');
    }

    public function editPromoCode($slug)
    {
        $result = GetPromoCodeForEdit::execute(request(), $slug);
        return view('update')->with('data', $result['data']);
    }

    public function updatePromoCode(Request $request)
    {
        $result = UpdatePromoCode::execute($request);

        if ($result['status'] === 'success') {
            Toastr::success($result['message'], 'Success');
            return redirect()->route('ViewAllPromoCodes');
        } else {
            Toastr::error($result['message'], 'Error');
            return back();
        }
    }

    public function removePromoCode($slug)
    {
        $result = DeletePromoCode::execute(request(), $slug);
        return response()->json(['success' => $result['message']]);
    }
}
