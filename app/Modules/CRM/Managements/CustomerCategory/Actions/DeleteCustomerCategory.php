<?php

namespace App\Modules\CRM\Managements\CustomerCategory\Actions;

use App\Modules\CRM\Managements\CustomerCategory\Database\Models\CustomerCategory;

class DeleteCustomerCategory
{
    public static function execute($slug)
    {
        $data = CustomerCategory::where('slug', $slug)->first();
        $data->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully!',
            'data' => 1
        ];
    }
}
