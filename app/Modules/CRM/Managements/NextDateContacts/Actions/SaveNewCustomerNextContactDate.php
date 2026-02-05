<?php

namespace App\Modules\CRM\Managements\NextDateContacts\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Modules\CRM\Managements\NextDateContacts\Database\Models\CustomerNextContactDate;

class SaveNewCustomerNextContactDate
{
    public static function execute(Request $request)
    {
        $request->validate([
            'customer_id' => ['required'],
            'next_date' => ['required'],
        ], [
            'customer_id.required' => 'customer is required.',
        ]);

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower(request()->date)); //remove all non alpha numeric
        $slug = preg_replace('!\s+!', '-', $clean);

        CustomerNextContactDate::insert([
            'customer_id' => request()->customer_id ?? '',
            'employee_id' => request()->employee_id ?? '',
            'next_date' => request()->next_date,
            'contact_status' => request()->contact_status ?? 'pending',
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
