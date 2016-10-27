<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Session;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = Session::all();

        $view_variables = [
            'sessions' => $sessions,
        ];

        return $this->setPageContent(view('sessions.index', $view_variables));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
