<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\EmailConfigure;

class GetEmailCredentialInfo
{
    public static function execute(Request $request, $slug)
    {
        try {
            $data = EmailConfigure::where('slug', $slug)->first();

            return [
                'status' => 'success',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
