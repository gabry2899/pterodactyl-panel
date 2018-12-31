<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'Pterodactyl') }} - Console &rarr; {{ $server->name }}</title>
        @include('layouts.scripts')
        {!! Theme::css('vendor/jquery/jquery.terminal.min.css?t={cache-version}') !!}
        {!! Theme::css('css/app.css?t={cache-version}') !!}
        <style>
            #terminal-body {
                margin: 0;}
            #terminal {
                width: 100%;
                height: 100vh !important;}
            #commands {
                position: fixed;
                top: 16px;
                right: 16px;}
        </style>
    </head>
    <body id="terminal-body">
        <div id="terminal"></div>
        <div class="btn-group" id="commands">
            @can('power-start', $server)<button type="button" class="btn btn-secondary disabled" data-attr="power" data-action="start">Start</button>@endcan
            @can('power-stop', $server)<button type="button" class="btn btn-secondary disabled" data-attr="power" data-action="stop">Stop</button>@endcan
            @can('power-kill', $server)<button type="button" class="btn btn-secondary disabled" data-attr="power" data-action="kill">Kill</button>@endcan
        </div>
        <script>window.fullScreen = true</script>
        {!! Theme::js('js/laroute.js?t={cache-version}') !!}
        {!! Theme::js('vendor/jquery/jquery.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/jquery/jquery.terminal.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/ansi/ansi_up.js?t={cache-version}') !!}
        {!! Theme::js('vendor/socketio/socket.io.v203.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js?t={cache-version}') !!}
        {!! Theme::js('js/frontend/server.socket.js?t={cache-version}') !!}
        {!! Theme::js('js/frontend/console.js?t={cache-version}') !!}
    </body>
</html>
