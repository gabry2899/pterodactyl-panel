@extends('layouts.master')

@section('title')
    @lang('navigation.server.new_task')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('navigation.account.my_servers')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.schedules', $server->uuidShort) }}">@lang('navigation.server.schedules')</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.new_task')</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="card card-body">
    <form action="{{ route('server.schedules.new', $server->uuidShort) }}" method="POST">
        <h3 class="box-title">@lang('server.schedule.setup')</h3>
        <div class="form-group">
            <label class="control-label" for="scheduleName">@lang('strings.name') <span class="field-optional"></span></label>
            <div>
                <input type="text" name="name" id="scheduleName" class="form-control" value="{{ old('name') }}" />
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="form-group">
                    <label for="scheduleDayOfWeek" class="control-label">@lang('server.schedule.day_of_week')</label>
                    <div>
                        <select data-action="update-field" data-field="cron_day_of_week" class="form-control" multiple>
                            <option value="0">@lang('strings.days.sun')</option>
                            <option value="1">@lang('strings.days.mon')</option>
                            <option value="2">@lang('strings.days.tues')</option>
                            <option value="3">@lang('strings.days.wed')</option>
                            <option value="4">@lang('strings.days.thurs')</option>
                            <option value="5">@lang('strings.days.fri')</option>
                            <option value="6">@lang('strings.days.sat')</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" id="scheduleDayOfWeek" class="form-control" name="cron_day_of_week" value="{{ old('cron_day_of_week') }}" />
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="form-group">
                    <label for="scheduleDayOfMonth" class="control-label">@lang('server.schedule.day_of_month')</label>
                    <div>
                        <select data-action="update-field" data-field="cron_day_of_month" class="form-control" multiple>
                            @foreach(range(1, 31) as $i)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" id="scheduleDayOfMonth" class="form-control" name="cron_day_of_month" value="{{ old('cron_day_of_month') }}" />
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="form-group">
                    <label for="scheduleHour" class="control-label">@lang('server.schedule.hour')</label>
                    <div>
                        <select data-action="update-field" data-field="cron_hour" class="form-control" multiple>
                            @foreach(range(0, 23) as $i)
                                <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" id="scheduleHour" class="form-control" name="cron_hour" value="{{ old('cron_hour') }}" />
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="form-group">
                    <label for="scheduleMinute" class="control-label">@lang('server.schedule.minute')</label>
                    <div>
                        <select data-action="update-field" data-field="cron_minute" class="form-control" multiple>
                            @foreach(range(0, 55) as $i)
                                @if($i % 5 === 0)
                                    <option value="{{ $i }}">_ _:{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" id="scheduleMinute" class="form-control" name="cron_minute" value="{{ old('cron_minute') }}" />
                </div>
            </div>
        </div>
        <p class="small text-muted no-margin-bottom">@lang('server.schedule.time_help')</p>
        <div id="containsTaskList">
            @include('partials.schedules.task-template')
        </div>
        <p class="text-muted small">@lang('server.schedule.task_help')</p>
        <div class="text-right">
            {!! csrf_field() !!}
            <button type="button" class="btn btn-primary" data-action="add-new-task"><i class="fa fa-plus"></i> @lang('server.schedule.task.add_more')</button>
            <button type="submit" class="btn btn-success">@lang('server.schedule.new.submit')</button>
        </div>
    </form>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script type="application/javascript">
        $.fn.select2 = function() {};
    </script>
    {!! Theme::js('js/frontend/server.socket.js') !!}
    {!! Theme::js('js/frontend/tasks/view-actions.js') !!}
@endsection
