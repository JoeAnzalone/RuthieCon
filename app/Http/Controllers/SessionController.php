<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $fb = app(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk::class);
            $token = $request->session()->get('facebook_access_token');
            $fb_user_id = $request->session()->get('facebook_user_id');

            if (!$token || !$fb_user_id) {
                return redirect()->action('WelcomeController@index');
            }

            $fb->setDefaultAccessToken((string) $token);

            try {
                $user = User::where('facebook_id', $fb_user_id)->firstOrFail();
            } catch (\Exception $e) {
                // Facebook user has not been imported into Users table
                $message = 'There was an error. Please try again later.';
                return redirect()->action('WelcomeController@index')->with('error', $message);
            }

            if (!$user->canAccessApp()) {
                // User has not RSVP'd
                $event_id = env('FACEBOOK_EVENT_ID');
                $event_url = 'https://www.facebook.com/events/' . $event_id;
                $message = 'Please RSVP to <a href="'. $event_url .'">the Facebook event</a> before continuing';
                return redirect()->action('WelcomeController@index')->with('error', $message);
            }

            return $next($request);
        });
    }

    public function index()
    {
        $view_variables = [
            'wow' => 'ok',
            'sessions' => [
                ['title' => 'How to make balloon animals'],
                ['title' => 'How To Be The Beyoncé of SEO (+ Long-Tail Feminism)'],
                ['title' => 'Collaborative modular origami workshop'],
                ['title' => 'Key development challenges and sustainable development goals'],
                ['title' => 'Live edition of The Essence of Camp podcast'],
                ['title' => 'Performance of original songs'],
                ['title' => 'Movement workshop'],
                ['title' => 'A primer on meditation techniques'],
                ['title' => 'What you should know about the research of the Nobel prize winner in physics'],
                ['title' => 'Science fair'],
            ]
        ];

        return $this->setPageContent(view('sessions.index', $view_variables));
    }
}
