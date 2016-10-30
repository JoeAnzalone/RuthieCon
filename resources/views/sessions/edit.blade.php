<form class="session-form" action="{{ $form['action'] }}" method="post">
    {{ method_field($form['method']) }}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <input name="session[title]" type="text" placeholder="Title" value="{{ $session->title }}" required>

    <label class="input-wrapper">
        <span class="label-text">Category:</span>
        <select name="session[category_id]">
            <option {{ $session->category_id === 1 ? 'selected' : ''}} value="1">Talk</option>
            <option {{ $session->category_id === 2 ? 'selected' : ''}} value="2">Workshop</option>
            <option {{ $session->category_id === 3 ? 'selected' : ''}} value="3">Activity</option>
            <option {{ $session->category_id === 4 ? 'selected' : ''}} value="4">Performance</option>
            <option {{ $session->category_id === 0 ? 'selected' : ''}} value="0">Other</option>
        </select>
    </label>

    <label class="input-wrapper">
        <span class="label-text">Location:</span>
        <input name="session[location]" type="text" placeholder="Location" value="{{ $session->location }}">
    </label>

    @can('set-time', \App\Session::class)
        <label class="input-wrapper">
            <span class="label-text">Time:</span>
            <input name="session[time]" type="time" placeholder="Time" value="{{ $session->time }}">
        </label>
    @endcan

    @can('override-owner', \App\Session::class)
    <label class="input-wrapper">
            <span class="label-text">Owner:</span>
            <select name="session[user_id]">
            @foreach ($attendees as $user)
                <option {{ $session->user_id === $user->id ? 'selected' : ''}} value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
            </select>
    </label>
    @endcan

    <textarea name="session[description]" placeholder="Description" required>{{ $session->description }}</textarea>

    @if ($session->id)
        @can('delete', $session)
            <a class="delete-link" href="{{ route('sessions.delete', $session) }}">Delete</a>
        @endcan
    @endif

    <button class="save-button" type="submit">Save</button>
</form>
