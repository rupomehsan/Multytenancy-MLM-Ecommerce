<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class CreateSystemUser
{
    public static function execute(Request $request)
    {
        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'balance' => 0,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'New System User Created'
        ];
    }
}
