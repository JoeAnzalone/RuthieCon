<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookController extends Controller
{

    public function login(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {
        $login_link = $fb->getLoginUrl(['email', 'user_events']);
        return redirect($login_link);
    }

    public function callback(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {
        try {
            $token = $fb->getAccessTokenFromRedirect();
            \Session::put('facebook_access_token', (string) $token);
            return redirect('/');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // Failed to obtain access token
            dd($e->getMessage());
        }

        // $token will be null if the user denied the request
        if (!$token) {
            // User denied the request
        }
    }
}
