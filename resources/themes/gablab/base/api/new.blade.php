
@extends('layouts.master')

@section('title')
    @lang('navigation.account.api_access_new')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('account.api') }}">@lang('navigation.account.api_access')</a></li>
            <li class="breadcrumb-item active">@lang('navigation.account.api_access_new')</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card card-body">
        <h3>@lang('base.api.new.title')</h3>
        <form method="POST" action="{{ route('account.api.new') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="control-label" for="memoField">@lang('strings.memo') <span class="field-required"></span></label>
                <input id="memoField" type="text" name="memo" class="form-control" value="{{ old('memo') }}">
            </div>
            <p class="text-muted">@lang('base.api.new.description_hint')</p>
            <div class="form-group">
                <label class="control-label" for="allowedIps">@lang('strings.allowed_ips') <span class="field-optional"></span></label>
                <textarea id="allowedIps" name="allowed_ips" class="form-control" rows="5">{{ old('allowed_ips') }}</textarea>
            </div>
            <p class="text-muted">@lang('base.api.new.ips_hint')</p>
            <div class="text-right">
                <button type="submit" class="btn btn-outline-primary">@lang('strings.create')</button>
            </div>
        </form>
    </div>
@endsection
