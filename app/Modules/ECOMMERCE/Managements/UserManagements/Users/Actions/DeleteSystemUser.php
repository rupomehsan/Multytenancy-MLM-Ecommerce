<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRolePermission;

class DeleteSystemUser
{
    public static function execute(Request $request, $id)
    {
        $userInfo = User::where('user_type', 2)->where('id', $id)->first();
        UserRolePermission::where('user_id', $userInfo->id)->delete();
        User::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully'
        ];
    }
}
