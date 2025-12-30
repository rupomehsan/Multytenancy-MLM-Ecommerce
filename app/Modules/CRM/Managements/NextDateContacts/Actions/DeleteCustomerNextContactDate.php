<?php

namespace App\Modules\CRM\Managements\NextDateContacts\Actions;

use App\Modules\CRM\Managements\NextDateContacts\Database\Models\CustomerNextContactDate;

class DeleteCustomerNextContactDate
{
    public static function execute($slug)
    {
        $data = CustomerNextContactDate::where('slug', $slug)->first();

        $data->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully!',
            'data' => 1
        ];
    }
}
