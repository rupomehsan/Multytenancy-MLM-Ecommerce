<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\ViewAllUserRoles;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\GetRoleFormData;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\CreateUserRole;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\DeleteUserRole;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\GetUserRoleForEdit;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\UpdateUserRole;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\ViewUserRolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\GetUserRoleAssignmentData;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions\SaveAssignedRolePermission;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/UserManagements/Roles');
    }
    
    public function viewAllUserRoles(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllUserRoles::execute($request);
        }
        return view('user_roles_view');
    }

    public function newUserRole()
    {
        $result = GetRoleFormData::execute(request());
        return view('user_role_create', $result['data']);
    }

    public function saveUserRole(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:user_roles'],
        ]);

        $result = CreateUserRole::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect()->route('ViewAllUserRoles');
    }

    public function deleteUserRole($id)
    {
        $result = DeleteUserRole::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }

    public function EditUserRole($id)
    {
        $result = GetUserRoleForEdit::execute(request(), $id);
        return view('user_role_edit', $result['data']);
    }

    public function UpdateUserRole(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $result = UpdateUserRole::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect()->route('ViewAllUserRoles');
    }

    public function viewUserRolePermission(Request $request)
    {
        if ($request->ajax()) {
            return ViewUserRolePermission::execute($request);
        }
        return view('user_role_permission');
    }

    public function assignRolePermission($id)
    {
        $result = GetUserRoleAssignmentData::execute(request(), $id);
        return view('user_role_permission_assign', $result['data']);
    }

    public function SaveAssignedRolePermission(Request $request)
    {
        $result = SaveAssignedRolePermission::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect('view/user/role/permission');
    }
}
