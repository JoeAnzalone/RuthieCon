<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookController extends Controller
{

    public function login(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {
        $login_link = $fb->getLoginUrl(['user_events']);
        return redirect($login_link);
    }

    public function logout()
    {
        \Session::flush();
        return redirect(route('welcome.index'));
    }

    public function callback(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {
        try {
            $token = $fb->getAccessTokenFromRedirect();
            $fb->setDefaultAccessToken((string) $token);
            $fb_user_id = $fb->get('/me?fields=id')->getGraphUser()->getId();

            $user = \App\User::where('facebook_id', $fb_user_id)->firstOrFail();
            \Auth::login($user);

            return redirect()->action('SessionController@index');
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
