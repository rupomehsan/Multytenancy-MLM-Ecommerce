<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;

class UpdateTawkChat
{
    public static function execute(Request $request)
    {
        GeneralInfo::where('id', 1)->update([
            'tawk_chat_status' => $request->tawk_chat_status,
            'tawk_chat_link' => $request->tawk_chat_link,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Tawk Chat Info Updated'];
    }
}
