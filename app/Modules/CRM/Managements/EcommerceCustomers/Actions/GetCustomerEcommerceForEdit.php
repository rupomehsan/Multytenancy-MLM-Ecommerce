<?php

namespace App\Modules\CRM\Managements\EcommerceCustomers\Actions;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class GetCustomerEcommerceForEdit
{
    public static function execute($slug)
    {
        $data = User::where('id', $slug)->first();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
