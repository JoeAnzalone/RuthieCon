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
                <div class="site-branding">
                    <h1 class="site-title"><a href="{{ route('sessions.index') }}">Monster Mash 2k16</a></h1>
                    <div class="site-description">(Ruthie's Birthday Unconference)</div>
                </div>
                @if (!empty($nav))
                <nav class="main-navigation">
                    <ul>
                    @foreach ($nav as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                    </ul>
                </nav>
                @endif
            </header>

            @if (!empty($error))
                <div class="alert alert-error">
                {!! $error !!}
                </div>
            @endif

            <div class="site-content">
                {!! $content !!}
            </div>
        </div>
        @if (View::exists('analytics'))
            @include('analytics')
        @endif
    </body>
</html>
