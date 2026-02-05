<?php

namespace App\Modules\ECOMMERCE\Managements\SmsService\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsGateway;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsHistory;
use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsTemplate;

class SendSms
{
    public static function execute(Request $request)
    {
        $template_id = $request->template_id;
        if ($template_id) {
            $template_title = SmsTemplate::where('id', $request->template_id)->first() ? SmsTemplate::where('id', $request->template_id)->first()->title : '';
        }
        $template_description = $request->template_description;

        $sending_type = $request->sending_type;
        $individual_contacts = array();
        $individual_contacts = $request->individual_contact;

        $sms_receivers = $request->sms_receivers;
        $min_order = $request->min_order ? $request->min_order : 0;
        $max_order = $request->max_order ? $request->max_order : 0;
        $min_order_value = $request->min_order_value ? $request->min_order_value : 0;
        $max_order_value = $request->max_order_value ? $request->max_order_value : 0;
        $data = array();

        if ($sending_type == 1) { //individual sms

            if ($individual_contacts && count($individual_contacts) >= 1) {

                $smsGateway = SmsGateway::where('status', 1)->first();
                if (!$smsGateway) {
                    return [
                        'status' => 'error',
                        'message' => 'No SMS Api is Active'
                    ];
                }

                foreach ($individual_contacts as $individual_contact) {
                    if ($smsGateway && $smsGateway->provider_name == 'Reve') {
                        // $response = Http::get($smsGateway->api_endpoint, [
                        //     'apikey' => $smsGateway->api_key,
                        //     'secretkey' => $smsGateway->secret_key,
                        //     "callerID" => $smsGateway->sender_id,
                        //     "toUser" => $individual_contact,
                        //     "messageContent" => $template_description
                        // ]);
                    } elseif ($smsGateway && $smsGateway->provider_name == 'ElitBuzz') {
                        // $response = Http::get($smsGateway->api_endpoint, [
                        //     'api_key' => $smsGateway->api_key,
                        //     "type" => "text",
                        //     "contacts" => $individual_contact, //"88017xxxxxxxx,88018xxxxxxxx"
                        //     "senderid" => $smsGateway->sender_id,
                        //     "msg" => $template_description
                        // ]);
                    } else {
                        return [
                            'status' => 'error',
                            'message' => 'No SMS Api is Active'
                        ];
                    }

                    // if($response->status() == 200){
                    SmsHistory::insert([
                        'template_id' => $template_id,
                        'template_title' => $template_title,
                        'template_description' => $template_description,
                        'sending_type' => $sending_type,
                        'individual_contact' => $individual_contact,
                        'sms_receivers' => $sms_receivers,
                        'min_order' => $min_order,
                        'max_order' => $max_order,
                        'min_order_value' => $min_order_value,
                        'max_order_value' => $max_order_value,
                        'created_at' => Carbon::now()
                    ]);
                    // }
                }
            }

            return [
                'status' => 'success',
                'message' => 'Sms has sent'
            ];
        } else {

            $index = 0;
            $customers = DB::table('users')->where('phone', '!=', '')->whereNotNull('phone')->whereRaw('LENGTH(phone) >= 11')->groupBy('phone')->get();
            foreach ($customers as $customer) {

                $contactNo = trim(str_replace(" ", '', $customer->phone));
                $contactNo = str_replace("+", '', $contactNo);
                $contactNo = str_replace("-", '', $contactNo);

                if (strpos($contactNo, "@") === false && strpos($contactNo, ".") === false) {
                    $regex = '/^880/';
                    if (!preg_match($regex, $contactNo)) {
                        $contactNo = "88" . $contactNo;
                    }

                    if ($sms_receivers == 1) { //having no order
                        if (!Order::where('user_id', $customer->id)->exists()) {
                            $data[$index]['user_id'] = $customer->id;
                            $data[$index]['contact'] = $contactNo;
                            $index++;
                        }
                    } else {

                        if (Order::where('user_id', $customer->id)->exists()) {
                            $totalOrderCount = Order::where('user_id', $customer->id)->count();
                            $totalOrderValue = Order::where('user_id', $customer->id)->sum('total');

                            if ($min_order > 0 && $totalOrderCount < $min_order) {
                                continue;
                                // skipping the loop as it failes to meet the criteria
                            }
                            if ($max_order > 0 && $totalOrderCount > $max_order) {
                                continue;
                                // skipping the loop as it failes to meet the criteria
                            }
                            if ($min_order_value > 0 && $min_order_value < $totalOrderValue) {
                                continue;
                                // skipping the loop as it failes to meet the criteria
                            }
                            if ($max_order_value > 0 && $min_order_value > $totalOrderValue) {
                                continue;
                                // skipping the loop as it failes to meet the criteria
                            }

                            $data[$index]['user_id'] = $customer->id;
                            $data[$index]['contact'] = $contactNo;
                            $index++;
                        }
                    }
                }
            }

            foreach ($data as $user) {

                $smsGateway = SmsGateway::where('status', 1)->first();
                if ($smsGateway && $smsGateway->provider_name == 'Reve') {
                    // $response = Http::get($smsGateway->api_endpoint, [
                    //     'apikey' => $smsGateway->api_key,
                    //     'secretkey' => $smsGateway->secret_key,
                    //     "callerID" => $smsGateway->sender_id,
                    //     "toUser" => $individual_contact,
                    //     "messageContent" => $template_description
                    // ]);
                } elseif ($smsGateway && $smsGateway->provider_name == 'ElitBuzz') {
                    // $response = Http::get($smsGateway->api_endpoint, [
                    //     'api_key' => $smsGateway->api_key,
                    //     "type" => "text",
                    //     "contacts" => $individual_contact, //"88017xxxxxxxx,88018xxxxxxxx"
                    //     "senderid" => $smsGateway->sender_id,
                    //     "msg" => $template_description
                    // ]);
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'No SMS Api is Active'
                    ];
                }

                // if($response->status() == 200){
                SmsHistory::insert([
                    'template_id' => $template_id,
                    'template_title' => $template_title,
                    'template_description' => $template_description,
                    'sending_type' => $sending_type,
                    'individual_contact' => $user['contact'],
                    'sms_receivers' => $sms_receivers,
                    'min_order' => $min_order,
                    'max_order' => $max_order,
                    'min_order_value' => $min_order_value,
                    'max_order_value' => $max_order_value,
                    'created_at' => Carbon::now()
                ]);
                // }
            }
        }

        return [
            'status' => 'success',
            'message' => 'Sms has sent'
        ];
    }
}
