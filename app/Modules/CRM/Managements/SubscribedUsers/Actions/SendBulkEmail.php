<?php

namespace App\Modules\CRM\Managements\SubscribedUsers\Actions;

use Illuminate\Http\Request;
use App\Mail\ContactRequestReply;
use Illuminate\Support\Facades\Mail;

class SendBulkEmail
{
    public static function execute(Request $request)
    {
        $emails = $request->input('emails', []);
        $subject = $request->input('subject');
        $message = $request->input('message');

        if (empty($emails) || !$subject || !$message) {
            return [
                'status' => 'error',
                'message' => 'Please select at least one email and fill subject/message.',
                'code' => 422
            ];
        }

        foreach ($emails as $email) {
            Mail::to($email)->queue(new ContactRequestReply($subject, $message));
        }

        return [
            'status' => 'success',
            'message' => 'Emails are being sent via queue.'
        ];
    }
}
