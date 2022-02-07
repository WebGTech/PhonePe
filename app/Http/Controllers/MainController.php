<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PhonePe\PhonePeApiController;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MainController extends Controller
{
    public function index()
    {
        return Inertia::render('Index');
    }

    public function login(Request $request)
    {
        $api = new PhonePeApiController();

        $accessTokenResponse = $api -> fetchAccessToken($request->input('token'));
        $accessTokenRes = json_decode($accessTokenResponse);

        if ($accessTokenResponse -> success) {

        }

    }

}
