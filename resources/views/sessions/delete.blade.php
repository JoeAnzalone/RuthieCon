<form class="session-form" action="{{ $form['action'] }}" method="post">
    {{ method_field($form['method']) }}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <h1>Are you sure you want to delete <a class="permalink" href="{{ route('sessions.show', $session) }}">{{ $session->title }}</a>? :(</h1>

    <p><a class="permalink" href="{{ route('sessions.show', $session) }}">Wait no, go back!</a></p>
    <button class="delete-button" type="submit">Yes, Delete</button>
</form>
