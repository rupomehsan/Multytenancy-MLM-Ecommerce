<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Actions;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Database\Models\Blog;

class DeleteBlog
{
    public static function execute($slug)
    {
        $data = Blog::where('slug', $slug)->first();

        if ($data->image) {
            if (file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }
        }

        $data->delete();

        return [
            'status' => 'success',
            'message' => 'Blog Deleted successfully.'
        ];
    }
}
