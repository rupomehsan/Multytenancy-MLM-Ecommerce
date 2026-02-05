<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Database\Models\Testimonial;

class DeleteTestimonial
{
    public static function execute($slug)
    {
        $data = Testimonial::where('slug', $slug)->first();
        if ($data->customer_image) {
            if (file_exists(public_path($data->customer_image))) {
                unlink(public_path($data->customer_image));
            }
        }
        $data->delete();
        return ['status' => 'success', 'message' => 'Data deleted successfully.'];
    }
}
