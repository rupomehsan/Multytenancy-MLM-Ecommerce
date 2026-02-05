<?php

namespace App\Modules\ECOMMERCE\Managements\SmsService\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsTemplate;

class UpdateSmsTemplate
{
    public static function execute(Request $request)
    {
        SmsTemplate::where('id', $request->template_id)->update([
            'title' => $request->template_title,
            'description' => $request->template_description,
            'updated_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Tempalte Updated Successfully.'
        ];
    }
}
