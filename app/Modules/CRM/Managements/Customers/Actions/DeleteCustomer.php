<?php

namespace App\Modules\CRM\Managements\Customers\Actions;

use App\Modules\CRM\Managements\Customers\Database\Models\Customer;

class DeleteCustomer
{
    public static function execute($slug)
    {
        $data = Customer::where('slug', $slug)->first();
        $data->status = 'inactive';
        $data->save();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully!',
            'data' => 1
        ];
    }
}
