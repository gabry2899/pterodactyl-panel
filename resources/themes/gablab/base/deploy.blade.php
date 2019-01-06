@extends('layouts.master')

@section('title')
    Deploy Server
@endsection

@section('deploy')
@endsection

@section('scripts')
    @parent

    {!! Theme::css('css/deploy.css?t={cache-version}') !!}
@endsection

@php
    $disk_sizes = [2, 5, 10, 15, 20, 25, 50, 100, 150, 250, 500];
    $ram_sizes = [1/4, 1/2, 1, 2, 4, 6, 8, 10, 12, 14, 16];
    $egg_id = app('request')->get('egg');
    if (!is_null($egg_id)) {
        $egg = \Pterodactyl\Models\Egg::find($egg_id);
        $disk_sizes = array_filter($disk_sizes, function($item) use ($egg) {
            return $item <= $egg->nest->max_disk;
        });
        $ram_sizes = array_filter($ram_sizes, function($item) use ($egg) {
            return $item <= $egg->nest->max_memory;
        });
    }
@endphp

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Servers</a></li>
            <li class="breadcrumb-item active">Deploy</li>
        </ol>
    </nav>
@endsection

@section('content')
    @if (is_null($egg_id))
        <h3>Deploy a Server</h3>
        <div class="row game-group" data-input-name="nest">
            @foreach($nests as $nest)
                @foreach($nest->eggs as $egg)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
                        <div class="card card-body mb-3 text-center game-card" data-id="{{ $egg->id }}">
                        <img src="{{ asset("themes/gablab/imgs/games/$egg->id.png") }}"> 
                        <span class="font-weight-bold">{{ $egg->name }}</span>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @else
        <div class="card card-body">
            <h3>Deploy {{ $egg->name }}</h3>
            <form method="POST" action="{{ route('deploy.submit') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="egg" value="{{ $egg->id }}">
                <input type="hidden" name="nest" value="{{ $egg->nest->id }}">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label">Server Name</label>
                            <div>
                                <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="control-label">Memory</label>
                            <div>
                                <select name="ram" class="form-control" data-cost="{{ $egg->nest->memory_monthly_cost }}">
                                    @foreach ($ram_sizes as $size)
                                        <option value="{{ $size*1024 }}" {{ old('ram') == $size*1024 ? 'selected' : '' }}>{{ $size < 1 ? ($size*1024 . " MB") : "$size GB" }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="control-label">Disk</label>
                            <div>
                                <select name="disk" class="form-control" data-cost="{{ $egg->nest->disk_monthly_cost }}">
                                    @foreach ($disk_sizes as $size)
                                        <option value="{{ $size }}" {{ old('disk') == $size ? 'selected' : '' }}>{{ $size }} GB</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @foreach ($egg->variables()->where('user_editable', 1)->get() as $var)
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="control-label">{{ $var->name }}</label>
                                <div>
                                    <input type="text" name="v{{$egg->nest->id}}-{{$egg->id}}-{{$var->env_variable}}" value="{{ old('v'.$egg->nest->id.'-'.$egg->id.'-'.$var->env_variable, $var->default_value) }}" class="form-control">
                                    @if ($var->description)
                                        <p class="text-muted small no-margin">{{ $var->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex">
                    <div class="mr-auto py-2">
                        <a href="{{ route('deploy') }}">Change Game</a>
                    </div>
                    <div class="d-flex">
                        <span id="price" class="mr-2 py-2 d-block">$0.00/month</span>
                        <input type="submit" class="btn btn-outline-primary" value="Deploy" />
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection

@section('footer-scripts')
    @parent
    
    {!! Theme::js('js/deploy.js?t={cache-version}') !!}
@endsection
