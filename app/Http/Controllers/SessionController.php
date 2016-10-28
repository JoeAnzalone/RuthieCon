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
            if (!\Auth::user()) {
                // Don't show the error before the user has tried logging in
                \Session::set('intended', $request->url());
                return redirect()->route('welcome.index');
            }

            // TODO: Move this to a Gate
            // https://laravel.com/docs/5.3/authorization#gates
            try {
                $this->authorize('index', Session::class);
            } catch (\Exception $e) {
                // User has not RSVP'd the way we wanted them to
                $event_id = env('FACEBOOK_EVENT_ID');
                $event_url = 'https://www.facebook.com/events/' . $event_id;
                $message = 'Please RSVP to <a href="'. $event_url .'">the Facebook event</a> before continuing';

                \Session::set('intended', $request->url());
                return redirect()->route('welcome.index')->with('error', $message);
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
        $sessions = [
            'mine' => Session::where('user_id', '=', \Auth::user()->id)->get(),
            'not-mine' => Session::where('user_id', '!=', \Auth::user()->id)->get(),
        ];

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
        $this->authorize('create', Session::class);

        $attendees = [];

        if (\Auth::user()->can('override-owner', Session::class)) {
            $attendees = User::where(['rsvp_status_id' => 1])->get();
        }

        $view_variables = [
            'session' => new Session(['user_id' => \Auth::user()->id, 'category_id' => 1]),
            'attendees' => $attendees,
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

        if (!\Auth::user()->can('override-owner', Session::class)) {
            $session_attributes['user_id'] = \Auth::user()->id;
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

        $this->authorize('update', $session);

        $attendees = [];

        if (\Auth::user()->can('override-owner', Session::class)) {
            $attendees = User::where(['rsvp_status_id' => 1])->get();
        }

        $view_variables = [
            'session' => $session,
            'attendees' => $attendees,
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
        $session = Session::findOrFail($id);
        $this->authorize('update', $session);

        $session_attributes = $request->input('session');

        if (!\Auth::user()->can('override-owner', Session::class)) {
            unset($session_attributes['user_id']);
        }

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
