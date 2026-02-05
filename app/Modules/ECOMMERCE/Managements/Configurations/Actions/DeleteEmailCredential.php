<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\EmailConfigure;

class DeleteEmailCredential
{
    public static function execute(Request $request, $slug): array
    {
        try {
            EmailConfigure::where('slug', $slug)->delete();

            return [
                'status' => 'success',
                'message' => 'Deleted Successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
