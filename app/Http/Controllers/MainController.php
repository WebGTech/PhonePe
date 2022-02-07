<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PhonePe\PhonePeApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
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

        if ($accessTokenRes -> success) {

            $userDetails = $api->getUserDetails($accessTokenRes->data->accessToken);
            $userDetailsRes = json_decode($userDetails);

            if ($userDetailsRes->success) {

                $this->authenticateUser($userDetailsRes->data);

            } else {
                dd($userDetails);
            }

        } else {
            dd($accessTokenResponse);
        }

    }

    private function authenticateUser($user)
    {

        $oldUser = DB::table('users')
            ->where('mobile', '=', $user->phoneNumber)
            ->first();

        if ($oldUser != null) {
            $this->loginUser($user);
        } else {
            $this->createUser($user);
        }
    }

    public function loginUser($user)
    {
        $_user = User::where('mobile', '=', $user -> phoneNumber)->first();

        Auth::login($_user);

        return Redirect::route('qr/dashboard');
    }

    public function createUser($user)
    {

        User::create([
            'name' => $user -> name,
            'email' => $user -> primaryEmail,
            'mobile' => $user -> phoneNumber,
            'lang' => 'en',
            'is_verified' => $user -> isEmailVerified,
        ]);

        $this->loginUser($user);

    }

}
