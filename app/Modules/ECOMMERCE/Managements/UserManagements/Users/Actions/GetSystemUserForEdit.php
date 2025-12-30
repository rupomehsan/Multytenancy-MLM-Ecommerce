<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class GetSystemUserForEdit
{
    public static function execute(Request $request, $id)
    {
        $userInfo = User::where('id', $id)->first();

        return [
            'status' => 'success',
            'data' => $userInfo
        ];
    }
}
