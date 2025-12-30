<?php

namespace App\Modules\CRM\Managements\Customers\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\CRM\Managements\Customers\Database\Models\Customer;

class SaveNewCustomer
{
    public static function execute(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'phone' => ['required'],
        ], [
            'name.required' => 'name is required.',
        ]);

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name));
        $slug = preg_replace('!\s+!', '-', $clean);

        Customer::insert([
            'customer_category_id' => $request->customer_category_id ?? '',
            'customer_source_type_id' => $request->customer_source_type_id ?? '',
            'reference_by' => $request->reference_id ?? '',
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'creator' => auth()->user()->id,
            'slug' => $slug . time(),
            'status' => 'active',
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Added successfully!'
        ];
    }
}
