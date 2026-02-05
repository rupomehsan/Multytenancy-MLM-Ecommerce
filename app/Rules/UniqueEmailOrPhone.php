<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class UniqueEmailOrPhone implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the email or phone is unique
        return !User::where('email', $value)
            //    ->orWhere('phone', $value)
            ->exists();
    }

    public function message()
    {
        return 'The email has already been taken';
    }
}
