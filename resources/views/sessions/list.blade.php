<div class="session-list">
@foreach ($sessions as $session)
    <div>
        <img class="avatar" src="{{ $session->user->avatar(130) }}" alt="Photo of {{ $session->user->name }}">

        <h1 class="session-title"><a class="permalink" href="{{ route('sessions.show', $session) }}">{{ $session->title }}</a></h1>

        @can('update', $session)
            <a class="edit-link" href="{{ route('sessions.edit', $session) }}">Edit</a>
        @endcan

        <div class="session-meta">
            <div>Category: {{ $session->category }}</div>
            <div>Leader: {{ $session->user->name }}</div>

            @if ($session->time)
            <div>Time: {{ $session->time }}</div>
            @endif

        </div>

        <div>{!! nl2br(e($session->description)) !!}</div>
    </div>
@endforeach
</div>
