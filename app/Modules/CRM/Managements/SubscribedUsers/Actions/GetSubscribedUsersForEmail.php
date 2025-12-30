<?php

namespace App\Modules\CRM\Managements\SubscribedUsers\Actions;

use App\Modules\CRM\Managements\SubscribedUsers\Database\Models\SubscribedUsers;

class GetSubscribedUsersForEmail
{
    public static function execute()
    {
        $subscribedUsers = SubscribedUsers::orderBy('id', 'desc')->get();

        return [
            'status' => 'success',
            'subscribedUsers' => $subscribedUsers
        ];
    }
}
