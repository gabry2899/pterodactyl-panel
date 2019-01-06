@extends('layouts.master')

@section('title')
    @lang('navigation.server.subusers_new')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('navigation.account.my_servers')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.subusers', $server->uuidShort) }}">@lang('navigation.server.subusers')</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.new_user')</li>
        </ol>
    </nav>
@endsection

@section('content')
    <?php $oldInput = array_flip(is_array(old('permissions')) ? old('permissions') : []) ?>
    <div class="card card-body">
        <form action="{{ route('server.subusers.new', $server->uuidShort) }}" method="POST">
            <div class="form-group">
                <label class="control-label">@lang('server.users.new.email')</label>
                <div>
                    {!! csrf_field() !!}
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" />
                    <p class="text-muted small">@lang('server.users.new.email_help')</p>
                </div>
            </div>
            <div class="row">
                @foreach($permissions as $block => $perms)
                <div class="col-12 col-lg-6">
                    <h3 class="box-title">@lang('server.users.new.' . $block . '_header')</h3>
                    @foreach($perms as $permission => $daemon)
                        @if (!in_array($permission, ['compress-files', 'decompress-files']))
                            <div class="form-group">
                                <div class="checkbox checkbox-primary no-margin-bottom">
                                    <input id="{{ $permission }}" name="permissions[]" type="checkbox" value="{{ $permission }}"/>
                                    <label for="{{ $permission }}" class="strong">
                                        @lang('server.users.new.' . str_replace('-', '_', $permission) . '.title')
                                    </label>
                                </div>
                                <p class="text-muted small">@lang('server.users.new.' . str_replace('-', '_', $permission) . '.description')</p>
                            </div>
                        @endif
                    @endforeach
                </div>
                @endforeach
            </div>
            <div class="text-right">
                <div class="btn-group">
                    <a id="selectAllCheckboxes" class="btn btn-info">@lang('strings.select_all')</a>
                    <a id="unselectAllCheckboxes" class="btn btn-info">@lang('strings.select_none')</a>
                </div>
                <input type="submit" name="submit" value="@lang('server.users.add')" class="btn btn-primary" />
            </div>
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
