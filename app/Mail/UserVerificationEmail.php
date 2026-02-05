<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $sendLinkInfo;
    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->sendLinkInfo = $data;
        $this->mailData = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Verification Code - ' . config('app.name'))
            ->view('backend.mail.userVerificationEmail')
            ->with([
                'sendLinkInfo' => $this->sendLinkInfo,
                'mailData' => $this->mailData,
            ]);
    }
}
