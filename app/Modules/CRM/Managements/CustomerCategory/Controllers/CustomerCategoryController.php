<?php

namespace App\Modules\CRM\Managements\CustomerCategory\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Modules\CRM\Managements\CustomerCategory\Actions\ViewAllCustomerCategory;
use App\Modules\CRM\Managements\CustomerCategory\Actions\SaveNewCustomerCategory;
use App\Modules\CRM\Managements\CustomerCategory\Actions\GetCustomerCategoryForEdit;
use App\Modules\CRM\Managements\CustomerCategory\Actions\UpdateCustomerCategory;
use App\Modules\CRM\Managements\CustomerCategory\Actions\DeleteCustomerCategory;

class CustomerCategoryController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('CRM/Managements/CustomerCategory');
    }

    public function addNewCustomerCategory()
    {
        return view('create');
    }

    public function saveNewCustomerCategory(Request $request)
    {
        $result = SaveNewCustomerCategory::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function viewAllCustomerCategory(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllCustomerCategory::execute($request);
        }
        return view('view');
    }

    public function editCustomerCategory($slug)
    {
        $result = GetCustomerCategoryForEdit::execute($slug);
        return view('edit')->with($result);
    }

    public function updateCustomerCategory(Request $request)
    {
        $result = UpdateCustomerCategory::execute($request);
        Toastr::success($result['message'], 'Success!');
        return view('edit', compact('data'))->with($result);
    }

    public function deleteCustomerCategory($slug)
    {
        $result = DeleteCustomerCategory::execute($slug);
        return response()->json([
            'success' => $result['message'],
            'data' => $result['data']
        ]);
    }
}
