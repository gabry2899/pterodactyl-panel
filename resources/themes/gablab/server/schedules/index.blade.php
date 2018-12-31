@extends('layouts.master')

@section('title')
    @lang('server.schedule.header')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Servers</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">Schedules</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="card card-body">
    <div class="d-flex mb-3">
        <h3 class="d-block py-1 my-0">@lang('server.schedule.current')</h3>
        <div class="ml-auto">
            <a href="{{ route('server.schedules.new', $server->uuidShort) }}" class="btn btn-primary">Create New</a>
        </div>
    </div>
    <table class="table table-hover">
        <tr>
            <th>@lang('strings.name')</th>
            <th class="text-center">@lang('strings.queued')</th>
            <th class="text-center">@lang('strings.tasks')</th>
            <th>@lang('strings.last_run')</th>
            <th>@lang('strings.next_run')</th>
            <th></th>
        </tr>
        @if (count($schedules) == 0)
            <tr>
                <td colspan="6" class="text-center py-5">There are no schedules for this server yet!</td>
            </tr>
        @endif
        @foreach($schedules as $schedule)
            <tr @if(! $schedule->is_active)class="muted muted-hover"@endif>
                <td class="align-middle">
                    @can('edit-schedule', $server)
                        <a href="{{ route('server.schedules.view', ['server' => $server->uuidShort, '$schedule' => $schedule->hashid]) }}">{{ $schedule->name ?? trans('server.schedule.unnamed') }}</a>
                    @else
                        {{ $schedule->name ?? trans('server.schedule.unnamed') }}
                    @endcan
                </td>
                <td class="align-middle text-center">
                    @if ($schedule->is_processing)
                        <span class="label label-success">@lang('strings.yes')</span>
                    @else
                        <span class="label label-default">@lang('strings.no')</span>
                    @endif
                </td>
                <td class="align-middle text-center"><span class="label label-primary">{{ $schedule->tasks_count }}</span></td>
                <td class="align-middle">
                    @if($schedule->last_run_at)
                        {{ Carbon::parse($schedule->last_run_at)->toDayDateTimeString() }}<br /><span class="text-muted small">({{ Carbon::parse($schedule->last_run_at)->diffForHumans() }})</span>
                    @else
                        <em class="text-muted">@lang('strings.not_run_yet')</em>
                    @endif
                </td>
                <td class="align-middle">
                    @if($schedule->is_active)
                        {{ Carbon::parse($schedule->next_run_at)->toDayDateTimeString() }}<br /><span class="text-muted small">({{ Carbon::parse($schedule->next_run_at)->diffForHumans() }})</span>
                    @else
                        <em>n/a</em>
                    @endif
                </td>
                <td class="align-middle text-right">
                    @can('delete-schedule', $server)
                        <a class="btn btn-danger" href="#" data-action="delete-schedule" data-schedule-id="{{ $schedule->hashid }}" data-toggle="tooltip" data-placement="top" title="@lang('strings.delete')"><i class="fas fa-trash"></i></a>
                    @endcan
                    @can('toggle-schedule', $server)
                        <a class="btn btn-secondary" href="#" data-action="toggle-schedule" data-active="{{ $schedule->active }}" data-schedule-id="{{ $schedule->hashid }}" data-toggle="tooltip" data-placement="top" title="@lang('server.schedule.toggle')"><i class="fa fa-fw fa-eye-slash"></i></a>
                        <a class="btn btn-secondary" href="#" data-action="trigger-schedule" data-schedule-id="{{ $schedule->hashid }}" data-toggle="tooltip" data-placement="top" title="@lang('server.schedule.run_now')"><i class="fas fa-sync"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    {!! Theme::js('js/frontend/tasks/management-actions.js') !!}
@endsection
