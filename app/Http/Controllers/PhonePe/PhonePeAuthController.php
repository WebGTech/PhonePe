<?php

namespace App\Http\Controllers\PhonePe;

use App\Http\Controllers\Controller;

class PhonePeAuthController extends Controller
{

    public $salt_key;
    public $salt_index;
    public $x_client_id;

    public function __construct()
    {
        $this->salt_key = env('PHONEPAY_SLAT_KEY');
        $this->salt_index = env("PHONEPAY_SLAT_INDEX");
        $this->x_client_id = env("PHONEPAY_CLIENT_ID");
    }

    public function fetchAccessToken($grantToken)
    {

        // CREATING BASE 64 OF TOKEN
        $token = base64_encode('{"grantToken": "'.$grantToken.'"}');

        // CREATING REQUEST
        $request = '{"request": "'.$token.'"}';

        // CREATING X-VERIFY
        $x_verify = hash('sha256', $token."/v3/service/auth/access".$this->salt_key)."###".$this->salt_index;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apps-uat.phonepe.com/v3/service/auth/access',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_HTTPHEADER => [
                "x-verify: $x_verify",
                "x-client-id: ".$this -> x_client_id,
                'content-type: application/json'
            ],
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;

    }

    public function getUserDetails($accessToken)
    {
        $x_verify = hash('sha256', "/v3/service/userdetails".$this->salt_key)."###".$this->salt_index;


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apps-uat.phonepe.com/v3/service/userdetails',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "x-verify: $x_verify",
                "x-client-id: ".$this -> x_client_id,
                "x-access-token: $accessToken"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

}
