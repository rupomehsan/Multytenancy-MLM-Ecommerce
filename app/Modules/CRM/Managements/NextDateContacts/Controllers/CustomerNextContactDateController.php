<?php

namespace App\Modules\CRM\Managements\NextDateContacts\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

use App\Modules\CRM\Managements\NextDateContacts\Actions\GetDataForNextContactDateCreate;
use App\Modules\CRM\Managements\NextDateContacts\Actions\SaveNewCustomerNextContactDate;
use App\Modules\CRM\Managements\NextDateContacts\Actions\ViewAllCustomerNextContactDate;
use App\Modules\CRM\Managements\NextDateContacts\Actions\GetCustomerNextContactDateForEdit;
use App\Modules\CRM\Managements\NextDateContacts\Actions\UpdateCustomerNextContactDate;
use App\Modules\CRM\Managements\NextDateContacts\Actions\DeleteCustomerNextContactDate;

class CustomerNextContactDateController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('CRM/Managements/NextDateContacts');
    }

    public function addNewCustomerNextContactDate()
    {
        $result = GetDataForNextContactDateCreate::execute();
        $customers = $result['data']['customers'];
        $users = $result['data']['users'];
        return view('create', compact('customers', 'users'));
    }

    public function saveNewCustomerNextContactDate(Request $request)
    {
        $result = SaveNewCustomerNextContactDate::execute($request);
        
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function viewAllCustomerNextContactDate(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllCustomerNextContactDate::execute($request);
        }
        return view('view');
    }

    public function editCustomerNextContactDate($slug)
    {
        $result = GetCustomerNextContactDateForEdit::execute($slug);
        $data = $result['data']['next_contact_date'];
        $customers = $result['data']['customers'];
        $users = $result['data']['users'];
        return view('edit', compact('data', 'customers', 'users'));
    }

    public function updateCustomerNextContactDate(Request $request)
    {
        $result = UpdateCustomerNextContactDate::execute($request);
        
        Toastr::success($result['message'], 'Success!');
        return redirect()->route('ViewAllCustomerContactHistories');
    }

    public function deleteCustomerNextContactDate($slug)
    {
        $result = DeleteCustomerNextContactDate::execute($slug);
        
        return response()->json([
            'success' => $result['message'],
            'data' => $result['data']
        ]);
    }
}
