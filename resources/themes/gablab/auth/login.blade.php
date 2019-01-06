@extends('layouts.auth')

@section('title')
    @lang('auth.sign_in')
@endsection

@section('content')
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        @lang('auth.auth_error')
    </div>
    @endif
    @foreach (Alert::getMessages() as $type => $messages)
        @foreach ($messages as $message)
            <div class="alert alert-{{ $type }} alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {!! $message !!}
            </div>
        @endforeach
    @endforeach
    <form id="loginForm" action="{{ route('auth.login') }}" method="POST">
        <div class="form-group has-feedback">
            <input type="text" name="user" class="form-control input-lg" value="{{ old('user') }}" required placeholder="@lang('strings.user_identifier')" autofocus>    
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control input-lg" required placeholder="@lang('strings.password')">
        </div>
        {!! csrf_field() !!}
        <button type="submit" class="btn btn-primary btn-block g-recaptcha" @if(config('recaptcha.enabled')) data-sitekey="{{ config('recaptcha.website_key') }}" data-callback='onSubmit' @endif>@lang('auth.sign_in')</button>
        <a href="{{ route('auth.password') }}" class="text-center d-block mb-2">@lang('auth.forgot_password')</a>
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
