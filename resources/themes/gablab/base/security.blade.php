
@extends('layouts.master')

@section('title')
    Security
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item active">Security</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-body">
                <h3>Active Sessions</h3>
                @if(!is_null($sessions))
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>IP Address</th>
                            <th>Last Activity</th>
                            <th></th>
                        </tr>
                        @foreach($sessions as $session)
                            <tr>
                                <td><code>{{ substr($session->id, 0, 6) }}</code></td>
                                <td>{{ $session->ip_address }}</td>
                                <td>{{ Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}</td>
                                <td class="text-right">
                                    <a href="{{ route('account.security.revoke', $session->id) }}"><i class="fas fa-trash mr-2"></i>Revoke</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p class="text-muted">@lang('Your host has not enabled the ability to manage account sessions via this interface.')</p>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body">
                <h3>Two Factor Authentication</h3>
                @if(Auth::user()->use_totp)
                <form action="{{ route('account.security.totp') }}" method="post">
                    <div class="box-body">
                        <p>@lang('base.security.2fa_enabled')</p>
                        <div class="form-group">
                            <label for="new_password_again" class="control-label">@lang('strings.2fa_token')</label>
                            <div>
                                <input type="text" class="form-control" name="token" />
                                <p class="text-muted small">@lang('base.security.2fa_token_help')</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-outline-danger">@lang('base.security.disable_2fa')</button>
                    </div>
                </form>
                @else
                <form action="#" method="post" id="do_2fa">
                    <p>
                        2fa is now disabled.
                    </p>
                    <div class="text-right">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-outline-primary">Enable Now</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="open2fa" tabindex="-1" role="dialog" aria-labelledby="open2fa" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="#" method="post" id="2fa_token_verify">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('base.security.2fa_qr')</h4>
                    </div>
                    <div class="modal-body" id="modal_insert_content">
                        <div class="row">
                            <div class="col-md-12" id="notice_box_2fa" style="display:none;"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <span id="hide_img_load"><i class="fa fa-spinner fa-spin"></i> Loading QR Code...</span><img src="" id="qr_image_insert" style="display:none;"/>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-info">@lang('base.security.2fa_checkpoint_help')</div>
                                <div class="form-group">
                                    <label class="control-label" for="2fa_token">@lang('strings.2fa_token')</label>
                                    {!! csrf_field() !!}
                                    <input class="form-control" type="text" name="2fa_token" id="2fa_token" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit_action">@lang('strings.submit')</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_reload">@lang('strings.close')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/2fa-modal.js') !!}   
@endsection
