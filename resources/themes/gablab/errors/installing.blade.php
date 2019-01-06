@extends('layouts.error')

@section('title')
    @lang('base.errors.installing.header')
@endsection


@section('content')
    <div class="fa-5x"><i class="fas fa-circle-notch fa-spin"></i></div>
    <p>@lang('base.errors.installing.desc')</p>
    <a href="/"><button class="btn btn-secondary">@lang('base.errors.home')</button></a>
@endsection

@section('footer-scripts')
    @parent
    <script>
        setTimeout(function() {
            location.reload();
        }, 5000);
    </script>
@endsection
