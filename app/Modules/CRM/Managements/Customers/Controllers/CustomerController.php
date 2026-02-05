<?php

namespace App\Modules\CRM\Managements\Customers\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Modules\CRM\Managements\Customers\Actions\ViewAllCustomer;
use App\Modules\CRM\Managements\Customers\Actions\SaveNewCustomer;
use App\Modules\CRM\Managements\Customers\Actions\GetCustomerForEdit;
use App\Modules\CRM\Managements\Customers\Actions\UpdateCustomer;
use App\Modules\CRM\Managements\Customers\Actions\DeleteCustomer;
use App\Modules\CRM\Managements\Customers\Actions\GetDataForCustomerCreate;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('CRM/Managements/Customers');
    }

    public function addNewCustomer()
    {
        $result = GetDataForCustomerCreate::execute();
        $customer_categories = $result['data']['customer_categories'];
        $customer_source_types = $result['data']['customer_source_types'];
        $users = $result['data']['users'];
        return view('create', compact('customer_categories', 'customer_source_types', 'users'))->with($result);
    }

    public function saveNewCustomer(Request $request)
    {
        $result = SaveNewCustomer::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function viewAllCustomer(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllCustomer::execute($request);
        }
        return view('view');
    }

    public function editCustomer($slug)
    {
        $result = GetCustomerForEdit::execute($slug);
        $data = $result['data'];
        $customer_categories = $result['data']['customer_categories'];
        $customer_source_types = $result['data']['customer_source_types'];
        $users = $result['data']['users'];
        return view('edit', compact('data', 'customer_categories', 'customer_source_types', 'users'))->with($result);
    }

    public function updateCustomer(Request $request)
    {
        $result = UpdateCustomer::execute($request);
        Toastr::success($result['message'], 'Success!');
        return redirect()->route('ViewAllCustomer');
    }

    public function deleteCustomer($slug)
    {
        $result = DeleteCustomer::execute($slug);
        return response()->json([
            'success' => $result['message'],
            'data' => $result['data']
        ]);
    }
}
