<?php

namespace App\Modules\CRM\Managements\CustomerSourceType\Actions;

use App\Modules\CRM\Managements\CustomerSourceType\Database\Models\CustomerSourceType;

class DeleteCustomerSource
{
    public static function execute($slug)
    {
        $data = CustomerSourceType::where('slug', $slug)->first();
        $data->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully!',
            'data' => 1
        ];
    }
}
