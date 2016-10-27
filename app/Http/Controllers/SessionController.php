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
                return redirect()->route('welcome.index');
            }

            $fb->setDefaultAccessToken((string) $token);

            try {
                $this->user = User::where('facebook_id', $fb_user_id)->firstOrFail();
            } catch (\Exception $e) {
                // Facebook user has not been imported into Users table
                $message = 'There was an error. Please try again later.';
                return redirect()->route('welcome.index')->with('error', $message);
            }

            if ($redirect = $this->enforceGuestlist()) {
                return $redirect;
            }

            return $next($request);
        });

    }

    public function enforceGuestlist($allowed_responses = [])
    {
        if (gettype($allowed_responses) === 'string') {
            // If you just send along a single allowed_response,
            // don't require it to be in an array
            $allowed_responses = [$allowed_responses];
        }

        if (!$allowed_responses && !empty($this->user)) {
            // If $allowed_responses is left blank,
            // simply require that the user exists at all
            return false;
        }

        if (!in_array($this->user->rsvp_status, $allowed_responses)) {
            // User has not RSVP'd the way we wanted them to
            $event_id = env('FACEBOOK_EVENT_ID');
            $event_url = 'https://www.facebook.com/events/' . $event_id;
            $message = 'Please RSVP to <a href="'. $event_url .'">the Facebook event</a> before continuing';
            return redirect()->route('welcome.index')->with('error', $message);
        }

        return false;
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
        if ($redirect = $this->enforceGuestlist('attending')) {
            return $redirect;
        }

        $attendees = [];
        $fields_to_show = [];

        if ($this->user->isAdmin()) {
            $attendees = User::where(['rsvp_status_id' => 1])->get();

            $fields_to_show = [
                'owner',
                'time',
            ];
        }

        $view_variables = [
            'session' => new Session(['user_id' => $this->user->id, 'category_id' => 1]),
            'attendees' => $attendees,
            'fields_to_show' => $fields_to_show,
            'form' => ['action' => route('sessions.store'), 'method' => 'post']
        ];

        return $this->setPageContent(view('sessions.edit', $view_variables));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $session_attributes = $request->input('session');

        if (!$this->user->isAdmin()) {
            $session_attributes['user_id'] = $this->user->id;
        }

        $session = new Session($session_attributes);
        $session->save();
        return redirect()->route('sessions.show', $session->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $session = Session::findOrFail($id);

        $view_variables = [
            'session' => $session,
        ];

        return $this->setPageContent(view('sessions.show', $view_variables));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $session = Session::findOrFail($id);

        $attendees = [];
        $fields_to_show = [];

        if ($this->user->isAdmin()) {
            $attendees = User::where(['rsvp_status_id' => 1])->get();

            $fields_to_show = [
                'owner',
                'time',
            ];
        }

        $view_variables = [
            'session' => $session,
            'attendees' => $attendees,
            'fields_to_show' => $fields_to_show,
            'form' => ['action' => route('sessions.update', $id), 'method' => 'put']
        ];

        return $this->setPageContent(view('sessions.edit', $view_variables));
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
        $session_attributes = $request->input('session');

        if (!$this->user->isAdmin()) {
            unset($session_attributes['user_id']);
        }

        $session = Session::findOrFail($id);
        $session->fill($session_attributes);
        $session->save();
        return redirect()->route('sessions.show', $session->id);
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
