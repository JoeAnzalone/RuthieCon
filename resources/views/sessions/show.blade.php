<h1>{{ $session->title }}</h1>
<div>Category: {{ $session->category }}</div>
<div>Owner: {{ $session->user->name }}</div>


@if ($session->time)
<div>Time: {{ $session->time }}</div>
@endif

@if ($session->location)
<div>Where: {{ $session->location }}</div>
@endif

@if (strtolower($session->category) === 'other')
<h2>About this session</h2>
@else
<h2>About this {{ strtolower($session->category) }}</h2>
@endif

<div>{{ $session->description }}</div>
