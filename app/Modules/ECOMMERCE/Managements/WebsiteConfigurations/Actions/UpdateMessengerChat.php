<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;

class UpdateMessengerChat
{
    public static function execute(Request $request)
    {
        GeneralInfo::where('id', 1)->update([
            'messenger_chat_status' => $request->messenger_chat_status,
            'fb_page_id' => $request->fb_page_id,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Messenger Chat Info Updated'];
    }
}
