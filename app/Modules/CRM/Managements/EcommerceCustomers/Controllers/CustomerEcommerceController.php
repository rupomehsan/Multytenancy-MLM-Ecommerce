<?php

namespace App\Modules\CRM\Managements\EcommerceCustomers\Controllers;

use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\UserVerificationEmail;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\EmailConfigure as ModelsEmailConfigure;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\UserActivity;

class CustomerEcommerceController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('CRM/Managements/EcommerceCustomers');
    }
    public function addNewCustomerEcommerce()
    {
        return view('create');
    }

    public function saveNewCustomerEcommerce(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
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
            Toastr::error('Failed to create user: ' . $e->getMessage(), 'Error');
            return back()->withInput();
        }

        // prepare dynamic mail config
        $emailConfig = ModelsEmailConfigure::where('status', 1)->orderBy('id', 'desc')->first();
        if (!$emailConfig) {
            Toastr::warning('User created but no active email configuration found. Verification email not sent.', 'Warning');
            return back();
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
            Toastr::error('Mail error: ' . $e->getMessage(), '❌ Mail error');
        }

        Toastr::success('Added successfully!', 'Success');
        return back();
    }

    public function viewAllCustomerEcommerce(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('user_type', 3)
                ->orderBy('id', 'desc')  // Order by ID in descending order
                ->get();

            return Datatables::of($data)
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return 'Active';
                    } else {
                        return 'Inactive';
                    }
                })
                ->addColumn('active_status', function ($data) {
                    $activity = UserActivity::where('user_id', $data->id)->first();

                    if ($activity && $activity->last_seen) {
                        $diff = Carbon::now()->diffInMinutes($activity->last_seen);
                        if ($diff < 1) {
                            return '<span class="badge" style="background: linear-gradient(90deg, #00c853 0%, #43e97b 100%); color: #fff; font-weight: 600; border-radius: 12px; padding: 6px 14px; font-size: 14px;"><i class="fas fa-circle" style="color:#fff; margin-right:6px;"></i>Active now</span>';
                        } elseif ($diff < 2) {
                            return '<span class="badge" style="background: linear-gradient(90deg, #ff9800 0%, #ffc107 100%); color: #fff; font-weight: 600; border-radius: 12px; padding: 6px 14px; font-size: 14px;">
                                <i class="fas fa-clock" style="color:#fff; margin-right:6px;"></i>
                                Last seen ' . $diff . ' min ago
                            </span>';
                        } else {
                            UserActivity::where('user_id', $data->id)->delete();
                            return '<span class="badge" style="background: linear-gradient(90deg, #434343 0%, #262626 100%); color: #fff; font-weight: 600; border-radius: 12px; padding: 6px 14px; font-size: 14px;"><i class="fas fa-circle" style="color:#888; margin-right:6px;"></i>Offline</span>';
                        }
                    } else {
                        return '<span class="badge" style="background: linear-gradient(90deg, #434343 0%, #262626 100%); color: #fff; font-weight: 600; border-radius: 12px; padding: 6px 14px; font-size: 14px;"><i class="fas fa-circle" style="color:#888; margin-right:6px;"></i>Offline</span>';
                    }
                })
                ->addColumn('name', function ($data) {
                    return $data->name ? $data->name : 'N/A';
                })
                ->editColumn('image', function ($data) {
                    if ($data->image && file_exists(public_path($data->image))) {
                        return $data->image;
                    }
                })
                ->addColumn('phone', function ($data) {
                    return $data->phone ? $data->phone : 'N/A';
                })
                ->addColumn('email', function ($data) {
                    return $data->email ? $data->email : 'N/A';
                })
                ->addColumn('address', function ($data) {
                    return $data->address ? $data->address : 'N/A';
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . url('edit/customer-ecommerce') . '/' . $data->id . '" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'active_status'])
                ->make(true);
        }
        return view('view');
    }


    public function editCustomerEcommerce($slug)
    {
        $data = User::where('id', $slug)->first();
        return view('edit', compact('data'));
    }

    public function updateCustomerEcommerce(Request $request)
    {
        $user = User::findOrFail($request->id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,' . $user->id . ',id'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $image = $user->image;

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            $get_image = $request->file('image');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('userProfileImages/');
            $get_image->move($location, $image_name);
            $image = "userProfileImages/" . $image_name;
        }

        $user->update([
            'name' => $request->name ?? $user->name,
            'phone' => $request->phone ?? $user->phone,
            'email' => $request->email ?? $user->email,
            'address' => $request->address ?? $user->address,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'image' => $image ?? $user->image,
            'user_type' => 3,
            'status' => 1,
            'updated_at' => Carbon::now()
        ]);

        $data = $user;

        // $emailConfig = EmailConfigure::where('status', 1)->orderBy('id', 'desc')->first();

        // if (!$emailConfig) {
        //     return response()->json(['error' => 'No active email configuration found.']);
        // }

        // $userEmail = trim(request()->email);

        // if (!$userEmail) {
        //     return response()->json(['error' => 'No email provided.']);
        // }
        // // Set mail config dynamically
        // config([
        //     'mail.default' => 'smtp',
        //     'mail.mailers.smtp.transport' => 'smtp',
        //     'mail.mailers.smtp.host' => trim($emailConfig->host), // e.g., smtp.gmail.com
        //     'mail.mailers.smtp.port' => $emailConfig->port,
        //     'mail.mailers.smtp.username' => $emailConfig->email,
        //     'mail.mailers.smtp.password' => $emailConfig->password,
        //     'mail.mailers.smtp.encryption' => $emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : null),
        //     'mail.from.address' => $emailConfig->email,
        //     'mail.from.name' => $emailConfig->mail_from_name,
        // ]);

        // // logger('Mail config:', config('mail.mailers.smtp'));

        // try {
        //     Mail::to($userEmail)->send(new UserVerificationEmail($data));
        //     return response()->json(['success' => '✅ Email sent!']);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => '❌ Mail error: ' . $e->getMessage()]);
        // }

        Toastr::success('Updated Successfully', 'Success!');
        return view('edit', compact('data'));
    }


    public function deleteCustomerEcommerce($slug)
    {
        $data = user::where('id', $slug)->first();

        if ($data->image && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }

        $data->delete();

        return response()->json([
            'success' => 'Deleted successfully!',
            'data' => 1
        ]);
    }
}
