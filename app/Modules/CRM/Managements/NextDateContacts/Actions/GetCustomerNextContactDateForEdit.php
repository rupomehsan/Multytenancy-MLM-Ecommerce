<?php

namespace App\Modules\CRM\Managements\NextDateContacts\Actions;

use App\Modules\CRM\Managements\NextDateContacts\Database\Models\CustomerNextContactDate;
use App\Modules\CRM\Managements\Customers\Database\Models\Customer;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class GetCustomerNextContactDateForEdit
{
    public static function execute($slug)
    {
        $data = CustomerNextContactDate::where('slug', $slug)->first();
        $customers = Customer::where('status', 'active')->get();
        $users = User::where('status', 1)->get();

        return [
            'status' => 'success',
            'data' => [
                'next_contact_date' => $data,
                'customers' => $customers,
                'users' => $users
            ]
        ];
    }
}
