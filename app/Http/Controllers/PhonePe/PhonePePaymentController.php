<?php

namespace App\Http\Controllers\PhonePe;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhonePePaymentController extends Controller
{
    public $salt_key;
    public $salt_index;
    public $x_client_id;

    public $app_url;

    public function __construct()
    {
        $this->salt_key = env('PHONEPAY_SLAT_KEY');
        $this->salt_index = env("PHONEPAY_SLAT_INDEX");
        $this->x_client_id = env("PHONEPAY_CLIENT_ID");
        $this->app_url = env('APP_URL');
    }

    public function pay($order)
    {
        $transactionContext = base64_encode($this->createCart($order));
        $payload = $this->createPayload($order, $transactionContext);
        $request = $this->createRequest($payload);
        $x_verify = $this->createXVerify($payload);
        $client_id = $this->x_client_id;
        $x_callback_url = $this->app_url . '/order/' . $order -> sale_or_no;

       print_r("TRANSACTION CONTEXT: " . $transactionContext);
       print_r("PAYLOAD: " . $payload);
       print_r("X_VERIFY: " . $x_verify);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://apps-uat.phonepe.com/v3/transaction/sdk-less/initiate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "$request",
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                "X-CALLBACK-URL: $x_callback_url",
                "X-CLIENT-ID: $client_id",
                "X-VERIFY: $x_verify"
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

    private function createCart($order)
    {
        $app_url = env('APP_URL');
        return'{
            "orderContext": {
                "trackingInfo": {
                    "type": "HTTPS",
                    "url": "'. $app_url ."/order/". $order -> sale_or_no .'"
                }
            },
            "fareDetails": {
                "totalAmount":' . $order -> sale_amt . ',
                "payableAmount":' . $order -> sale_amt . '
            },
            "cartDetails": {
                "cartItems": [
                    {
                        "category": "TRAIN",
                        "itemId":"' . $order -> sale_or_no . '",
                        "price":' . $order -> sale_amt . ',
                        "from": {
                            "stationName": "' . $order -> source_name . '"
                        },
                        "to": {
                            "stationName": "' . $order -> destination_name . '"
                        },
                        "dateOfTravel": {
                            "timestamp": "' . Carbon::now() . '",
                            "zoneOffSet": "+05:30"
                        },
                        "numOfPassengers": ' . $order -> unit . '
                    }
                ]
            }
        }';
    }

    private function createPayload($order, $transactionContext)
    {
        $app_url = env('APP_URL');
        return '{
            "merchantId": "'. $this->x_client_id .'",
            "amount": '. $order -> sale_amt .',
            "validFor": 900000,
            "transactionId": "PAY'. $order -> sale_or_no .'",
            "merchantOrderId": "'. $order -> sale_or_no .'",
            "redirectUrl": "' . $app_url . "/orders/" . $order -> sale_or_no .'",
            "transactionContext": "'. $transactionContext .'"
        }';
    }

    private function createRequest($payload)
    {
        return '{"request": "'. base64_decode($payload) .'"}';
    }

    private function createXVerify($payload)
    {
        return hash(
            'sha256',
            base64_encode($payload).
            "/v3/transaction/sdk-less/initiate".
            $this->salt_key
        )."###".$this->salt_index;
    }

}

/*TRANSACTION CONTEXT: ewogICAgICAgICAgICAib3JkZXJDb250ZXh0IjogewogICAgICAgICAgICAgICAgInRyYWNraW5nSW5mbyI6IHsKICAgICAgICAgICAgICAgICAgICAidHlwZSI6ICJIVFRQUyIsCiAgICAgICAgICAgICAgICAgICAgInVybCI6ICJodHRwOi8vUGhvbmVQZS50ZXN0L29yZGVyL0FURUs5MTc5NzcxOTI4NzU2MjA0MjkwOCIKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgfSwKICAgICAgICAgICAgImZhcmVEZXRhaWxzIjogewogICAgICAgICAgICAgICAgInRvdGFsQW1vdW50IjozNSwKICAgICAgICAgICAgICAgICJwYXlhYmxlQW1vdW50IjozNQogICAgICAgICAgICB9LAogICAgICAgICAgICAiY2FydERldGFpbHMiOiB7CiAgICAgICAgICAgICAgICAiY2FydEl0ZW1zIjogWwogICAgICAgICAgICAgICAgICAgIHsKICAgICAgICAgICAgICAgICAgICAgICAgImNhdGVnb3J5IjogIlRSQUlOIiwKICAgICAgICAgICAgICAgICAgICAgICAgIml0ZW1JZCI6IkFURUs5MTc5NzcxOTI4NzU2MjA0MjkwOCIsCiAgICAgICAgICAgICAgICAgICAgICAgICJwcmljZSI6MzUsCiAgICAgICAgICAgICAgICAgICAgICAgICJmcm9tIjogewogICAgICAgICAgICAgICAgICAgICAgICAgICAgInN0YXRpb25OYW1lIjogIkF6YWQgTmFnYXIiCiAgICAgICAgICAgICAgICAgICAgICAgIH0sCiAgICAgICAgICAgICAgICAgICAgICAgICJ0byI6IHsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICJzdGF0aW9uTmFtZSI6ICJXZXN0ZXJuIEV4cHJlc3MiCiAgICAgICAgICAgICAgICAgICAgICAgIH0sCiAgICAgICAgICAgICAgICAgICAgICAgICJkYXRlT2ZUcmF2ZWwiOiB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAidGltZXN0YW1wIjogMjAyMi0wMi0wOSAyMDo1MDoxNiwKICAgICAgICAgICAgICAgICAgICAgICAgICAgICJ6b25lT2ZmU2V0IjogIiswNTozMCIKICAgICAgICAgICAgICAgICAgICAgICAgfSwKICAgICAgICAgICAgICAgICAgICAgICAgIm51bU9mUGFzc2VuZ2VycyI6IDYKICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBdCiAgICAgICAgICAgIH0KICAgICAgICB9

PAYLOAD: {
    "merchantId": "CHANGETEST11",
            "amount": 35,
            "validFor": 900000,
            "transactionId": "PAYATEK91797719287562042908",
            "merchantOrderId": "ATEK91797719287562042908",
            "redirectUrl": "http://PhonePe.test/orders/ATEK91797719287562042908",
            "transactionContext": "ewogICAgICAgICAgICAib3JkZXJDb250ZXh0IjogewogICAgICAgICAgICAgICAgInRyYWNraW5nSW5mbyI6IHsKICAgICAgICAgICAgICAgICAgICAidHlwZSI6ICJIVFRQUyIsCiAgICAgICAgICAgICAgICAgICAgInVybCI6ICJodHRwOi8vUGhvbmVQZS50ZXN0L29yZGVyL0FURUs5MTc5NzcxOTI4NzU2MjA0MjkwOCIKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgfSwKICAgICAgICAgICAgImZhcmVEZXRhaWxzIjogewogICAgICAgICAgICAgICAgInRvdGFsQW1vdW50IjozNSwKICAgICAgICAgICAgICAgICJwYXlhYmxlQW1vdW50IjozNQogICAgICAgICAgICB9LAogICAgICAgICAgICAiY2FydERldGFpbHMiOiB7CiAgICAgICAgICAgICAgICAiY2FydEl0ZW1zIjogWwogICAgICAgICAgICAgICAgICAgIHsKICAgICAgICAgICAgICAgICAgICAgICAgImNhdGVnb3J5IjogIlRSQUlOIiwKICAgICAgICAgICAgICAgICAgICAgICAgIml0ZW1JZCI6IkFURUs5MTc5NzcxOTI4NzU2MjA0MjkwOCIsCiAgICAgICAgICAgICAgICAgICAgICAgICJwcmljZSI6MzUsCiAgICAgICAgICAgICAgICAgICAgICAgICJmcm9tIjogewogICAgICAgICAgICAgICAgICAgICAgICAgICAgInN0YXRpb25OYW1lIjogIkF6YWQgTmFnYXIiCiAgICAgICAgICAgICAgICAgICAgICAgIH0sCiAgICAgICAgICAgICAgICAgICAgICAgICJ0byI6IHsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICJzdGF0aW9uTmFtZSI6ICJXZXN0ZXJuIEV4cHJlc3MiCiAgICAgICAgICAgICAgICAgICAgICAgIH0sCiAgICAgICAgICAgICAgICAgICAgICAgICJkYXRlT2ZUcmF2ZWwiOiB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAidGltZXN0YW1wIjogMjAyMi0wMi0wOSAyMDo1MDoxNiwKICAgICAgICAgICAgICAgICAgICAgICAgICAgICJ6b25lT2ZmU2V0IjogIiswNTozMCIKICAgICAgICAgICAgICAgICAgICAgICAgfSwKICAgICAgICAgICAgICAgICAgICAgICAgIm51bU9mUGFzc2VuZ2VycyI6IDYKICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBdCiAgICAgICAgICAgIH0KICAgICAgICB9"
        }

X_VERIFY: 81af61b29c19ae3fb33ca629eac3c95e53b8fef3c21861bd5d6edd430fb4451b###1*/
