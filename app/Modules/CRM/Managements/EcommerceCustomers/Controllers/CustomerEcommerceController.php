<?php

namespace App\Modules\CRM\Managements\EcommerceCustomers\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

use App\Modules\CRM\Managements\EcommerceCustomers\Actions\SaveNewCustomerEcommerce;
use App\Modules\CRM\Managements\EcommerceCustomers\Actions\ViewAllCustomerEcommerce;
use App\Modules\CRM\Managements\EcommerceCustomers\Actions\GetCustomerEcommerceForEdit;
use App\Modules\CRM\Managements\EcommerceCustomers\Actions\UpdateCustomerEcommerce;
use App\Modules\CRM\Managements\EcommerceCustomers\Actions\DeleteCustomerEcommerce;

class CustomerEcommerceController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('CRM/Managements/EcommerceCustomers');
    }

    public function addNewCustomerEcommerce()
    {
        return view('create');
    }

    public function saveNewCustomerEcommerce(Request $request)
    {
        $result = SaveNewCustomerEcommerce::execute($request);
        
        if ($result['status'] == 'success') {
            Toastr::success($result['message'], 'Success');
        } elseif ($result['status'] == 'warning') {
            Toastr::warning($result['message'], 'Warning');
        } else {
            Toastr::error($result['message'], 'Error');
            return back()->withInput();
        }
        
        return back();
    }

    public function viewAllCustomerEcommerce(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllCustomerEcommerce::execute($request);
        }
        return view('view');
    }

    public function editCustomerEcommerce($slug)
    {
        $result = GetCustomerEcommerceForEdit::execute($slug);
        $data = $result['data'];
        return view('edit', compact('data'));
    }

    public function updateCustomerEcommerce(Request $request)
    {
        $result = UpdateCustomerEcommerce::execute($request);
        
        Toastr::success($result['message'], 'Success!');
        $data = $result['data'];
        return view('edit', compact('data'));
    }

    public function deleteCustomerEcommerce($slug)
    {
        $result = DeleteCustomerEcommerce::execute($slug);
        
        return response()->json([
            'success' => $result['message'],
            'data' => $result['data']
        ]);
    }
}
