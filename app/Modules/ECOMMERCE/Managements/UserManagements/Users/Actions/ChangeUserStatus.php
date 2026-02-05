<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class ChangeUserStatus
{
    public static function execute(Request $request, $id)
    {
        $userInfo = User::where('id', $id)->first();
        $userInfo->status = $userInfo->status == 1 ? 0 : 1;
        $userInfo->updated_at = Carbon::now();
        $userInfo->save();

        return [
            'status' => 'success',
            'message' => 'Status Changed successfully'
        ];
    }
}
