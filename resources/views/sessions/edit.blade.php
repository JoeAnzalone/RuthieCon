<form action="{{ $form['action'] }}" method="post">
    {{ method_field($form['method']) }}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <input name="session[title]" type="text" placeholder="Title" value="{{ $session['title'] or '' }}">
    <select name="session[category_id]">
        <option {{ $session['category_id'] === 1 ? 'selected' : ''}} value="1">Talk</option>
        <option {{ $session['category_id'] === 2 ? 'selected' : ''}} value="2">Workshop</option>
        <option {{ $session['category_id'] === 3 ? 'selected' : ''}} value="3">Activity</option>
        <option {{ $session['category_id'] === 4 ? 'selected' : ''}} value="4">Performance</option>
        <option {{ $session['category_id'] === 0 ? 'selected' : ''}} value="0">Other</option>
    </select>
    <input name="session[location]" type="text" placeholder="Location" value="{{ $session['location'] or '' }}">
    <input name="session[time]" type="time" placeholder="Time" value="{{ $session['time'] or '' }}">
    <textarea name="session[description]" placeholder="Description">{{ $session['description'] or '' }}</textarea>

    <button type="submit">Save</button>
</form>
