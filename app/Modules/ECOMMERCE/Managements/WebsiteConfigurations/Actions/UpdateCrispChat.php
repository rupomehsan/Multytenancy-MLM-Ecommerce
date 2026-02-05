<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;

class UpdateCrispChat
{
    public static function execute(Request $request)
    {
        GeneralInfo::where('id', 1)->update([
            'crisp_chat_status' => $request->crisp_chat_status,
            'crisp_website_id' => $request->crisp_website_id,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Crisp Chat Info Updated'];
    }
}
