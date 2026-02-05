<?php

namespace App\Modules\CRM\Managements\SupportTickets\Actions;

use App\Modules\CRM\Managements\SupportTickets\Database\Models\SupportMessage;
use App\Modules\CRM\Managements\SupportTickets\Database\Models\SupportTicket;

class GetSupportMessagesForView
{
    public static function execute($slug)
    {
        $data = SupportTicket::where('slug', $slug)->first();
        $messages = SupportMessage::where('support_ticket_id', $data->id)->orderBy('id', 'asc')->get();

        return [
            'status' => 'success',
            'data' => [
                'ticket' => $data,
                'messages' => $messages
            ]
        ];
    }
}
