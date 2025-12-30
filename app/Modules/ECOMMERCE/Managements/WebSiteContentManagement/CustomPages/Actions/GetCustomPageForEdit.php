<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Database\Models\CustomPage;

class GetCustomPageForEdit
{
    public static function execute($slug)
    {
        $data = CustomPage::where('slug', $slug)->first();
        return ['data' => $data];
    }
}
