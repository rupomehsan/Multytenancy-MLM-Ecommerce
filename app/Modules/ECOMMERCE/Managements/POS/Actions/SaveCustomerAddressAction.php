<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Database\Models\Outlet;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\UserAddress;

class SaveCustomerAddressAction
{
    public function execute(Request $request): array
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'address_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'post_code' => 'nullable|string|max:20',
            'customer_address_district_id' => 'required',
            'customer_address_thana_id' => 'required',
        ]);

        UserAddress::insert([
            'user_id' => $request->customer_id,
            'address_type' => $request->address_type,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'post_code' => $request->post_code,
            'country' => 'Bangladesh',
            'city' => $request->customer_address_district_id,
            'state' => $request->customer_address_thana_id,
            'slug' => time() . rand(999999, 100000),
            'created_at' => Carbon::now()
        ]);

        return [
            'success' => true,
            'message' => 'New Address Added'
        ];
    }
}
