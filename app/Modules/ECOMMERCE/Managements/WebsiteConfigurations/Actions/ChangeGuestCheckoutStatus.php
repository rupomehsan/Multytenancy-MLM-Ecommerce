<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;

class ChangeGuestCheckoutStatus
{
    public static function execute(Request $request)
    {
        $info = GeneralInfo::first() ?? new GeneralInfo();
        if ($info->guest_checkout == 1) {
            GeneralInfo::updateOrCreate(['id' => 1], [
                'guest_checkout' => 0
            ]);
        } else {
            GeneralInfo::updateOrCreate(['id' => 1], [
                'guest_checkout' => 1
            ]);
        }

        return ['status' => 'success', 'message' => 'Saved successfully.'];
    }
}
