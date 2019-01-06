
@extends('layouts.master')

@section('title')
    @lang('navigation.account.api_access')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">@lang('navigation.account.api_access')</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card card-body">
        <h3>@lang('base.api.header')</h3>
        <table class="table table-responsive">
            <tr>
                <th style="width: 100%;">@lang('strings.key')</th>
                <th style="min-width: 200px;">@lang('strings.memo')</th>
                <th style="min-width: 180px;">@lang('strings.last_activity')</th>
                <th style="min-width: 180px;">@lang('strings.created_at')</th>
                <th></th>
            </tr>
            @if (count($keys) == 0)
                <tr>
                    <td colspan=5 class="text-center py-5">
                        @lang('base.api.no_keys')
                    </td>
                </tr>
            @endif
            @foreach($keys as $key)
                <tr>
                    <td>
                        <code class="toggle-display" style="cursor:pointer" data-toggle="tooltip" data-placement="right" title="@lang('base.api.click_to_reveal')">
                            <i class="fa fa-key"></i> &bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;
                        </code>
                        <code class="d-none" data-attr="api-key">
                            {{ $key->identifier }}{{ decrypt($key->token) }}
                        </code>
                    </td>
                    <td>{{ $key->memo }}</td>
                    <td>
                        @if(!is_null($key->last_used_at))
                            @datetimeHuman($key->last_used_at)
                        @else
                            &mdash;
                        @endif
                    </td>
                    <td>@datetimeHuman($key->created_at)</td>
                    <td>
                        <a href="#" data-action="revoke-key" data-attr="{{ $key->identifier }}">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

@section('deploy')
    <a href="{{ route('account.api.new') }}" class="btn btn-primary btn-deploy" data-toggle="tooltip" title="@lang('base.api.create_new')" data-placement="left"><i class="fas fa-plus"></i></a>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.toggle-display').on('click', function () {
                $(this).parent().find('code[data-attr="api-key"]').removeClass('d-none');
                $(this).hide();
            });

            $('[data-action="revoke-key"]').click(function (event) {
                var self = $(this);
                event.preventDefault();
                swal({
                    type: 'error',
                    title: "@lang('base.api.revoke_title')",
                    text: "@lang('base.api.revoke_description')",
                    showCancelButton: true,
                    allowOutsideClick: true,
                    closeOnConfirm: false,
                    confirmButtonText: "@lang('strings.revoke')",
                    confirmButtonColor: '#d9534f',
                    showLoaderOnConfirm: true
                }, function () {
                    $.ajax({
                        method: 'DELETE',
                        url: Router.route('account.api.revoke', { identifier: self.data('attr') }),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).done(function (data) {
                        swal({
                            type: 'success',
                            title: '',
                            text: "@lang('base.api.revoke_success')"
                        });
                        self.parent().parent().slideUp();
                    }).fail(function (jqXHR) {
                        swal({
                            type: 'error',
                            title: 'Whoops!',
                            text: "@lang('base.api.revoke_error')"
                        });
                    });
                });
            });
        });
    </script>
@endsection
