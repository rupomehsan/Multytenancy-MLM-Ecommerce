<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Actions;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Database\Models\Blog;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Database\Models\BlogCategory;

class GetBlogForEdit
{
    public static function execute($slug)
    {
        $data = Blog::where('slug', $slug)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Blog not found',
                'data' => null,
                'categoriesDropdown' => null
            ];
        }

        $categoriesDropdown = BlogCategory::getDropDownList('name', $data->category_id);

        return [
            'status' => 'success',
            'data' => $data,
            'categoriesDropdown' => $categoriesDropdown
        ];
    }
}
