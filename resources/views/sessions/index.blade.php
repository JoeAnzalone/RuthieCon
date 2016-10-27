<ul>
@foreach ($sessions as $session)
    <li><a href="{{ route('sessions.show', $session->id) }}">{{ $session->title }}</a></li>
@endforeach
</ul>
