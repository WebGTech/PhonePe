<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PhonePe\PhonePePaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index($oid)
    {
        $order = DB::table('sale_order as so')
            ->join('stations as source', 'source.stn_id', '=', 'so.src_stn_id')
            ->join('stations as destination', 'destination.stn_id', '=', 'so.des_stn_id')
            ->where('sale_or_no', '=', $oid)
            ->select(['so.*', 'source.stn_name as source_name', 'destination.stn_name as destination_name'])
            ->first();

        $api = new PhonePePaymentController();
        $response = $api -> pay($order);

        dd($response);

    }

}
