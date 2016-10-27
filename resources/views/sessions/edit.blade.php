<form action="{{ $form['action'] }}" method="post">
    {{ method_field($form['method']) }}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <input name="session[title]" type="text" placeholder="Title" value="{{ $session['title'] or '' }}">
    <input name="session[location]" type="text" placeholder="Location" value="{{ $session['location'] or '' }}">
    <input name="session[time]" type="time" placeholder="Time" value="{{ $session['time'] or '' }}">
    <textarea name="session[description]" placeholder="Description">{{ $session['description'] or '' }}</textarea>

    <button type="submit">Save</button>
</form>
