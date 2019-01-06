@extends('layouts.auth')

@section('title')
    @lang('auth.forgot_password')
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            @lang('auth.email_sent')
        </div>
    @endif
    <form id="resetForm" action="{{ route('auth.password') }}" method="POST" class="mb-2">
        {!! csrf_field() !!}
        <p>
            @lang('auth.request_reset_text')
        </p>
        <div class="form-group has-feedback">
            <input type="email" name="email" class="form-control input-lg" value="{{ old('email') }}" required placeholder="@lang('strings.email')" autofocus>
        </div>
        <button type="submit" class="btn btn-block btn-primary g-recaptcha" @if(config('recaptcha.enabled')) data-sitekey="{{ config('recaptcha.website_key') }}" data-callback='onSubmit' @endif>@lang('auth.request_reset')</button>
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
