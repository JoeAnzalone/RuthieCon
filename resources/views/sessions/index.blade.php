<h2>Sessions I'm Leading</h2>

@if (count($sessions['mine']))
    <ul>
    @foreach ($sessions['mine'] as $session)
        <li><a href="{{ route('sessions.show', $session->id) }}">{{ $session->title }}</a></li>
    @endforeach
    </ul>

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


<h2>Other Great Sessions</h2>

<ul>
@foreach ($sessions['not-mine'] as $session)
    <li><a href="{{ route('sessions.show', $session->id) }}">{{ $session->title }}</a></li>
@endforeach
</ul>
