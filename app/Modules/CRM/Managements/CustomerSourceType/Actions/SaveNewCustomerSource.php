<?php

namespace App\Modules\CRM\Managements\CustomerSourceType\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\CRM\Managements\CustomerSourceType\Database\Models\CustomerSourceType;

class SaveNewCustomerSource
{
    public static function execute(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->title));
        $slug = preg_replace('!\s+!', '-', $clean);

        CustomerSourceType::insert([
            'title' => $request->title,
            'description' => $request->description,
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
