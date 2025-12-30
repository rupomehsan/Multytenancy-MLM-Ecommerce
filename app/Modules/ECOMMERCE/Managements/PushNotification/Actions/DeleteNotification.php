<?php

namespace App\Modules\ECOMMERCE\Managements\PushNotification\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\PushNotification\Database\Models\Notification;

class DeleteNotification
{
    public static function execute(Request $request, $id)
    {
        Notification::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'Notification Deleted Successfully.'
        ];
    }
}
