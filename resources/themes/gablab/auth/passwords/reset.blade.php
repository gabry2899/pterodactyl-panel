@extends('layouts.auth')

@section('title')
    @lang('gablab.auth.passwords.reset.heading')
@endsection

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            @lang('gablab.auth.passwords.reset.auth_error')<br>
            @foreach ($errors->all() as $error)
                {{ $error }}<br />
            @endforeach
        </div>
    @endif
    <form id="resetForm" action="{{ route('auth.reset.post') }}" method="POST" class="mb-2">
        <div class="form-group has-feedback">
            <input type="email" name="email" class="form-control input-lg" value="{{ $email ?? old('email') }}" required autofocus placeholder="@lang('gablab.strings.email')">
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control input-lg" id="password" required placeholder="@lang('strings.password')">
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password_confirmation" class="form-control input-lg" id="password_confirmation" required placeholder="@lang('strings.confirm_password')">
        </div>
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}" />
        <button type="submit" class="btn btn-block g-recaptcha btn-primary" @if(config('recaptcha.enabled')) data-sitekey="{{ config('recaptcha.website_key') }}" data-callback='onSubmit' @endif>@lang('gablab.auth.passwords.reset.reset_password')</button>
    </form>
@endsection

@section('scripts')
    @parent
    @if(config('recaptcha.enabled'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
        function onSubmit(token) {
            document.getElementById("resetForm").submit();
        }
        </script>
     @endif
@endsection
