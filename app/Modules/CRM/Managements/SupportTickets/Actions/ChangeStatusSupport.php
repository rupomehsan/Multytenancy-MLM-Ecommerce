<?php

namespace App\Modules\CRM\Managements\SupportTickets\Actions;

use App\Modules\CRM\Managements\SupportTickets\Database\Models\SupportTicket;

class ChangeStatusSupport
{
    public static function execute($slug)
    {
        $data = SupportTicket::where('slug', $slug)->first();
        $data->status = $data->status + 1;
        $data->save();

        return [
            'status' => 'success',
            'message' => 'Status Changed successfully.'
        ];
    }
}
