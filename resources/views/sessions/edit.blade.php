<form action="{{ $form['action'] }}" method="post">
    {{ method_field($form['method']) }}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <input type="text" placeholder="Title" value="{{ $session['title'] or '' }}">
    <input type="text" placeholder="Location" value="{{ $session['location'] or '' }}">
    <input type="time" placeholder="Time" value="{{ $session['time'] or '' }}">
    <textarea placeholder="Description">{{ $session['description'] or '' }}</textarea>

    <button type="submit">Save</button>
</form>
