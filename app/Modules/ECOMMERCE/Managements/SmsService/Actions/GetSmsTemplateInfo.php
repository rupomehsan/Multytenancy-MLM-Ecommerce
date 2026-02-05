<?php

namespace App\Modules\ECOMMERCE\Managements\SmsService\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsTemplate;

class GetSmsTemplateInfo
{
    public static function execute(Request $request, $id)
    {
        $data = SmsTemplate::where('id', $id)->first();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
