<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'GabLab') }} - @yield('title')</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/favicons/manifest.json">
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
        <link rel="shortcut icon" href="/favicons/favicon.ico">
        <meta name="msapplication-config" content="/favicons/browserconfig.xml">
        <meta name="theme-color" content="#0e4688">

        @section('scripts')
            {!! Theme::css('css/app.css?t={cache-version}') !!}

            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        @show
    </head>
    <body class="login-page">
        <div class="row mx-0">
            <div class="d-none d-sm-block col-sm-6 marketing-panel">
                <div class="inner-panel">
                    <h1>@lang('auth.marketing.title')</h1>
                    <p>
                        @lang('auth.marketing.subtitle')
                    </p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 login-panel">
                <div class="inner-panel">
                    <span class="logo"></span>
                    @yield('content')
                    @include('partials.copyright')
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    </body>
</html>
