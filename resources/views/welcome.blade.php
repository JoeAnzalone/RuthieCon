<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>RuthieCon Session Scheduler</title>
    </head>
    <body>
        <div class="page">

            @if ($error)
                <div class="alert alert-error">
                {!! $error !!}
                </div>
            @endif

            <h1>Welcome!</h1>
            <p>
                <a href="/login">Login with Facebook to continue</a>
            </p>
        </div>
    </body>
</html>
