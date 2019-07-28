<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Postal extends Controller
{
    public static function postalCode($postalCode = '', $houseNo = '')
    {
        /*$headers = array();
        $headers[] = 'X-Api-Key: kvUMzfXDBX42r8UIktczH7hStH8J9LRm3Wjyq3B4';
        // De URL naar de API call
        $url = "https://api.postcodeapi.nu/v2/addresses/?postcode=$postalCode&number=$houseNo";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // De ruwe JSON response
        $response = curl_exec($curl);

        // Gebruik json_decode() om de response naar een PHP array te converteren
        $data = json_decode($response,true);

        return $data;
        curl_close($curl);*/
        // echo $data['_embedded']['addresses'][0]['street'];
        // echo $data['_embedded']['addresses'][0]['city']['label'];
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.postcodeapi.nu/v2/addresses/?postcode=$postalCode&number=$houseNo",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/hal+json",
                // "x-api-key: kvUMzfXDBX42r8UIktczH7hStH8J9LRm3Wjyq3B4"
                "x-api-key: vjE1GrGf6e3mbg7DDdE5w87sgWVsMwW51nngOLia",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $data = json_decode($response, true);
    }
    public function CheckPostal(Request $request)
    {
        $postal = $request->postal;
        $house = $request->house;
        
        if (!empty($postal) && !empty($house)) {
            $send = new Postal();
            $data = $send->postalCode($postal, $house);
            if (!empty($data['_embedded']['addresses'])) {
                $postalArr = array();
                $postalArr['address'] = $data['_embedded']['addresses'][0]['street'];
                $postalArr['city'] = $data['_embedded']['addresses'][0]['city']['label'];
                $response = array('status' => 1, 'message' => 'data found', 'data' => $postalArr);
            } else {
                $response = array('status' => 0, 'message' => $data['error']);
            }
        } else {
            $response = array('status' => 0, 'message' => 'Please enter postal and house number');
        }
        echo json_encode($response);
    }

}
