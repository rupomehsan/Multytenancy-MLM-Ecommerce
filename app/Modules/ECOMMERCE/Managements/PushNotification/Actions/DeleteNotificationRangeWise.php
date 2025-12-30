<?php

namespace App\Modules\ECOMMERCE\Managements\PushNotification\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\PushNotification\Database\Models\Notification;

class DeleteNotificationRangeWise
{
    public static function execute(Request $request)
    {
        $currentDate = date("Y-m-d H:i:s");
        $prevDate = date('Y-m-d', strtotime('-15 day', strtotime($currentDate)));
        Notification::where('created_at', '<=', $prevDate)->delete();

        return [
            'status' => 'success',
            'message' => 'Notifications are Deleted'
        ];
    }
}
