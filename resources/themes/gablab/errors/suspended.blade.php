@extends('layouts.error')

@section('title')
    @lang('base.errors.installing.header')
@endsection

@section('content')
    <h1 style="font-size: 160px !important;font-weight: 100 !important;">403</h1>
    <p>@lang('base.errors.suspended.desc')</p>
    <a href="/"><button class="btn btn-secondary">@lang('base.errors.home')</button></a>
</div>
@endsection