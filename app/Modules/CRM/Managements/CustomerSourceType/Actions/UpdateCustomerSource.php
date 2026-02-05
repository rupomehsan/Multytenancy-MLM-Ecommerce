<?php

namespace App\Modules\CRM\Managements\CustomerSourceType\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\CRM\Managements\CustomerSourceType\Database\Models\CustomerSourceType;

class UpdateCustomerSource
{
    public static function execute(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $data = CustomerSourceType::where('id', $request->customer_source_id)->first();
        $originalTitle = $data->title;

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->title));
        $slug = preg_replace('!\s+!', '-', $clean);

        $data->title = $request->title ?? $data->title;
        $data->description = $request->description ?? $data->description;

        if ($originalTitle != $request->title) {
            $data->slug = $slug . time();
        }

        $data->creator = auth()->user()->id;
        $data->status = $request->status ?? $data->status;
        $data->updated_at = Carbon::now();
        $data->save();

        return [
            'status' => 'success',
            'message' => 'Updated Successfully',
            'data' => $data
        ];
    }
}
