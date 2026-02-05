<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions\ViewAllCustomers;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions\ViewAllSystemUsers;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions\CreateSystemUser;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions\DeleteSystemUser;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions\GetSystemUserForEdit;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions\UpdateSystemUser;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions\ChangeUserStatus;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions\DeleteCustomer;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions\MakeSuperAdmin;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions\RevokeSuperAdmin;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\CustomerExcel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/UserManagements/Users');
    }
    
    public function viewAllCustomers(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllCustomers::execute($request);
        }
        return view('customers');
    }

    public function viewAllSystemUsers(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllSystemUsers::execute($request);
        }
        return view('system_users');
    }

    public function addNewSystemUsers()
    {
        return view('add_system_user');
    }

    public function createSystemUsers(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
            'user_type' => ['required', 'integer', 'in:2,4'],
        ]);

        $result = CreateSystemUser::execute($request);
        Toastr::success($result['message'], 'Successfully Created');
        return redirect()->route('ViewAllSystemUsers');
    }

    public function deleteSystemUser($id)
    {
        $result = DeleteSystemUser::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }

    public function editSystemUser($id)
    {
        $result = GetSystemUserForEdit::execute(request(), $id);
        return view('edit_system_user', ['userInfo' => $result['data']]);
    }

    public function updateSystemUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'user_type' => ['required', 'integer', 'in:2,4'],
        ]);

        $result = UpdateSystemUser::execute($request);
        Toastr::success($result['message'], 'Successfully Updated');
        return redirect()->route('ViewAllSystemUsers');
    }

    public function changeUserStatus($id)
    {
        $result = ChangeUserStatus::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }

    public function deleteCustomer($id)
    {
        $result = DeleteCustomer::execute(request(), $id);
        return response()->json(['success' => $result['message'], 'data' => $result['data']]);
    }

    public function downloadCustomerExcel()
    {
        return Excel::download(new CustomerExcel, 'customers.xlsx');
    }

    public function makeSuperAdmin($id)
    {
        $result = MakeSuperAdmin::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }

    public function revokeSuperAdmin($id)
    {
        $result = RevokeSuperAdmin::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }
}
