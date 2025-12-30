<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;

class DeleteSubcategory
{
    public static function execute(Request $request, $slug)
    {
        $data = Subcategory::where('slug', $slug)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Subcategory not found'
            ];
        }

        if ($data->icon) {
            if (file_exists(public_path($data->icon))) {
                unlink(public_path($data->icon));
            }
        }

        if ($data->image) {
            if (file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }
        }

        $data->delete();

        return [
            'status' => 'success',
            'message' => 'Subcategory deleted successfully.'
        ];
    }
}
