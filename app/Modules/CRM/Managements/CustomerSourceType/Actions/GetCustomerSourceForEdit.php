<?php

namespace App\Modules\CRM\Managements\CustomerSourceType\Actions;

use App\Modules\CRM\Managements\CustomerSourceType\Database\Models\CustomerSourceType;

class GetCustomerSourceForEdit
{
    public static function execute($slug)
    {
        $data = CustomerSourceType::where('slug', $slug)->first();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
