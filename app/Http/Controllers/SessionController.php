<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $fb = app(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk::class);
            $token = $request->session()->get('facebook_access_token');
            $user_id = $request->session()->get('facebook_user_id');

            if (!$token || !$user_id) {
                return redirect()->action('WelcomeController@index');
            }

            $fb->setDefaultAccessToken((string) $token);

            $event_id = env('FACEBOOK_EVENT_ID');

            try {
                $response_edge = $fb->get('/' . $event_id . '/attending/' . $user_id);
                $event_edge = $response_edge->getGraphEdge();
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // User does not have permission to see event
                $message = 'There was an error. Please try again later.';
                return redirect()->action('WelcomeController@index')->with('error', $message);
            }

            if (count($event_edge) !== 1) {
                $event_url = 'https://www.facebook.com/events/' . $event_id;
                $message = 'Please RSVP to <a href="'. $event_url .'">the Facebook event</a> before continuing';
                return redirect()->action('WelcomeController@index')->with('error', $message);
            }

            return $next($request);
        });
    }

    public function index()
    {
        return 'To do: Show sessions here :]';
    }
}
