<?php

namespace App\Traits;

trait ITextMo
{
    public function sendSMS($contactNumber, $message)
    {
        $url = 'https://www.itexmo.com/php_api/api.php';
        $itexmo = array(
            '1' => $contactNumber,
            '2' => $message,
            '3' => env('ITEXTMO_API_KEY', null),
            'passwd' => env('ITEXTMO_PASSWD', null)
        );

        $param = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($itexmo),
            ),
        );

        $context  = stream_context_create($param);
        return file_get_contents($url, false, $context);
    }
}
