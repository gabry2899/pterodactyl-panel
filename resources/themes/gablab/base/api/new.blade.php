
@extends('layouts.master')

@section('title')
    Create Api Key
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('account.api') }}">Api Access</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card card-body">
        <h3>New Api Token</h3>
        <form method="POST" action="{{ route('account.api.new') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="control-label" for="memoField">Description <span class="field-required"></span></label>
                <input id="memoField" type="text" name="memo" class="form-control" value="{{ old('memo') }}">
            </div>
            <p class="text-muted">Set an easy to understand description for this API key to help you identify it later on.</p>
            <div class="form-group">
                <label class="control-label" for="allowedIps">Allowed Connection IPs <span class="field-optional"></span></label>
                <textarea id="allowedIps" name="allowed_ips" class="form-control" rows="5">{{ old('allowed_ips') }}</textarea>
            </div>
            <p class="text-muted">If you would like to limit this API key to specific IP addresses enter them above, one per line. CIDR notation is allowed for each IP address. Leave blank to allow any IP address.</p>
            <div class="text-right">
                <button type="submit" class="btn btn-outline-primary">Create</button>
            </div>
        </form>
    </div>
@endsection
