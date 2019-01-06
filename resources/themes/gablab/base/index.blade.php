@extends('layouts.master')

@section('title')
    @lang('navigation.account.my_servers')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">@lang('navigation.account.my_servers')</li>
        </ol>
    </nav>
@endsection

@section('content')
    @if (count($servers) > 0)
        <div class="card card-body d-none d-lg-block mb-2">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-2 text-center">@lang('strings.price')</div>
                <div class="col-2 text-center">@lang('strings.relation')</div>
                <div class="col-1 text-center">@lang('strings.memory')</div>
                <div class="col-1 text-center">@lang('strings.cpu')</div>
            </div>
        </div>
        @foreach($servers as $server)
            <div class="card card-body dynamic-update mb-2" data-server="{{ $server->uuidShort }}" data-cpumax="{{ $server->cpu }}" data-memorymax="{{ $server->memory }}">
                <div class="row">
                    <div class="col-1 py-3 text-center" data-action="status">
                        <i class="fas fa-circle-notch fa-spin"></i>
                    </div>
                    <div class="col-11 col-lg-5">
                        <h5><a href="{{ route('server.index', $server->uuidShort) }}" class="text-secondary">{{ $server->name }}</a></h5>
                        <code>{{ $server->getRelation('allocation')->alias }}:{{ $server->getRelation('allocation')->port }}</code>
                    </div>
                    <div class="col-2 py-1 d-none d-lg-block text-center">
                        @lang('currency.sym'){{ number_format($server->monthly_cost, 2) }}/@lang('strings.month')<br />
                        @lang('currency.sym'){{ number_format($server->this_month_cost, 2) }}<br />
                    </div>
                    <div class="col-2 py-3 d-none d-lg-block text-center">
                        @if($server->user->id === Auth::user()->id)
                            <span class="badge badge-primary">@lang('strings.owner')</span>
                        @elseif(Auth::user()->root_admin)
                            <span class="badge badge-secondary">@lang('strings.admin')</span>
                        @else
                            <span class="badge badge-info">@lang('strings.subuser')</span>
                        @endif
                    </div>
                    <div class="col-1 py-3 d-none d-lg-block text-center" data-action="ram">--</div>
                    <div class="col-1 py-3 d-none d-lg-block text-center" data-action="cpu">--</div>
                </div>
            </div>
        @endforeach
        @if($servers->hasPages())
            {!! $servers->appends(['query' => Request::input('query')])->render() !!}
        @endif
    @else
        <div class="text-center my-5 py-5">
            <h2>@lang('base.welcome.title')</h2>
            <p>@lang('base.welcome.description')</p>
        </div>
    @endif
@endsection

@section('scripts')
    @parent

    {!! Theme::css('css/serverlist.css?t={cache-version}') !!}
@endsection

@section('footer-scripts')
    @parent
    
    {!! Theme::js('js/frontend/serverlist.js?t={cache-version}') !!}
@endsection


