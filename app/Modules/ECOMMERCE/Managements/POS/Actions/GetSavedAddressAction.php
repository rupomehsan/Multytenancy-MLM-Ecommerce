<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class GetSavedAddressAction
{
    public function execute(Request $request): array
    {
        $userId = $request->user_id ?? $request->route('user_id');

        $savedAddressed = DB::table('user_addresses')
            ->where('user_id', $userId)
            ->get();

        $userInfo = User::where('id', $userId)->first();

        return [
            'saved_addressed' => $savedAddressed,
            'user_info' => $userInfo
        ];
    }
}
