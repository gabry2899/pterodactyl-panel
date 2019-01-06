@extends('layouts.master')

@section('title')
    @lang('navigation.server.databases')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('navigation.account.my_servers')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.databases')</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="row">
    <div class="{{ $allowCreation && Gate::allows('create-database', $server) ? 'col-12 col-lg-8' : 'col-12' }}">
        <div class="card card-body">
            <h3 class="box-title">@lang('server.config.database.your_dbs')</h3>
            @if(count($databases) > 0)
                <table class="table">
                    <tr>
                        <th>@lang('strings.database')</th>
                        <th>@lang('strings.username')</th>
                        <th>@lang('strings.password')</th>
                        <th>@lang('server.config.database.host')</th>
                        @can('reset-db-password', $server)<td></td>@endcan
                    </tr>
                    @foreach($databases as $database)
                        <tr>
                            <td class="py-3">{{ $database->database }}</td>
                            <td class="py-3">{{ $database->username }}</td>
                            <td class="py-3">
                                <code class="toggle-display" style="cursor:pointer" data-toggle="tooltip" data-placement="right" title="Click to Reveal">
                                    <i class="fas fa-key"></i> &bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;
                                </code>
                                <code class="d-none" data-attr="set-password">
                                    {{ Crypt::decrypt($database->password) }}
                                </code>
                            </td>
                            <td class="py-3"><code>{{ $database->host->host }}:{{ $database->host->port }}</code></td>
                            @if(Gate::allows('reset-db-password', $server) || Gate::allows('delete-database', $server))
                                <td class="text-right">
                                    @can('delete-database', $server)
                                        <button class="btn btn-danger" data-action="delete-database" data-id="{{ $database->id }}"><i class="fas fa-trash"></i></button>
                                    @endcan
                                    @can('reset-db-password', $server)
                                        <button class="btn btn-primary ml-1" data-action="reset-password" data-id="{{ $database->id }}" data-toggle="tooltip" title="Change Password"><i class="fas fa-key"></i></button>
                                    @endcan
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="pb-5">
                    @lang('server.config.database.no_dbs')
                </div>
            @endif
        </div>
    </div>
    @if($allowCreation && Gate::allows('create-database', $server))
        <div class="col-12 col-lg-4">
            <div class="card card-body">
                <h3>@lang('server.config.database.create_title')</h3>
                @if($overLimit)
                    <div class="pb-5">
                        @lang('server.config.database.using', ['used' => count($databases), 'max' => $server->database_limit ?? '∞'])
                    </div>
                @else
                    <form action="{{ route('server.databases.new', $server->uuidShort) }}" method="POST">
                        <div class="form-group">
                            <label for="pDatabaseName" class="control-label">@lang('strings.database')</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">s{{ $server->id }}_</span>
                                </div>
                                <input id="pDatabaseName" type="text" name="database" class="form-control" placeholder="database" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pRemote" class="control-label">@lang('strings.connections')</label>
                            <input id="pRemote" type="text" name="remote" class="form-control" value="%" />
                            <p class="text-muted small">@lang('server.config.database.connections_hint')</p>
                        </div>
                        <p class="text-muted small">
                            @lang('server.config.database.using', ['used' => count($databases), 'max' => $server->database_limit ?? '∞'])
                        </p>
                        <div class="text-right">
                            {!! csrf_field() !!}
                            <input type="submit" class="btn btn-primary" value="@lang('strings.create')" />
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $('.toggle-display').on('click', function () {
            $(this).parent().find('code[data-attr="set-password"]').removeClass('d-none');
            $(this).hide();
        });
        @can('reset-db-password', $server)
            $('[data-action="reset-password"]').click(function (e) {
                e.preventDefault();
                var block = $(this);
                $(this).addClass('disabled').find('i').addClass('fa-spin fa-circle-notch').removeClass("fa-key");
                $.ajax({
                    type: 'PATCH',
                    url: Router.route('server.databases.password', { server: Pterodactyl.server.uuidShort }),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                    },
                    data: {
                        database: $(this).data('id')
                    }
                }).done(function (data) {
                    block.parent().parent().find('[data-attr="set-password"]').html(data.password);
                }).fail(function(jqXHR) {
                    console.error(jqXHR);
                    var error = 'An error occurred while trying to process this request.';
                    if (typeof jqXHR.responseJSON !== 'undefined' && typeof jqXHR.responseJSON.error !== 'undefined') {
                        error = jqXHR.responseJSON.error;
                    }
                    swal({
                        type: 'error',
                        title: 'Whoops!',
                        text: error
                    });
                }).always(function () {
                    block.removeClass('disabled').find('i').removeClass('fa-spin fa-circle-notch').addClass("fa-key");
                });
            });
        @endcan
        @can('delete-database', $server)
            $('[data-action="delete-database"]').click(function (event) {
                event.preventDefault();
                var self = $(this);
                swal({
                    title: '',
                    type: 'warning',
                    text: 'Are you sure that you want to delete this database? There is no going back, all data will immediately be removed.',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#d9534f',
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function () {
                    $.ajax({
                        method: 'DELETE',
                        url: Router.route('server.databases.delete', { server: '{{ $server->uuidShort }}', database: self.data('id') }),
                        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    }).done(function () {
                        self.parent().parent().slideUp();
                        swal.close();
                    }).fail(function (jqXHR) {
                        console.error(jqXHR);
                        swal({
                            type: 'error',
                            title: 'Whoops!',
                            text: (typeof jqXHR.responseJSON.error !== 'undefined') ? jqXHR.responseJSON.error : 'An error occurred while processing this request.'
                        });
                    });
                });
            });
        @endcan
    </script>
@endsection
