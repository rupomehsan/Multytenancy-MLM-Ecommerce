<?php

namespace App\Modules\CRM\Managements\CustomerCategory\Actions;

use App\Modules\CRM\Managements\CustomerCategory\Database\Models\CustomerCategory;

class GetCustomerCategoryForEdit
{
    public static function execute($slug)
    {
        $data = CustomerCategory::where('slug', $slug)->first();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
