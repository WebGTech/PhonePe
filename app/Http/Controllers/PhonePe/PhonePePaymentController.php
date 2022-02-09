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
        $x_callback_url = 'https://' . $this->app_url . '/order/' . $order -> sale_or_no;

       /* dd("
            TRANSACTION CONTEXT: $transactionContext \n
            PAYLOAD: $payload \n
            REQUEST: $request \n
            X-VERIFY: $x_verify
        ");*/

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
        return'{
            "orderContext": {
                "trackingInfo": {
                    "type": "HTTPS",
                    "url": "https://'.env('APP_NAME').'/orders/'. $order -> sale_or_no .'"
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
                            "timestamp": ' . Carbon::now() . ',
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
        dd( '{
            "merchantId": "'. $this->x_client_id .'",
            "amount": '. $order -> sale_amt .',
            "validFor": 900000,
            "transactionId": "PAY'. $order -> sale_or_no .'",
            "merchantOrderId": "'. $order -> sale_or_no .'",
            "redirectUrl": "https://'.env('APP_NAME').'/orders/'. $order -> sale_or_no .'",
            "transactionContext": "'. $transactionContext .'"
        }');
    }

    private function createRequest($payload)
    {
        return '{"request": "'. base64_decode($payload) .'"}';
    }

    private function createXVerify($payload)
    {
        dd( hash(
            'sha256',
            base64_encode($payload).
            "/v3/transaction/sdk-less/initiate".
            $this->salt_key
        )."###".$this->salt_index);
    }

}
