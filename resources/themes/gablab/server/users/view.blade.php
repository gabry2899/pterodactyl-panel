@extends('layouts.master')

@section('title')
    @lang('navigation.server.new_user')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('navigation.account.my_servers')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.subusers', $server->uuidShort) }}">@lang('navigation.server.subusers')</a></li>
            <li class="breadcrumb-item active">{{ $subuser->user->email }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card card-body">
        <form action="{{ route('server.subusers.view', [ 'uuid' => $server->uuidShort, 'subuser' => $subuser->hashid ]) }}" method="POST">    
            <div class="form-group">
                <label class="control-label">@lang('server.users.new.email')</label>
                <div>
                    <input type="email" class="form-control" disabled value="{{ $subuser->user->email }}" />
                    {!! csrf_field() !!}
                </div>
            </div>
            <div class="row">
                @foreach($permlist as $block => $perms)
                <div class="col-12 col-lg-6">
                    <h3 class="box-title">@lang('server.users.new.' . $block . '_header')</h3>
                    @foreach($perms as $permission => $daemon)
                        <div class="form-group">
                            <div class="checkbox checkbox-primary no-margin-bottom">
                                <input id="{{ $permission }}" name="permissions[]" type="checkbox" @if(isset($permissions[$permission]))checked="checked"@endif @cannot('edit-subuser', $server)disabled="disabled"@endcannot value="{{ $permission }}"/>
                                <label for="{{ $permission }}" class="strong">
                                    @lang('server.users.new.' . str_replace('-', '_', $permission) . '.title')
                                </label>
                            </div>
                            <p class="text-muted small">@lang('server.users.new.' . str_replace('-', '_', $permission) . '.description')</p>
                        </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @can('edit-subuser', $server)
                <div class="text-right">
                    <div class="btn-group">
                        <a id="selectAllCheckboxes" class="btn btn-info">@lang('strings.select_all')</a>
                        <a id="unselectAllCheckboxes" class="btn btn-info">@lang('strings.select_none')</a>
                    </div>
                    {!! method_field('PATCH') !!}
                    <input type="submit" name="submit" value="@lang('server.users.update')" class="btn btn-primary" />
                </div>
            @endcan
        </form>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectAllCheckboxes').on('click', function () {
                $('input[type=checkbox]').prop('checked', true);
            });
            $('#unselectAllCheckboxes').on('click', function () {
                $('input[type=checkbox]').prop('checked', false);
            });
        })
    </script>
@endsection
