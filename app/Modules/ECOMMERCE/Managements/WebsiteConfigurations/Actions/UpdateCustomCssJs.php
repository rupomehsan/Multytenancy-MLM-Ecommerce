<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;

class UpdateCustomCssJs
{
    public static function execute(Request $request)
    {
        GeneralInfo::where('id', 1)->update([
            'custom_css' => $request->custom_css,
            'header_script' => $request->header_script,
            'footer_script' => $request->footer_script,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Custom CSS & JS Code Updated'];
    }
}
