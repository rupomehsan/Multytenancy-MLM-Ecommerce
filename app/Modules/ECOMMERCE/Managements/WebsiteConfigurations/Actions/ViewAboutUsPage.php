<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\AboutUs;

class ViewAboutUsPage
{
    public static function execute(Request $request)
    {
        $data = AboutUs::first();
        return ['data' => $data];
    }
}
