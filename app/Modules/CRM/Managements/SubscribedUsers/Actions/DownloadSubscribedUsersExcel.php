<?php

namespace App\Modules\CRM\Managements\SubscribedUsers\Actions;

use Maatwebsite\Excel\Facades\Excel;
use App\Modules\CRM\Managements\SubscribedUsers\Database\Models\SubscribedUsersExcel;

class DownloadSubscribedUsersExcel
{
    public static function execute()
    {
        return Excel::download(new SubscribedUsersExcel, 'subscribed_users.xlsx');
    }
}
