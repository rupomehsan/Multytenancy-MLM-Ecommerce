<?php

namespace App\Modules\CRM\Managements\SupportTickets\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Modules\CRM\Managements\SupportTickets\Database\Models\SupportMessage;

class SendSupportMessage
{
    public static function execute(Request $request)
    {
        $request->validate([
            'support_ticket_id' => 'required',
            'message' => 'required',
        ]);

        $attachment = NULL;
        if ($request->hasFile('attachment')) {
            $get_attachment = $request->file('attachment');
            $attachment_name = str::random(5) . time() . '.' . $get_attachment->getClientOriginalExtension();
            $relativeDir = 'uploads/support_ticket_attachments/';
            $location = public_path($relativeDir);

            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }

            $get_attachment->move($location, $attachment_name);
            $attachment = $relativeDir . $attachment_name;
        }

        SupportMessage::insert([
            'support_ticket_id' => $request->support_ticket_id,
            'sender_id' => Auth::user()->id,
            'sender_type' => 1, //Support Agent
            'message' => $request->message,
            'attachment' => $attachment,
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Message has been Send'
        ];
    }
}
