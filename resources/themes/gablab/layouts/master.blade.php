<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'GabLab') }} - @yield('title')</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="_token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/favicons/manifest.json">
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
        <link rel="shortcut icon" href="/favicons/favicon.ico">
        <meta name="msapplication-config" content="/favicons/browserconfig.xml">
        <meta name="theme-color" content="#0e4688">

        @include('layouts.scripts')

        @section('scripts')
            {!! Theme::css('vendor/sweetalert/sweetalert.min.css?t={cache-version}') !!}
            {!! Theme::css('css/app.css?t={cache-version}') !!}

            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        @show
    </head>
    <body class="with-sidebar {{ !(isset($server->name) && isset($node->name)) ?: 'with-submenu' }}">

        <div class="growdown-72" style="width: 100%; height: 72px"></div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary better-bootstrap-nav-left fixed-top">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <img src="{{ Auth::user()->getAvatarUrlAttribute(40) }}" class="user-image">
                        {{ Auth::user()->getNameAttribute() }}
                    </a>
                    <div class="dropdown-menu">
                        @if (Auth::user()->root_admin)
                            <a class="dropdown-item" href="{{ route('admin.index') }}"><i class="fas fa-cog mr-2"></i>Admin Panel</a>
                        @endif
                        <a class="dropdown-item" href="{{ route('auth.logout') }}" id="logoutButton"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="sidebar">
            <a href="#" onclick="$(this).parent().toggleClass('active'); return false;" class="sidebar-toggle">
                <span class="bar bar-top"></span>
                <span class="bar bar-mid"></span>
                <span class="bar bar-bot"></span>
            </a>
            <ul>
                <li class="{{ Route::currentRouteName() !== 'index' && !isset($server) ?: 'active' }}" data-toggle="tooltip" data-placement="right" title="My Servers">
                    <a href="{{ route('index')}}"><i class="fas fa-server"></i><span>My Servers</span></a>
                </li>
                <li class="{{ Route::currentRouteName() !== 'account' ?: 'active' }}" data-toggle="tooltip" data-placement="right" title="My Account">
                    <a href="{{ route('account') }}"><i class="fas fa-cog"></i><span>My Account</span></a>
                </li>
                <li class="{{ Route::currentRouteName() !== 'account.billing' ?: 'active' }}" data-toggle="tooltip" data-placement="right" title="Billing">
                    <a href="{{ route('account.billing') }}"><i class="fas fa-credit-card"></i><span>Billing</span></a>
                </li>
                <li class="{{ Route::currentRouteName() !== 'account.security' ?: 'active' }}" data-toggle="tooltip" data-placement="right" title="Security">
                    <a href="{{ route('account.security')}}"><i class="fas fa-key"></i><span>Security</span></a>
                </li>
                <li class="{{ (Route::currentRouteName() !== 'account.api' && Route::currentRouteName() !== 'account.api.new') ?: 'active' }}" data-toggle="tooltip" data-placement="right" title="API">
                    <a href="{{ route('account.api')}}"><i class="fas fa-network-wired"></i><span>API</span></a>
                </li>
            </ul>
        </div>

        @if (isset($server->name) && isset($node->name))
            <div class="submenu">
                <a href="#" onclick="$(this).parent().toggleClass('active'); return false;" class="submenu-toggle">{{ $server->name }}</a>
                <ul>
                    <li><a href="{{ route('server.index', $server->uuidShort) }}" class="{{ Route::currentRouteName() !== 'server.index' ?: 'active' }}"><i class="fas fa-terminal"></i>Console</a></li>
                    @can('list-files', $server)
                        <li><a href="{{ route('server.files.index', $server->uuidShort) }}" class="{{ !starts_with(Route::currentRouteName(), 'server.files') ?: 'active' }}"><i class="far fa-file"></i>File Manager</a></li>
                    @endcan
                    @can('list-subusers', $server)
                        <li><a href="{{ route('server.subusers', $server->uuidShort) }}" class="{{ !starts_with(Route::currentRouteName(), 'server.subusers') ?: 'active' }}"><i class="fas fa-users"></i>Subusers</a></li>
                    @endcan
                    @can('list-schedules', $server)
                        <li><a href="{{ route('server.schedules', $server->uuidShort) }}" class="{{ !starts_with(Route::currentRouteName(), 'server.schedules') ?: 'active' }}"><i class="far fa-clock"></i>Schedules</a></li>
                    @endcan
                    @can('view-databases', $server)
                        <li><a href="{{ route('server.databases.index', $server->uuidShort) }}" class="{{ !starts_with(Route::currentRouteName(), 'server.databases') ?: 'active' }}"><i class="fas fa-database"></i>Databases</a></li>
                    @endcan
                    @if (Auth::user()->root_admin || Auth::user()->id == $server->owner_id)
                        <li><a href="{{ route('server.settings.delete', $server->uuidShort) }}" class="delete {{ !starts_with(Route::currentRouteName(), 'server.settings.delete') ?: 'active' }}"><i class="far fa-trash-alt"></i>Delete Server</a></li>
                    @endif
                </ul>
            </div>
        @endif

        <div class="container pb-5">
            @yield('content-header')
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    @lang('base.validation_error')<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @foreach (Alert::getMessages() as $type => $messages)
                @foreach ($messages as $message)
                    <div class="alert alert-{{ $type }} alert-dismissable" role="alert">
                        {!! $message !!}
                    </div>
                @endforeach
            @endforeach
            @yield('content')
            <div class="py-4">
                @include('partials.copyright')
            </div>
        </div>

        <div class="deploy-section">
            @section('deploy')  
                <a href="{{ route('deploy') }}" class="btn btn-primary btn-deploy" data-toggle="tooltip" title="Deploy new server" data-placement="left"><i class="fas fa-plus"></i></a>
            @show    
        </div> 

        @section('footer-scripts')
            {!! Theme::js('js/laroute.js?t={cache-version}') !!}
            {!! Theme::js('vendor/jquery/jquery.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/sweetalert/sweetalert.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/socketio/socket.io.v203.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js?t={cache-version}') !!}

            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
            
            <script type="application/javascript">
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                    $('#logoutButton').on('click', function (event) {
                        event.preventDefault();

                        var that = this;
                        swal({
                            title: "@lang('gablab.strings.logout.details')",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d9534f',
                            cancelButtonColor: '#d33',
                            confirmButtonText: "@lang('gablab.strings.logout.submit')"
                        }, function () {
                            window.location = $(that).attr('href');
                        });
                    });
                });
            </script>
        @show
    </body>
</html>
