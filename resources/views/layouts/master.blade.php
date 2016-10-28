<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Monster Mash 2k16 :: Session Scheduler</title>
        <link rel="stylesheet" href="/css/main.css">
    </head>
    <body>
        <div class="page">
            <header class="site-header">
                <h1>Monster Mash 2k16</h1>
                <div class="site-description">(Ruthie's Birthday Unconference)</div>

                <nav class="main-navigation">
                    <ul>
                    @foreach ($nav as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                    </ul>
                </nav>
            </header>

            @if ($error)
                <div class="alert alert-error">
                {!! $error !!}
                </div>
            @endif

            {!! $content !!}
        </div>
    </body>
</html>
