<?php

namespace App\Http\Controllers\Qr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Qr/Order', [
            'stations' => DB::table('stations')->get()
        ]);
    }

    public function create(Request $request)
    {
        $request -> validate([
            'source_id' => ['required'],
            'destination_id' => ['required'],
            'pass_id' => ['required'],
            'quantity' => ['required'],
            'fare' => ['required']
        ]);

        DB::table('orders')->insert([
            'sale_or_no' => $this -> genSaleOrderNumber($request->input('pass_id')),
            'txn_date' => now(),
            'user_id' => Auth::id(),
            'src_stn_id' => $request -> input('source_id'),
            'des_stn_id' => $request -> input('destination_id'),
            'unit' => $request -> input('quantity'),
            'sale_amt' => $request -> input('fare'),
            'media_type_id' => 2,
            'product_id' => $request->input('pass_id') === "11" ? 1 : 2,
            'pass_id' => $request->input('pass_id'),
            'app_id' => 1,
            'sale_or_status' => 1,
        ]);

        return redirect()->to('payment');

    }

    private function genSaleOrderNumber($pass_id)
    {
        return bin2hex("ATEK"."7977192875".$pass_id.time());
    }

}
