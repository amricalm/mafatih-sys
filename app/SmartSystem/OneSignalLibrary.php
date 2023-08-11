<?php

namespace App\SmartSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OneSignalLibrary extends Model
{
    public static function sendMessage($array)
    {
        $fields = array(
            'app_id' => config('onesignal_appid'),
            'included_segments' => array(
                'Subscribed Users',
                'Inactive Users',
                'Active Users'
            ),
            'url' => $array['url'],
            'contents' => array(
                'en' => $array['konten'],
            ),
            'headings' => array(
                'en' => $array['judul'],
            )
        );

        $fields = json_encode($fields);

        $text_respond = [];
        $text_respond['json_sent'] = $fields;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.config('onesignal_apikey')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        $id = $data['id'];
        $text_respond['id'] = $id;
        $text_respond['json_received'] = $response;

        return json_encode($text_respond);
    }
}
