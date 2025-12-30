<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsGateway;

class UpdateSmsGatewayInfo
{
    public static function execute(Request $request): array
    {
        try {
            $provider = $request->provider;

            DB::table('sms_gateways')->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);

            if ($provider == 'elitbuzz') {
                SmsGateway::where('id', 1)->update([
                    'api_endpoint' => $request->api_endpoint,
                    'api_key' => $request->api_key,
                    'sender_id' => $request->sender_id,
                    'status' => 1,
                    'updated_at' => Carbon::now()
                ]);
            }

            if ($provider == 'revesms') {
                SmsGateway::where('id', 2)->update([
                    'api_endpoint' => $request->api_endpoint,
                    'api_key' => $request->api_key,
                    'secret_key' => $request->secret_key,
                    'sender_id' => $request->sender_id,
                    'status' => 1,
                    'updated_at' => Carbon::now()
                ]);
            }

            return [
                'status' => 'success',
                'message' => 'Info Updated'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
