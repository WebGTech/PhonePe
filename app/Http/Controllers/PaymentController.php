<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PhonePe\PhonePePaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index($oid)
    {
        $order = DB::table('sale_order')
            ->where('sale_or_no', '=', $oid)
            ->first();

        $api = new PhonePePaymentController();
        $response = $api -> pay($order);

        dd($response);

    }

}
