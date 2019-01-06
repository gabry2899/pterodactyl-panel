@extends('layouts.error')

@section('title')
    @lang('base.errors.404.header')
@endsection

@section('content-header')
@endsection

@section('content')
    <h1 style="font-size: 160px !important;font-weight: 100 !important;">404</h1>
    <p>@lang('base.errors.404.desc')</p>
    <a href="/" class="btn btn-secondary">@lang('base.errors.home')</a>
@endsection
