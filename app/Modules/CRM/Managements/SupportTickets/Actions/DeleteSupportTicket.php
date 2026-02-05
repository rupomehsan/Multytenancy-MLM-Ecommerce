<?php

namespace App\Modules\CRM\Managements\SupportTickets\Actions;

use App\Modules\CRM\Managements\SupportTickets\Database\Models\SupportMessage;
use App\Modules\CRM\Managements\SupportTickets\Database\Models\SupportTicket;

class DeleteSupportTicket
{
    public static function execute($slug)
    {
        $data = SupportTicket::where('slug', $slug)->first();
        if ($data->attachment) {
            if (file_exists(public_path($data->attachment))) {
                unlink(public_path($data->attachment));
            }
        }
        SupportMessage::where('support_ticket_id', $data->id)->delete();
        $data->delete();

        return [
            'status' => 'success',
            'message' => 'Support deleted successfully.'
        ];
    }
}
