<?php

namespace App\Modules\CRM\Managements\ContactRequest\Actions;

use App\Modules\CRM\Managements\ContactRequest\Database\Models\ContactRequest;

class DeleteContactRequests
{
    public static function execute($id)
    {
        ContactRequest::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully.'
        ];
    }
}
