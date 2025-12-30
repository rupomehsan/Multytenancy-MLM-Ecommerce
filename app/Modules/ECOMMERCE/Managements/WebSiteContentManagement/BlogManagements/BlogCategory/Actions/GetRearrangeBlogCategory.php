<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Database\Models\BlogCategory;

class GetRearrangeBlogCategory
{
    public static function execute()
    {
        $categories = BlogCategory::orderBy('serial', 'asc')->get();

        return [
            'status' => 'success',
            'categories' => $categories
        ];
    }
}
