<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PaymentGateway;

class ChangePaymentGatewayStatus
{
    public static function execute(Request $request, $provider): array
    {
        try {
            $gatewayMap = [
                'ssl_commerz' => 1,
                'stripe' => 2,
                'bkash' => 3,
                'amar_pay' => 4
            ];

            if (!isset($gatewayMap[$provider])) {
                return [
                    'status' => 'error',
                    'message' => 'Invalid payment gateway provider.'
                ];
            }

            $gatewayId = $gatewayMap[$provider];
            $info = PaymentGateway::where('id', $gatewayId)->first();

            if (!$info) {
                return [
                    'status' => 'error',
                    'message' => 'Payment gateway not found.'
                ];
            }

            PaymentGateway::where('id', $gatewayId)->update([
                'status' => $info->status == 1 ? 0 : 1,
                'updated_at' => Carbon::now()
            ]);

            return [
                'status' => 'success',
                'message' => 'Updated Successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
