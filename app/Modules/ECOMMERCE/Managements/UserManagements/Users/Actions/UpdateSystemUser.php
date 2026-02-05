<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class UpdateSystemUser
{
    public static function execute(Request $request)
    {
        User::where('id', $request->user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_type' => $request->user_type,
            'updated_at' => Carbon::now()
        ]);

        if ($request->password) {
            User::where('id', $request->user_id)->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return [
            'status' => 'success',
            'message' => 'System User Info Updated'
        ];
    }
}
