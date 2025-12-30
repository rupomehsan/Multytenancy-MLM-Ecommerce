<?php

namespace App\Modules\CRM\Managements\EcommerceCustomers\Actions;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class DeleteCustomerEcommerce
{
    public static function execute($slug)
    {
        $data = User::where('id', $slug)->first();

        if ($data->image && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }

        $data->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully!',
            'data' => 1
        ];
    }
}
