<?php

namespace App\Traits;



trait FireBaseServiceTrait
{
    public function pushNotification($token,$title,$body)
    {
        $SERVER_API_KEY = config("firebase_service.api_key");


        $token_1 = $token;

        $data = [
            "registration_ids" => [
                $token_1
            ],

            "notification" => [
                "title" => $title,
                "body" => $body,
                "sound" => "default"
            ],
        ];

        $data_string = json_encode($data);

        $headers = [
            'Authorization: key='.$SERVER_API_KEY,
            'Content-Type: application/json'
        ];

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data_string);


        $response = curl_exec($ch);

    }
}
