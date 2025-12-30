<?php

namespace App\Modules\ECOMMERCE\Managements\SmsService\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsHistory;

class DeleteSmsHistory
{
    public static function execute(Request $request, $id)
    {
        SmsHistory::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'SMS History has Deleted Successfully.'
        ];
    }
}
