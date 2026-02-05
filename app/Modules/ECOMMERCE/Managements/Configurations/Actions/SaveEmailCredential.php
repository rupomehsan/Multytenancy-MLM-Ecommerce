<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\EmailConfigure;

class SaveEmailCredential
{


    public static function execute(Request $request): array
    {
        try {
            $validator = Validator::make($request->all(), [
                'host' => 'required|string|max:255',
                'port' => 'required|numeric',
                'email' => 'required|email|max:255',
                'password' => 'required|string',
                'mail_from_name' => 'required|string|max:255',
                'mail_from_email' => 'required|email|max:255',
                'encryption' => 'nullable|in:0,1,2',
                'status' => 'nullable|in:0,1',
                'email_config_slug' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ];
            }

            // Start transaction
            DB::beginTransaction();

            // If this credential is being set active, deactivate others first
            if ($request->filled('status') && $request->status == 1) {
                DB::table('email_configures')->update([
                    'status' => 0,
                ]);
            }



            $data = [
                'host' => $request->host,
                'port' => $request->port,
                'email' => $request->email,
                'password' => $request->password,
                'mail_from_name' => $request->mail_from_name,
                'mail_from_email' => $request->mail_from_email,
                'encryption' => $request->encryption ?? 0,
                'status' => $request->filled('status') ? (int)$request->status : 1,
            ];

            // Update if slug provided (edit), otherwise insert new record
            if ($request->filled('email_config_slug')) {
                $model = EmailConfigure::where('slug', $request->email_config_slug)->first();
                if (! $model) {
                    DB::rollBack();
                    Log::warning('SaveEmailCredential: model not found for slug ' . $request->email_config_slug);
                    return [
                        'status' => 'error',
                        'message' => 'Email configuration not found.',
                    ];
                }
                $model->update($data);
                DB::commit();
                return [
                    'status' => 'success',
                    'message' => 'Updated successfully.',
                ];
            }

            // Insert new
            $data['slug'] = time() . Str::random(5);

            $created = EmailConfigure::create($data);

            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Created successfully.',
                'data' => $created,
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
 // DB::table('email_configures')->update([
        //     'status' => 0
        // ]);

        // $simple_string = $request->password;
        // $ciphering = "AES-128-CTR";
        // $options = 0;

        // $encryption_iv = '1234567891011121';
        // $encryption_key = "GenericCommerceV1";
        // $encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);

        // $decryption_iv = '1234567891011121';
        // $decryption_key = "GenericCommerceV1";
        // $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);
