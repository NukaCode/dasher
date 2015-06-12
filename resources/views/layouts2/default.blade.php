<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @section('css')
            {{--{{ HTML::style('css/all.css') }}--}}
        @show
    </head>
    <body>
        @if (isset($content))
            {{ $content }}
        @else
            @yield('content')
        @endif

        @section('js')
            {{ HTML::script('js/all.js') }}
        @show

    </body>
</html>