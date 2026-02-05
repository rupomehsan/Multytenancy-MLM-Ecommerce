<?php

namespace App\Modules\ECOMMERCE\Managements\SmsService\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsTemplate;

class CreateSmsTemplate
{
    public static function execute(Request $request)
    {
        SmsTemplate::insert([
            'title' => $request->title,
            'description' => $request->description,
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Template has save'
        ];
    }
}
