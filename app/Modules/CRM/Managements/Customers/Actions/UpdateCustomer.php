<?php

namespace App\Modules\CRM\Managements\Customers\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\CRM\Managements\Customers\Database\Models\Customer;

class UpdateCustomer
{
    public static function execute(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'phone' => ['required'],
        ], [
            'name.required' => 'name is required.',
        ]);

        $data = Customer::where('id', $request->customer_id)->first();
        $originalName = $data->name;

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name));
        $slug = preg_replace('!\s+!', '-', $clean);

        $data->customer_category_id = $request->customer_category_id ?? $data->customer_category_id;
        $data->customer_source_type_id = $request->customer_source_type_id ?? $data->customer_source_type_id;
        $data->reference_by = $request->reference_id ?? $data->reference_by;
        $data->name = $request->name ?? $data->name;
        $data->phone = $request->phone ?? $data->phone;
        $data->email = $request->email ?? $data->email;
        $data->address = $request->address ?? $data->address;

        if ($originalName != $request->name) {
            $data->slug = $slug . time();
        }

        $data->creator = auth()->user()->id;
        $data->status = $request->status ?? $data->status;
        $data->updated_at = Carbon::now();
        $data->save();

        return [
            'status' => 'success',
            'message' => 'Successfully Updated'
        ];
    }
}
