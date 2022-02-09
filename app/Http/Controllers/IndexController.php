<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PhonePe\PhonePeAuthController;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index()
    {
        return Inertia::render('Index');
    }

    public function fetchAccessToken(Request $request)
    {
        $api = new PhonePeAuthController();

        $accessTokenResponse = $api->fetchAccessToken($request->input('token'));
        $accessTokenRes = json_decode($accessTokenResponse);

        if ($accessTokenRes->success) {

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
        $_user = User::where('mobile', '=', $user->phoneNumber)->first();

        Auth::login($_user);

        dd(Auth::user());

        return redirect('/products');
    }

    public function createUser($user)
    {

        User::create([
            'name' => $user->name,
            'email' => $user->primaryEmail,
            'mobile' => $user->phoneNumber,
            'lang' => 'en',
            'is_verified' => $user->isEmailVerified,
        ]);

        $this->loginUser($user);

    }

}
