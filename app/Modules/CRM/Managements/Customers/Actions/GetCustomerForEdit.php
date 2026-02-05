<?php

namespace App\Modules\CRM\Managements\Customers\Actions;

use App\Modules\CRM\Managements\Customers\Database\Models\Customer;
use App\Modules\CRM\Managements\CustomerCategory\Database\Models\CustomerCategory;
use App\Modules\CRM\Managements\CustomerSourceType\Database\Models\CustomerSourceType;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class GetCustomerForEdit
{
    public static function execute($slug)
    {
        $data = Customer::where('slug', $slug)->first();
        $customer_categories = CustomerCategory::where('status', 'active')->get();
        $customer_source_types = CustomerSourceType::where('status', 'active')->get();
        $users = User::where('status', 1)->get();

        return [
            'status' => 'success',
            'data' => $data,
            'customer_categories' => $customer_categories,
            'customer_source_types' => $customer_source_types,
            'users' => $users
        ];
    }
}
