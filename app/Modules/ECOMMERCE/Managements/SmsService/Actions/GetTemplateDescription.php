<?php

namespace App\Modules\ECOMMERCE\Managements\SmsService\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsTemplate;

class GetTemplateDescription
{
    public static function execute(Request $request)
    {
        $data = SmsTemplate::where('id', $request->template_id)->first();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
