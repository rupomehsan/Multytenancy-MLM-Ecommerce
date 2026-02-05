<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsGateway;

class ChangeSmsGatewayStatus
{
    public static function execute(Request $request, $provider): array
    {
        try {
            DB::table('sms_gateways')->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);

            if ($provider == 'elitbuzz') {
                SmsGateway::where('id', 1)->update([
                    'status' => 1,
                    'updated_at' => Carbon::now()
                ]);
            }

            if ($provider == 'revesms') {
                SmsGateway::where('id', 2)->update([
                    'status' => 1,
                    'updated_at' => Carbon::now()
                ]);
            }

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
