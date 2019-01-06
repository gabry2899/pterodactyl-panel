<div class="d-flex mb-3">
    <div class="d-block">
        <div class="font-weight-strong" style="font-size: 70%;">@lang('server.files.current_directory')</div>
        <code>/home/container{{ $directory['header'] }}</code>
    </div>
    <div class="ml-auto btn-group">
        <a href="/server/{{ $server->uuidShort }}/files/add/@if($directory['header'] !== '')?dir={{ $directory['header'] }}@endif" class="btn btn-primary">
            <i class="far fa-file mr-2"></i>@lang('server.files.new_file')
        </a>
        <button class="btn btn-primary" data-action="add-folder">
            <i class="far fa-folder mr-2"></i>@lang('server.files.new_folder')
        </button>
        <label class="btn btn-info mb-0">
            <span><i class="fas fa-upload"></i>@lang('server.files.upload')</span>
            <input type="file" id="files_touch_target" class="d-none">
        </label>
        <div class="dropdown d-flex">
            <button type="button" id="mass_actions" class="btn btn-secondary dropdown-toggle disabled" data-toggle="dropdown">
                @lang('server.files.mass_actions')
            </button>
            <div class="dropdown-menu">
                <a href="#" id="selective-deletion" data-action="selective-deletion" class="dropdown-item"><i class="fas fa-trash mr-2"></i>@lang('server.files.delete')</a>
            </div>
        </div>
    </div>
</div>

<table class="table" id="file_listing" data-current-dir="{{ rtrim($directory['header'], '/') . '/' }}">
    <thead>
        <tr>
            <th class="middle min-size">
                <input type="checkbox" class="select-all-files" data-action="selectAll">
                <i class="fas fa-sync text-muted use-pointer icon" data-action="reload-files"></i>
            </th>
            <th>@lang('server.files.file_name')</th>
            <th>@lang('server.files.size')</th>
            <th>@lang('server.files.last_modified')</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="append_files_to">
        @if (isset($directory['first']) && $directory['first'] === true)
            <tr data-type="disabled">
                <td class="middle min-size"><i class="far fa-folder icon"></i></td>
                <td><a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">/</a></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
        @if (isset($directory['show']) && $directory['show'] === true)
            <tr data-type="disabled">
                <td class="middle min-size"><i class="far fa-folder icon"></i></td>
                <td data-name="{{ rawurlencode($directory['link']) }}">
                    <a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">../</a>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
        @foreach ($folders as $folder)
            <tr data-type="folder">
                <td class="middle min-size" data-identifier="type">
                    <input type="checkbox" class="select-folder hidden-xs" data-action="addSelection">
                    <i class="far fa-folder icon"></i>
                </td>
                <td data-identifier="name" data-name="{{ rawurlencode($folder['entry']) }}" data-path="@if($folder['directory'] !== ''){{ rawurlencode($folder['directory']) }}@endif/">
                    <a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">{{ $folder['entry'] }}</a>
                </td>
                <td data-identifier="size">{{ $folder['size'] }}</td>
                <td data-identifier="modified">
                    <?php $carbon = Carbon::createFromTimestamp($folder['date'])->timezone(config('app.timezone')); ?>
                    @if($carbon->diffInMinutes(Carbon::now()) > 60)
                        {{ $carbon->format('m/d/y H:i:s') }}
                    @elseif($carbon->diffInSeconds(Carbon::now()) < 5 || $carbon->isFuture())
                        <em>@lang('server.files.seconds_ago')</em>
                    @else
                        {{ $carbon->diffForHumans() }}
                    @endif
                </td>
                <td class="min-size">
                    <button class="btn btn-default disable-menu-hide" data-action="toggleMenu" style="padding:2px 6px 0px;">
                        <i class="fa fa-ellipsis-h disable-menu-hide"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        @foreach ($files as $file)
            <tr data-type="file" data-mime="{{ $file['mime'] }}">
                <td class="middle min-size" data-identifier="type"><input type="checkbox" class="select-file hidden-xs" data-action="addSelection">
                    {{--  oh boy --}}
                    @if(in_array($file['mime'], [
                        'application/x-7z-compressed',
                        'application/zip',
                        'application/x-compressed-zip',
                        'application/x-tar',
                        'application/x-gzip',
                        'application/x-bzip',
                        'application/x-bzip2',
                        'application/java-archive'
                    ]))
                        <i class="far fa-file-archive icon"></i>
                    @elseif(in_array($file['mime'], [
                        'application/json',
                        'application/javascript',
                        'application/xml',
                        'application/xhtml+xml',
                        'text/xml',
                        'text/css',
                        'text/html',
                        'text/x-perl',
                        'text/x-shellscript'
                    ]))
                    <i class="far fa-file-code icon"></i>
                    @elseif(starts_with($file['mime'], 'image'))
                    <i class="far fa-file-image icon"></i>
                    @elseif(starts_with($file['mime'], 'video'))
                    <i class="far fa-file-video icon"></i>
                    @elseif(starts_with($file['mime'], 'audio'))
                    <i class="far fa-file-audio icon"></i>
                    @elseif(starts_with($file['mime'], 'application/vnd.ms-powerpoint'))
                    <i class="far fa-file-powerpoint icon"></i>
                    @elseif(in_array($file['mime'], [
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                        'application/msword'
                    ]) || starts_with($file['mime'], 'application/vnd.ms-word'))
                    <i class="far fa-file-word icon"></i>
                    @elseif(in_array($file['mime'], [
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
                    ]) || starts_with($file['mime'], 'application/vnd.ms-excel'))
                    <i class="far fa-file-excel icon"></i>
                    @elseif($file['mime'] === 'application/pdf')
                    <i class="far fa-file-pdf icon"></i>
                    @else
                    <i class="far fa-file icon"></i>
                    @endif
                </td>
                <td data-identifier="name" data-name="{{ rawurlencode($file['entry']) }}" data-path="@if($file['directory'] !== ''){{ rawurlencode($file['directory']) }}@endif/">
                    @if(in_array($file['mime'], $editableMime))
                        @can('edit-files', $server)
                            <a href="/server/{{ $server->uuidShort }}/files/edit/@if($file['directory'] !== ''){{ $file['directory'] }}/@endif{{ $file['entry'] }}" class="edit_file">{{ $file['entry'] }}</a>
                        @else
                            {{ $file['entry'] }}
                        @endcan
                    @else
                        {{ $file['entry'] }}
                    @endif
                </td>
                <td data-identifier="size">{{ $file['size'] }}</td>
                <td data-identifier="modified">
                    <?php $carbon = Carbon::createFromTimestamp($file['date'])->timezone(config('app.timezone')); ?>
                    @if($carbon->diffInMinutes(Carbon::now()) > 60)
                        {{ $carbon->format('m/d/y H:i:s') }}
                    @elseif($carbon->diffInSeconds(Carbon::now()) < 5 || $carbon->isFuture())
                        <em>@lang('server.files.seconds_ago')</em>
                    @else
                        {{ $carbon->diffForHumans() }}
                    @endif
                </td>
                <td class="min-size">
                    <button class="btn btn-default disable-menu-hide" data-action="toggleMenu" style="padding:2px 6px 0px;">
                        <i class="fa fa-ellipsis-h disable-menu-hide"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<style>
    .icon {width: 25px; text-align: center;}
    .use-pointer {cursor: pointer;}
</style>