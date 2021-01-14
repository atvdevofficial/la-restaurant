<?php

namespace App\Traits;

trait FCM
{
    public function sendPushNotification($tokens, $notification = [], $data = [])
    {
        /**
         * $tokens              = Array of user tokens
         * $notification    = Notification itself {title, body, image (optional)}
         * $data (optional) = Not implemented {key => value,...}
         */

        $header = [
            'Authorization: Key=' . env('FCM_SERVER_KEY', null),
            'Content-Type: Application/json'
        ];

        $payload = [
            'registration_ids' => $tokens,
            'notification' => $notification,
            'data' => array_merge($data, ['click_action' => 'FLUTTER_NOTIFICATION_CLICK'])
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
