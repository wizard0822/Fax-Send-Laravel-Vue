<?php

namespace App\Helpers;

class PostBode
{
    public static function SendLetter($name, $content)
    {
        $data = array(
            'documents' => array(array(
                'name' => $name,
                'content' => $content)),
            'envelope_id' => 2,
            'country' => 'NL',
            'registered' => false,
            'send' => true,
        );
        $post = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.postbode.nu/api/mailbox/2968/letters");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Authorization: d9780428ed21a3b37de1f3b0929c0bda30110ffe',
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = json_decode(curl_exec($ch));

        curl_close($ch);
        return $server_output;
    }

    public static function getLetters()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.postbode.nu/api/mailbox/2968/letters");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Authorization: d9780428ed21a3b37de1f3b0929c0bda30110ffe',
            'Content-Type: application/json',
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = json_decode(curl_exec($ch));

        curl_close($ch);

        return $server_output;
    }
}
