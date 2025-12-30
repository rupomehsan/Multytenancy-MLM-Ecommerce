<?php

namespace App\Modules\ECOMMERCE\Managements\SmsService\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsTemplate;

class DeleteSmsTemplate
{
    public static function execute(Request $request, $id)
    {
        SmsTemplate::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'Tempalte Deleted Successfully.'
        ];
    }
}
