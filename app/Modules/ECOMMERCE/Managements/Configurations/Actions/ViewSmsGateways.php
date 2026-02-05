<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsGateway;

class ViewSmsGateways
{
    public static function execute(Request $request): array
    {
        try {
            $gateways = SmsGateway::orderBy('id', 'asc')->get();

            return [
                'status' => 'success',
                'gateways' => $gateways,
                'view' => 'sms_gateway'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
