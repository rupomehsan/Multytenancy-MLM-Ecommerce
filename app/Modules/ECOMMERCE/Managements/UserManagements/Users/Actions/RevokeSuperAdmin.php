<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class RevokeSuperAdmin
{
    public static function execute(Request $request, $id)
    {
        $userInfo = User::where('id', $id)->first();
        $userInfo->user_type = 2;
        $userInfo->save();

        return [
            'status' => 'success',
            'message' => 'Revoke SuperAdmin Successfully'
        ];
    }
}
