<?php

namespace App\Modules\CRM\Managements\NextDateContacts\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Modules\CRM\Managements\NextDateContacts\Database\Models\CustomerNextContactDate;

class UpdateCustomerNextContactDate
{
    public static function execute(Request $request)
    {
        $request->validate([
            'customer_id' => ['required'],
        ], [
            'customer_id.required' => 'customer is required.',
        ]);

        $data = CustomerNextContactDate::where('id', request()->customer_next_contact_date_id)->first();

        $data->customer_id = request()->customer_id ?? $data->customer_id;
        $data->employee_id = request()->employee_id ?? $data->employee_id;
        $data->next_date = request()->next_date ?? $data->next_date;
        $data->contact_status = request()->contact_status ?? $data->contact_status;
        $data->creator = auth()->user()->id;
        $data->status = request()->status ?? $data->status;
        $data->updated_at = Carbon::now();
        $data->save();

        return [
            'status' => 'success',
            'message' => 'Successfully Updated'
        ];
    }
}
