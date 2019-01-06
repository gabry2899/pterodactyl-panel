@section('tasks::chain-template')
    <div class="row task-list-item" data-target="task-clone" id="taskAppendBefore">
        <div class="form-group col-12 col-lg-3">
            <label class="control-label">@lang('server.schedule.task.time')</label>
            <div class="row">
                <div class="col-6">
                    <input name="tasks[time_value][]" type="number" min="0" max="59" value="0" class="form-control">
                </div>
                <div class="col-6">
                    <select name="tasks[time_interval][]" class="form-control">
                        <option value="s">@lang('strings.seconds')</option>
                        <option value="m">@lang('strings.minutes')</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group col-lg-3 col-12">
            <label class="control-label">@lang('server.schedule.task.action')</label>
            <div>
                <select name="tasks[action][]" class="form-control">
                    <option value="command">@lang('server.schedule.actions.command')</option>
                    <option value="power">@lang('server.schedule.actions.power')</option>
                </select>
            </div>
        </div>
        <div class="form-group col-lg-6 col-12">
            <label class="control-label">@lang('server.schedule.task.payload')</label>
            <div data-attribute="remove-task-element" class="input-group">
                <input type="text" name="tasks[payload][]" class="form-control">
                <div class="input-group-append d-none" data-attribute="remove-task-element">
                    <button type="button" class="btn btn-danger" data-action="remove-task"><i class="fas fa-times"></i></button>
                </div>
            </div>
        </div>
    </div>
@show
