<?php

namespace App\Modules\CRM\Managements\EcommerceCustomers\Actions;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class UpdateCustomerEcommerce
{
    public static function execute(Request $request)
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

        return [
            'status' => 'success',
            'message' => 'Updated Successfully',
            'data' => $user
        ];
    }
}
