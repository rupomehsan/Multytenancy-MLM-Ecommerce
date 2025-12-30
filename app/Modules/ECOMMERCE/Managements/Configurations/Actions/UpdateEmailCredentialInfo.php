<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\EmailConfigure;

class UpdateEmailCredentialInfo
{
    public static function execute(Request $request): array
    {
        try {
            if ($request->status == 1) {
                DB::table('email_configures')->update([
                    'status' => 0,
                ]);
            }

            EmailConfigure::where('slug', $request->email_config_slug)->update([
                'host' => $request->host,
                'port' => $request->port,
                'email' => $request->email,
                'mail_from_name' => $request->mail_from_name,
                'mail_from_email' => $request->mail_from_email,
                'encryption' => $request->encryption,
                'status' => $request->status,
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
