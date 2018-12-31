@extends('layouts.master')

@section('title')
    @lang('server.schedules.new.header')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Servers</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.schedules', $server->uuidShort) }}">Schedules</a></li>
            <li class="breadcrumb-item active">{{ $schedule->name }}</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="card card-body">
    <form action="{{ route('server.schedules.view', ['server' => $server->uuidShort, 'schedule' => $schedule->hashid]) }}" method="POST">
        <h3 class="box-title">@lang('server.schedule.setup')</h3>
        <div class="form-group">
            <label class="control-label" for="scheduleName">@lang('strings.name') <span class="field-optional"></span></label>
            <div>
                <input type="text" name="name" id="scheduleName" class="form-control" value="{{ old('name', $schedule->name) }}" />
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
                    <input type="text" id="scheduleDayOfWeek" class="form-control" name="cron_day_of_week" value="{{ old('cron_day_of_week', $schedule->cron_day_of_week) }}" />
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
                    <input type="text" id="scheduleDayOfMonth" class="form-control" name="cron_day_of_month" value="{{ old('cron_day_of_month', $schedule->cron_day_of_month) }}" />
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
                    <input type="text" id="scheduleHour" class="form-control" name="cron_hour" value="{{ old('cron_hour', $schedule->cron_hour) }}" />
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
                    <input type="text" id="scheduleMinute" class="form-control" name="cron_minute" value="{{ old('cron_minute', $schedule->cron_minute) }}" />
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
            <button type="submit" class="btn btn-success" name="_method" value="PATCH">Save</button>
        </div>
    </form>
</div>
@endsection


@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    {!! Theme::js('vendor/select2/select2.full.min.js') !!}
    {!! Theme::js('js/frontend/tasks/view-actions.js') !!}
    <script>
        $(document).ready(function () {
            $('#deleteButton').on('mouseenter', function () {
                $(this).find('i').html(' @lang('server.schedule.manage.delete')');
            }).on('mouseleave', function () {
                $(this).find('i').html('');
            });
            $.each(Pterodactyl.tasks, function (index, value) {
                var element = (index !== 0) ? $('button[data-action="add-new-task"]').trigger('click').data('element') : $('div[data-target="task-clone"]');
                var timeValue = (value.time_offset > 59) ? value.time_offset / 60 : value.time_offset;
                var timeInterval = (value.time_offset > 59) ? 'm' : 's';
                element.find('input[name="tasks[time_value][]"]').val(timeValue).trigger('change');
                element.find('select[name="tasks[time_interval][]"]').val(timeInterval).trigger('change');
                element.find('select[name="tasks[action][]"]').val(value.action).trigger('change');
                element.find('input[name="tasks[payload][]"]').val(value.payload);
            });
        });
    </script>
@endsection
