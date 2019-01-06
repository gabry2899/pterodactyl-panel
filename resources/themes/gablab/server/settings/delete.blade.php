@extends('layouts.master')

@section('title')
    @lang('server.config.delete.header')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Servers</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">Delete</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card card-body">
        <form action="{{ route('server.settings.delete.submit', $server->uuidShort) }}" method="POST">
            <p>@lang('server.config.delete.details')</p>
            <div class="box-footer text-right">
                {{ csrf_field() }}
                <input type="submit" class="btn btn- btn-outline-danger" value="@lang('strings.submit')" />
            </div>
        </form>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
@endsection
