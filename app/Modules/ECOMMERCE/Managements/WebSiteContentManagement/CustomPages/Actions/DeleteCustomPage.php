<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Database\Models\CustomPage;

class DeleteCustomPage
{
    public static function execute($slug)
    {
        $data = CustomPage::where('slug', $slug)->first();
        if ($data->image) {
            if (file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }
        }
        $data->delete();
        return ['status' => 'success', 'message' => 'Page deleted successfully.'];
    }
}
