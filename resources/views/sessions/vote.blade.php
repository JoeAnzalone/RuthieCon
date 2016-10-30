@if (!$voted)
<form class="session-vote-form" action="{{ route('sessions.vote', $session) }}" method="post">
    {{ method_field('put') }}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit">Vote</button>
</form>
@else
<form class="session-vote-form" action="{{ route('sessions.vote', $session) }}" method="post">
    {{ method_field('delete') }}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit">Unvote</button>
</form>
@endif