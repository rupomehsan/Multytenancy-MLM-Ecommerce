<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Database\Models\BlogCategory;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Database\Models\Blog;

class DeleteBlogCategory
{
    public static function execute($slug)
    {
        $data = BlogCategory::where('slug', $slug)->first();

        $used = Blog::where('category_id', $data->id)->count();

        if ($used > 0) {
            return [
                'status' => 'error',
                'message' => 'Category cannot be deleted',
                'data' => 0
            ];
        }

        $data->delete();

        return [
            'status' => 'success',
            'message' => 'Category deleted successfully.',
            'data' => 1
        ];
    }
}
