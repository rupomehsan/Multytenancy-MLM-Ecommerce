<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Database\Models\Testimonial;

class GetTestimonialForEdit
{
    public static function execute($slug)
    {
        $data = Testimonial::where('slug', $slug)->first();
        return ['data' => $data];
    }
}
