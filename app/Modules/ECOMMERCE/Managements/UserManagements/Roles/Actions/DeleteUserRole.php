<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRole;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\RolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRolePermission;

class DeleteUserRole
{
    public static function execute(Request $request, $id)
    {
        $userRoleInfo = UserRole::where('id', $id)->first();
        RolePermission::where('role_id', $userRoleInfo->id)->delete();
        UserRolePermission::where('role_id', $userRoleInfo->id)->delete();
        $userRoleInfo->delete();

        return [
            'status' => 'success',
            'message' => 'Made SuperAdmin Successfully'
        ];
    }
}
