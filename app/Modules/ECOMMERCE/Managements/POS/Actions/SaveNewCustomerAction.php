<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class SaveNewCustomerAction
{
    public function execute(Request $request): array
    {
        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::insert([
            'name' => $request->customer_name,
            'phone' => $request->customer_phone,
            'email' => $request->customer_email,
            'email_verified_at' => Carbon::now(),
            'verification_code' => 000000,
            'password' => Hash::make($request->password),
            'user_type' => 3,
            'balance' => 0,
            'status' => 1,
            'created_at' => Carbon::now()
        ]);

        return [
            'success' => true,
            'message' => 'New Customer Created'
        ];
    }
}
