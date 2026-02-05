<?php

namespace App\Modules\ECOMMERCE\Managements\SmsService\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsHistory;

class DeleteSmsHistoryRange
{
    public static function execute(Request $request)
    {
        $currentDate = date("Y-m-d H:i:s");
        $prevDate = date('Y-m-d', strtotime('-15 day', strtotime($currentDate)));
        SmsHistory::where('created_at', '<=', $prevDate)->delete();

        return [
            'status' => 'success',
            'message' => 'SMS Histories are Deleted'
        ];
    }
}
