<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Database\Models\BlogCategory;

class GetBlogCategoryInfo
{
    public static function execute($slug)
    {
        $data = BlogCategory::where('slug', $slug)->first();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
