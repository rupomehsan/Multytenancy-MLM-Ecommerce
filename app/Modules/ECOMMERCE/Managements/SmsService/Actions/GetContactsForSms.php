<?php

namespace App\Modules\ECOMMERCE\Managements\SmsService\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetContactsForSms
{
    public static function execute(Request $request)
    {
        $data = array();
        $index = 0;
        $customers = DB::table('users')
            ->select('name', 'phone')
            ->where('phone', '!=', '')
            ->whereNotNull('phone')
            ->whereRaw('LENGTH(phone) >= 11')
            ->get();

        foreach ($customers as $customer) {
            $contactNo = trim(str_replace(" ", '', $customer->phone));
            $contactNo = str_replace("+", '', $contactNo);
            $contactNo = str_replace("-", '', $contactNo);

            if (strpos($contactNo, "@") === false && strpos($contactNo, ".") === false) {
                $regex = '/^880/';
                if (!preg_match($regex, $contactNo)) {
                    $contactNo = "88" . $contactNo;
                }
                $data[$index]['name'] = $customer->name;
                $data[$index]['contact'] = $contactNo;
                $index++;
            }
        }

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
