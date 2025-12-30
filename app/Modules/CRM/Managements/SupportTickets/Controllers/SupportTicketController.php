<?php

namespace App\Modules\CRM\Managements\SupportTickets\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\CRM\Managements\SupportTickets\Actions\ViewPendingSupportTickets;
use App\Modules\CRM\Managements\SupportTickets\Actions\ViewSolvedSupportTickets;
use App\Modules\CRM\Managements\SupportTickets\Actions\ViewOnHoldSupportTickets;
use App\Modules\CRM\Managements\SupportTickets\Actions\ViewRejectedSupportTickets;
use App\Modules\CRM\Managements\SupportTickets\Actions\DeleteSupportTicket;
use App\Modules\CRM\Managements\SupportTickets\Actions\ChangeStatusSupport;
use App\Modules\CRM\Managements\SupportTickets\Actions\ChangeStatusSupportOnHold;
use App\Modules\CRM\Managements\SupportTickets\Actions\ChangeStatusSupportRejected;
use App\Modules\CRM\Managements\SupportTickets\Actions\ChangeStatusSupportInProgress;
use App\Modules\CRM\Managements\SupportTickets\Actions\GetSupportMessagesForView;
use App\Modules\CRM\Managements\SupportTickets\Actions\SendSupportMessage;

class SupportTicketController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('CRM/Managements/SupportTickets');
    }

    public function pendingSupportTickets(Request $request)
    {
        if ($request->ajax()) {
            return ViewPendingSupportTickets::execute($request);
        }
        return view('pending');
    }

    public function solvedSupportTickets(Request $request)
    {
        if ($request->ajax()) {
            return ViewSolvedSupportTickets::execute($request);
        }
        return view('solved');
    }

    public function onHoldSupportTickets(Request $request)
    {
        if ($request->ajax()) {
            return ViewOnHoldSupportTickets::execute($request);
        }
        return view('hold');
    }

    public function rejectedSupportTickets(Request $request)
    {
        if ($request->ajax()) {
            return ViewRejectedSupportTickets::execute($request);
        }
        return view('rejected');
    }

    public function deleteSupportTicket($slug)
    {
        $result = DeleteSupportTicket::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function changeStatusSupport($slug)
    {
        $result = ChangeStatusSupport::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function changeStatusSupportOnHold($slug)
    {
        $result = ChangeStatusSupportOnHold::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function changeStatusSupportRejected($slug)
    {
        $result = ChangeStatusSupportRejected::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function changeStatusSupportInProgress($slug)
    {
        $result = ChangeStatusSupportInProgress::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function viewSupportMessage($slug)
    {
        $result = GetSupportMessagesForView::execute($slug);
        $data = $result['data']['ticket'];
        $messages = $result['data']['messages'];
        return view('messages', compact('data', 'messages'));
    }

    public function sendSupportMessage(Request $request)
    {
        $result = SendSupportMessage::execute($request);
        
        Toastr::success($result['message'], 'Success');
        return back();
    }
}
