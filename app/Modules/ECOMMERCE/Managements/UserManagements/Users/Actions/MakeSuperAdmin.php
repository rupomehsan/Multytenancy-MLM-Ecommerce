<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class MakeSuperAdmin
{
    public static function execute(Request $request, $id)
    {
        $userInfo = User::where('id', $id)->first();
        $userInfo->user_type = 1;
        $userInfo->save();

        return [
            'status' => 'success',
            'message' => 'Made SuperAdmin Successfully'
        ];
    }
}
