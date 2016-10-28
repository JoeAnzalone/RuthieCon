<h2>Sessions I'm Leading</h2>

@if (count($sessions['mine']))

    @include('sessions.list', ['sessions' => $sessions['mine']])

    @if (Auth::user()->can('create', \App\Session::class))
        <a href="{{ route('sessions.create') }}">Add another</a>
    @else
        <a href="https://www.facebook.com/events/{{ env('FACEBOOK_EVENT_ID') }}">RSVP on the event page then come back here to add yours!</a>
    @endif
@else
    <div class="inset">
        <p>You don't have any sessions listed! :(</p>
        <p>Why not <a href="{{ route('sessions.create') }}">add one</a>? :)</p>
    </div>
@endif

@if (count($sessions['not-mine']))
    <h2>Other Great Sessions</h2>

    @include('sessions.list', ['sessions' => $sessions['not-mine']])
@endif