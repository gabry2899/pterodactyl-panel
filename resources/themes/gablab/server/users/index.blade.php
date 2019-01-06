@extends('layouts.master')

@section('title')
    @lang('navigation.server.subusers')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('navigation.account.my_servers')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.subusers')</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card card-body">
        <div class="d-flex mb-3">
            <h3 class="d-block py-1 my-0">@lang('server.users.title')</h3>
            <div class="ml-auto">
                <a href="{{ route('server.subusers.new', $server->uuidShort) }}" class="btn btn-primary">@lang('strings.new')</a>
            </div>
        </div>
        <table class="table table-hover">
            <tr>
                <th></th>
                <th>@lang('strings.username')</th>
                <th>@lang('strings.email')</th>
                <th class="text-center">@lang('strings.2fa')</th>
                <th class="hidden-xs">@lang('strings.created_at')</th>
                @can('view-subuser', $server)<th></th>@endcan
                @can('delete-subuser', $server)<th></th>@endcan
            </tr>
            @foreach($subusers as $subuser)
                <tr>
                    <td class="text-center align-middle">
                        <img src="{{ $subuser->user->getAvatarUrlAttribute(120) }}" style="height: 38px; border-radius: 50%">
                    </td>
                    <td class="align-middle">{{ $subuser->user->username }}
                    <td class="align-middle"><code>{{ $subuser->user->email }}</code></td>
                    <td class="align-middle text-center">
                        @if($subuser->user->use_totp)
                            <i class="fas fa-lock text-success"></i>
                        @else
                            <i class="fas fa-unlock text-danger"></i>
                        @endif
                    </td>
                    <td class="align-middle hidden-xs">{{ $subuser->user->created_at }}</td>
                    @can('view-subuser', $server)
                        <td class="text-center align-middle">
                            <a href="{{ route('server.subusers.view', ['server' => $server->uuidShort, 'subuser' => $subuser->hashid]) }}">
                                <button class="btn btn-primary">@lang('server.users.configure')</button>
                            </a>
                        </td>
                    @endcan
                    @can('delete-subuser', $server)
                        <td class="text-center align-middle">
                            <a href="#/delete/{{ $subuser->hashid }}" data-action="delete" data-id="{{ $subuser->hashid }}">
                                <button class="btn btn-danger">@lang('strings.revoke')</button>
                            </a>
                        </td>
                    @endcan
                </tr>
            @endforeach
        </table>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    <script>
    $(document).ready(function () {
        $('[data-action="delete"]').click(function (event) {
            event.preventDefault();
            var self = $(this);
            swal({
                type: 'warning',
                title: "@lang('server.subusers.delete.title')",
                text: "@lang('server.subusers.delete.description')",
                showCancelButton: true,
                showConfirmButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                $.ajax({
                    method: 'DELETE',
                    url: Router.route('server.subusers.view', {
                        server: Pterodactyl.server.uuidShort,
                        subuser: self.data('id'),
                    }),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                    }
                }).done(function () {
                    self.parent().parent().slideUp();
                    swal({
                        type: 'success',
                        title: '',
                        text: "@lang('server.subusers.delete.success')"
                    });
                }).fail(function (jqXHR) {
                    console.error(jqXHR);
                    var error = "@lang('server.subusers.delete.error')";
                    if (typeof jqXHR.responseJSON !== 'undefined' && typeof jqXHR.responseJSON.error !== 'undefined') {
                        error = jqXHR.responseJSON.error;
                    }
                    swal({
                        type: 'error',
                        title: 'Whoops!',
                        text: error
                    });
                });
            });
        });
    });
    </script>

@endsection
