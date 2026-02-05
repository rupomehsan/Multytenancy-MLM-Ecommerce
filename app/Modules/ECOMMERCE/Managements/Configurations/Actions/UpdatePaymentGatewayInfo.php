<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PaymentGateway;

class UpdatePaymentGatewayInfo
{


    public static function execute(Request $request): array
    {
        try {
            $provider = $request->provider_name;

            if ($provider == 'ssl_commerz') {
                PaymentGateway::where('id', 1)->update([
                    'api_key' => $request->api_key,
                    'secret_key' => $request->secret_key,
                    'username' => $request->username,
                    'password' => $request->password,
                    'live' => $request->live == '' ? 0 : $request->live,
                    'status' => $request->status,
                    'updated_at' => Carbon::now()
                ]);
            }

            if ($provider == 'stripe') {
                PaymentGateway::where('id', 2)->update([
                    'api_key' => $request->api_key,
                    'secret_key' => $request->secret_key,
                    'username' => $request->username,
                    'password' => $request->password,
                    'live' => $request->live == '' ? 0 : $request->live,
                    'status' => $request->status,
                    'updated_at' => Carbon::now()
                ]);
            }

            if ($provider == 'bkash') {
                PaymentGateway::where('id', 3)->update([
                    'api_key' => $request->api_key,
                    'secret_key' => $request->secret_key,
                    'username' => $request->username,
                    'password' => $request->password,
                    'live' => $request->live == '' ? 0 : $request->live,
                    'status' => $request->status,
                    'updated_at' => Carbon::now()
                ]);
            }

            if ($provider == 'amar_pay') {
                PaymentGateway::where('id', 4)->update([
                    'api_key' => $request->api_key,
                    'secret_key' => $request->secret_key,
                    'username' => $request->username,
                    'password' => $request->password,
                    'live' => $request->live == '' ? 0 : $request->live,
                    'status' => $request->status,
                    'updated_at' => Carbon::now()
                ]);
            }

            return [
                'status' => 'success',
                'message' => 'Payment gateway info updated successfully.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
