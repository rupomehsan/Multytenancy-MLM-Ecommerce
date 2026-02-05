<?php

namespace App\Modules\CRM\Managements\CustomerSourceType\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Modules\CRM\Managements\CustomerSourceType\Actions\ViewAllCustomerSource;
use App\Modules\CRM\Managements\CustomerSourceType\Actions\SaveNewCustomerSource;
use App\Modules\CRM\Managements\CustomerSourceType\Actions\GetCustomerSourceForEdit;
use App\Modules\CRM\Managements\CustomerSourceType\Actions\UpdateCustomerSource;
use App\Modules\CRM\Managements\CustomerSourceType\Actions\DeleteCustomerSource;

class CustomerSourceController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('CRM/Managements/CustomerSourceType');
    }

    public function addNewCustomerSource()
    {
        return view('create');
    }

    public function saveNewCustomerSource(Request $request)
    {
        $result = SaveNewCustomerSource::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function viewAllCustomerSource(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllCustomerSource::execute($request);
        }
        return view('view');
    }

    public function editCustomerSource($slug)
    {
        $result = GetCustomerSourceForEdit::execute($slug);
        return view('edit')->with($result);
    }

    public function updateCustomerSource(Request $request)
    {
        $result = UpdateCustomerSource::execute($request);
        Toastr::success($result['message'], 'Success!');
        return redirect()->route('ViewAllCustomerSource');
    }

    public function deleteCustomerSource($slug)
    {
        $result = DeleteCustomerSource::execute($slug);
        return response()->json([
            'success' => $result['message'],
            'data' => $result['data']
        ]);
    }
}
