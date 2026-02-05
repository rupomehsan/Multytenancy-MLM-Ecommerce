<?php

namespace App\Modules\ECOMMERCE\Managements\PushNotification\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\PushNotification\Actions\SendPushNotification;
use App\Modules\ECOMMERCE\Managements\PushNotification\Actions\ViewAllPushNotifications;
use App\Modules\ECOMMERCE\Managements\PushNotification\Actions\DeleteNotification;
use App\Modules\ECOMMERCE\Managements\PushNotification\Actions\DeleteNotificationRangeWise;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/PushNotification');
    }
    public function sendNotificationPage()
    {
        return view("send");
    }

    public function sendPushNotification(Request $request)
    {
        $result = SendPushNotification::execute($request);

        if ($result['status'] === 'error') {
            Toastr::error($result['message'], 'Error');
            return back();
        }

        Toastr::success($result['message'], 'Successful');
        return back();
    }

    public function ViewAllPushNotifications(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllPushNotifications::execute($request);
        }

        return view('view');
    }

    public function deleteNotification($id)
    {
        $result = DeleteNotification::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }

    public function deleteNotificationRangeWise()
    {
        $result = DeleteNotificationRangeWise::execute(request());
        Toastr::error($result['message'], 'Successful');
        return back();
    }
}
