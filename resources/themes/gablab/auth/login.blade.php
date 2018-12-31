@extends('layouts.auth')

@section('title')
    @lang('gablab.auth.login.heading')
@endsection

@section('content')
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        @lang('gablab.auth.auth_error')
    </div>
    @endif
    @foreach (Alert::getMessages() as $type => $messages)
        @foreach ($messages as $message)
            <div class="callout callout-{{ $type }} alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {!! $message !!}
            </div>
        @endforeach
    @endforeach
    <form id="loginForm" action="{{ route('auth.login') }}" method="POST">
        <div class="form-group has-feedback">
            <input type="text" name="user" class="form-control input-lg" value="{{ old('user') }}" required placeholder="@lang('gablab.strings.user_identifier')" autofocus>    
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control input-lg" required placeholder="@lang('gablab.strings.password')">
        </div>
        {!! csrf_field() !!}
        <button type="submit" class="btn btn-primary btn-block g-recaptcha" @if(config('recaptcha.enabled')) data-sitekey="{{ config('recaptcha.website_key') }}" data-callback='onSubmit' @endif>@lang('gablab.auth.sign_in')</button>
        <a href="{{ route('auth.password') }}" class="text-center d-block mb-2">@lang('gablab.auth.password_recovery')</a>
    </form>
@endsection

@section('scripts')
    @parent
    @if(config('recaptcha.enabled'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
        function onSubmit(token) {
            document.getElementById("loginForm").submit();
        }
        </script>
     @endif
@endsection
