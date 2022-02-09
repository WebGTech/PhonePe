<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function index()
    {
        return Inertia::render('Ticket/Order', [
            'stations' => DB::table('stations')->get(['stn_id', 'stn_name'])
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

        $saleOrderNumber = $this -> genSaleOrderNumber($request->input('pass_id'));

        DB::table('sale_order')->insert([
            'sale_or_no' => $saleOrderNumber,
            'txn_date' => now(),
            'user_id' => Auth::id(),
            'src_stn_id' => $request -> input('source_id'),
            'des_stn_id' => $request -> input('destination_id'),
            'unit' => $request -> input('quantity'),
            'sale_amt' => $request -> input('fare'),
            'media_type_id' => 2,
            'product_id' => $request->input('pass_id') === "11" ? 1 : 2,
            'pass_id' => $request->input('pass_id'),
            'app_id' => env('APP_ID'),
            'sale_or_status' => env('ISSUE'),
        ]);

        return redirect()->to('/pay/'.$saleOrderNumber);

    }

    public function view()
    {
        return Inertia::render('Ticket/View');
    }

    private function genSaleOrderNumber($pass_id)
    {
        return "ATEK".$pass_id.Auth::user()->mobile.strtoupper(dechex(time()));
    }

}
