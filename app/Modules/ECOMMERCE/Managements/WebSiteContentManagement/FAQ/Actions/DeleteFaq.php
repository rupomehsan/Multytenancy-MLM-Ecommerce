<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Actions;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Database\Models\Faq;

class DeleteFaq
{
    public static function execute($slug)
    {
        Faq::where('slug', $slug)->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully.'
        ];
    }
}
