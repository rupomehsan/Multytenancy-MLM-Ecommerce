<?php

namespace App\Modules\CRM\Managements\SubscribedUsers\Actions;

use App\Modules\CRM\Managements\SubscribedUsers\Database\Models\SubscribedUsers;

class DeleteSubscribedUsers
{
    public static function execute($id)
    {
        SubscribedUsers::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully.'
        ];
    }
}
