<?php

namespace App\Modules\CRM\Managements\NextDateContacts\Actions;

use App\Modules\CRM\Managements\Customers\Database\Models\Customer;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class GetDataForNextContactDateCreate
{
    public static function execute()
    {
        $customers = Customer::where('status', 'active')->get();
        $users = User::where('status', 1)->get();

        return [
            'status' => 'success',
            'data' => [
                'customers' => $customers,
                'users' => $users
            ]
        ];
    }
}
