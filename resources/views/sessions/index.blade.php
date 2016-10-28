<h2>All Sessions</h2>

@if (Auth::user()->can('create', \App\Session::class))
    <a href="{{ route('sessions.create') }}">Add yours!</a>
@else
    <a href="https://www.facebook.com/events/{{ env('FACEBOOK_EVENT_ID') }}">RSVP on the event page then come back here to add yours!</a>
@endif

<ul>
@foreach ($sessions as $session)
    <li><a href="{{ route('sessions.show', $session->id) }}">{{ $session->title }}</a></li>
@endforeach
</ul>
