<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Database\Models\BlogCategory;

class SaveRearrangeCategory
{
    public static function execute(Request $request)
    {
        $sl = 1;
        foreach ($request->slug as $slug) {
            BlogCategory::where('slug', $slug)->update([
                'serial' => $sl
            ]);
            $sl++;
        }

        return [
            'status' => 'success',
            'message' => 'Category has been Rerranged'
        ];
    }
}
