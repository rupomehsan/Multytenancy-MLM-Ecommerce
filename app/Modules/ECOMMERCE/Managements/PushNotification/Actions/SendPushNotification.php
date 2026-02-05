<?php

namespace App\Modules\ECOMMERCE\Managements\PushNotification\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Google\Client;
use App\Modules\ECOMMERCE\Managements\PushNotification\Database\Models\Notification;

class SendPushNotification
{
    public static function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'topic' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $title = $request->title;
        $body = $request->description;
        $topic_url = $request->topic ?? url("/");

        $tokens = DB::table('fcm_tokens')->pluck('token');

        if ($tokens->isEmpty()) {
            return [
                'status' => 'error',
                'message' => 'No FCM tokens found.'
            ];
        }

        $serviceAccountPath = storage_path('app/firebase/firebase-service-account.json');
        $client = new Client();
        $client->setAuthConfig($serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];

        $projectId = json_decode(file_get_contents($serviceAccountPath), true)['project_id'];
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        foreach ($tokens as $token) {
            $message = [
                "message" => [
                    "token" => $token,
                    "data" => [
                        "title" => $title,
                        "body" => $body,
                        "icon" => url('logo.jpg'),
                        "link" => $topic_url
                    ],
                    "webpush" => [
                        "fcm_options" => [
                            "link" => $topic_url,
                        ]
                    ]
                ]
            ];

            Notification::insert([
                'title' => $title,
                'description' => $body,
                'created_at' => Carbon::now()
            ]);

            $response = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $message);
        }

        return [
            'status' => 'success',
            'message' => 'Notifications sent Succesffully.'
        ];
    }
}
