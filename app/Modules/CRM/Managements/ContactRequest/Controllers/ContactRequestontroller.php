<?php

namespace App\Modules\CRM\Managements\ContactRequest\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\CRM\Managements\ContactRequest\Actions\ViewAllContactRequests;
use App\Modules\CRM\Managements\ContactRequest\Actions\DeleteContactRequests;
use App\Modules\CRM\Managements\ContactRequest\Actions\ChangeRequestStatus;

class ContactRequestontroller extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('CRM/Managements/ContactRequest');
    }

    public function viewAllContactRequests(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllContactRequests::execute($request);
        }
        return view('contact_request');
    }

    public function deleteContactRequests($id)
    {
        $result = DeleteContactRequests::execute($id);
        return response()->json(['success' => $result['message']]);
    }

    public function changeRequestStatus($id, Request $request)
    {
        $result = ChangeRequestStatus::execute($id, $request);
        return response()->json(['success' => $result['message']]);
    }
}
