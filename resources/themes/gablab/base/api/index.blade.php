
@extends('layouts.master')

@section('title')
    Api Access
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item active">Api Access</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card card-body">
        <h3>Api Access</h3>
        <table class="table table-responsive">
            <tr>
                <th style="width: 100%;">Key</th>
                <th style="min-width: 200px;">Memo</th>
                <th style="min-width: 180px;">Last Used</th>
                <th style="min-width: 180px;">Created</th>
                <th></th>
            </tr>
            @if (count($keys) == 0)
                <tr>
                    <td colspan=5 class="text-center py-5">
                        You have no api keys here.<br />
                        Click the bottom right "+" button to create one.
                    </td>
                </tr>
            @endif
            @foreach($keys as $key)
                <tr>
                    <td>
                        <code class="toggle-display" style="cursor:pointer" data-toggle="tooltip" data-placement="right" title="Click to Reveal">
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
    <a href="{{ route('account.api.new') }}" class="btn btn-primary btn-deploy" data-toggle="tooltip" title="Create new API key" data-placement="left"><i class="fas fa-plus"></i></a>
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
                    title: 'Revoke API Key',
                    text: 'Once this API key is revoked any applications currently using it will stop working.',
                    showCancelButton: true,
                    allowOutsideClick: true,
                    closeOnConfirm: false,
                    confirmButtonText: 'Revoke',
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
                            text: 'API Key has been revoked.'
                        });
                        self.parent().parent().slideUp();
                    }).fail(function (jqXHR) {
                        swal({
                            type: 'error',
                            title: 'Whoops!',
                            text: 'An error occurred while attempting to revoke this key.'
                        });
                    });
                });
            });
        });
    </script>
@endsection
