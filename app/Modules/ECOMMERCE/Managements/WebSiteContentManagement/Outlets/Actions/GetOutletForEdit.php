<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Database\Models\Outlet;

class GetOutletForEdit
{
    public static function execute($slug)
    {
        $data = Outlet::where('slug', $slug)->first();
        return ['data' => $data];
    }
}
