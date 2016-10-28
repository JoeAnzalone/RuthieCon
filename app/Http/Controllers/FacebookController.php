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
        } catch (\Exception $e) {
            $message = 'Sorry, you need to be invited to the Facebook event to view this page :\\';
            $message .= "<br>\n";
            $message .= 'Make sure you\'ve RSVP\'d then check back later.';
            return redirect()->route('welcome.index')->with('error', $message);
        }

        \Auth::login($user);

        $continue = \Session::get('intended') ?: route('sessions.index');
        return redirect($continue);
    }
}
