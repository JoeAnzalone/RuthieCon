<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>RuthieCon Session Scheduler</title>
    </head>
    <body>
        <div class="page">

            @if ($error)
                <div class="alert alert-error">
                {!! $error !!}
                </div>
            @endif

            {!! $content !!}
        </div>
    </body>
</html>
