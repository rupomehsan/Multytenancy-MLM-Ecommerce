<?php

namespace App\Modules\CRM\Managements\ContactRequest\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\ContactRequestReply;
use Illuminate\Support\Facades\Mail;
use App\Modules\CRM\Managements\ContactRequest\Database\Models\ContactRequest;

class ChangeRequestStatus
{
    public static function execute($id, Request $request)
    {
        ContactRequest::where('id', $id)->update([
            'status' => 1,
            'updated_at' => Carbon::now()
        ]);

        $email = $request->query('email');
        $subject = $request->query('subject');
        $message = $request->query('message');

        if ($email && $subject && $message) {
            Mail::to($email)->queue(new ContactRequestReply($subject, $message));
        }

        return [
            'status' => 'success',
            'message' => 'Changed successfully and email sent if provided.'
        ];
    }
}
