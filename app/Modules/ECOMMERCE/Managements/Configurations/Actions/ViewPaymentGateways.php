<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Models\PaymentGateway;

class ViewPaymentGateways
{
    public static function execute(Request $request): array
    {
        try {
            $gateways = PaymentGateway::orderBy('id', 'asc')->get();

            return [
                'status' => 'success',
                'gateways' => $gateways,
                'view' => 'payment_gateway'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
