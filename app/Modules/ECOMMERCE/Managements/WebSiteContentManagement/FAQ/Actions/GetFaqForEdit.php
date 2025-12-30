<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Actions;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Database\Models\Faq;

class GetFaqForEdit
{
    public static function execute($slug)
    {
        $data = Faq::where('slug', $slug)->first();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
