<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Database\Models\BlogCategory;

class FeatureBlogCategory
{
    public static function execute($slug)
    {
        $data = BlogCategory::where('slug', $slug)->first();

        $data->featured = $data->featured == 0 ? 1 : 0;
        $data->save();

        return [
            'status' => 'success',
            'message' => 'Status Changed successfully.'
        ];
    }
}
