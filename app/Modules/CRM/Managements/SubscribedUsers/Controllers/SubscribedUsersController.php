<?php

namespace App\Modules\CRM\Managements\SubscribedUsers\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\CRM\Managements\SubscribedUsers\Actions\ViewAllSubscribedUsers;
use App\Modules\CRM\Managements\SubscribedUsers\Actions\DeleteSubscribedUsers;
use App\Modules\CRM\Managements\SubscribedUsers\Actions\DownloadSubscribedUsersExcel;
use App\Modules\CRM\Managements\SubscribedUsers\Actions\GetSubscribedUsersForEmail;
use App\Modules\CRM\Managements\SubscribedUsers\Actions\SendBulkEmail;

class SubscribedUsersController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('CRM/Managements/SubscribedUsers');
    }

    public function viewAllSubscribedUsers(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllSubscribedUsers::execute($request);
        }
        return view('subscribed_users');
    }

    public function deleteSubscribedUsers($id)
    {
        $result = DeleteSubscribedUsers::execute($id);
        return response()->json(['success' => $result['message']]);
    }

    public function downloadSubscribedUsersExcel()
    {
        return DownloadSubscribedUsersExcel::execute();
    }

    public function sendEmailPage()
    {
        $result = GetSubscribedUsersForEmail::execute();
        return view('send_email_subscribed_users', compact('subscribedUsers'))->with($result);
    }

    public function sendBulkEmail(Request $request)
    {
        $result = SendBulkEmail::execute($request);
        
        if ($result['status'] == 'error') {
            return response()->json(['error' => $result['message']], $result['code']);
        }
        
        return response()->json(['success' => $result['message']]);
    }
}
