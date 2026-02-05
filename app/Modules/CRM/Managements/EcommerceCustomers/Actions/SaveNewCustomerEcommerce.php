<?php

namespace App\Modules\CRM\Managements\EcommerceCustomers\Actions;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\UserVerificationEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\EmailConfigure as ModelsEmailConfigure;

class SaveNewCustomerEcommerce
{
    public static function execute(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp,webp', 'max:2048'],
        ]);

        // handle image upload (keep public_path behavior for backward compatibility)
        $image = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_name = Str::random(8) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $location = public_path('userProfileImages/');
            if (!file_exists($location)) {
                mkdir($location, 0755, true);
            }
            $file->move($location, $image_name);
            $image = 'userProfileImages/' . $image_name;
        }

        // create user inside a transaction
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'password' => Hash::make($validated['password']),
                'image' => $image,
                'user_type' => config('role.customer'),
                'verification_code' => Str::random(6),
                'status' => 1,
                'created_at' => Carbon::now()
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => 'Failed to create user: ' . $e->getMessage()
            ];
        }

        // prepare dynamic mail config
        $emailConfig = ModelsEmailConfigure::where('status', 1)->orderBy('id', 'desc')->first();
        if (!$emailConfig) {
            return [
                'status' => 'warning',
                'message' => 'User created but no active email configuration found. Verification email not sent.'
            ];
        }

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => trim($emailConfig->host),
            'mail.mailers.smtp.port' => $emailConfig->port,
            'mail.mailers.smtp.username' => $emailConfig->email,
            'mail.mailers.smtp.password' => $emailConfig->password,
            'mail.mailers.smtp.encryption' => $emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : null),
            'mail.from.address' => $emailConfig->email,
            'mail.from.name' => $emailConfig->mail_from_name,
        ]);

        // attempt sending verification email but do not fail the whole request if mail fails
        try {
            Mail::to($user->email)->send(new UserVerificationEmail($user));
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Mail error: ' . $e->getMessage()
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Added successfully!'
        ];
    }
}
