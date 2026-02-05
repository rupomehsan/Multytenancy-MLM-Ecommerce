<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;

class UpdateWebsiteThemeColor
{
    public static function execute(Request $request)
    {
        GeneralInfo::where('id', 1)->update([
            'primary_color' => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'tertiary_color' => $request->tertiary_color,
            'title_color' => $request->title_color,
            'paragraph_color' => $request->paragraph_color,
            'border_color' => $request->border_color,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Website Theme Color Updated'];
    }
}
