@extends('layouts.master')

@section('title')
    @lang('navigation.account.my_account')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">@lang('navigation.account.my_account')</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card card-body mb-4">
                <h3>@lang('base.account.update_pass')</h3>
                <form action="{{ route('account') }}" method="post">
                    <div class="form-group">
                        <label for="current_password" class="control-label">@lang('base.account.current_password')</label>
                        <div>
                            <input type="password" class="form-control" name="current_password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_password" class="control-label">@lang('base.account.new_password')</label>
                        <div>
                            <input type="password" class="form-control" name="new_password" />
                            <p class="text-muted small no-margin">
                                @lang('base.account.password_help')
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_password_again" class="control-label">@lang('base.account.new_password_again')</label>
                        <div>
                            <input type="password" class="form-control" name="new_password_confirmation" />
                        </div>
                    </div>
                    <div class="text-right">
                        {!! csrf_field() !!}
                        <input type="hidden" name="do_action" value="password" />
                        <input type="submit" class="btn btn-outline-primary" value="@lang('base.account.update_pass')" />
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card card-body mb-4">
                <h3>@lang('base.account.update_identity')</h3>
                <form action="{{ route('account') }}" method="post">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="first_name" class="control-label">@lang('base.account.first_name')</label>
                            <div>
                                <input type="text" class="form-control" name="name_first" value="{{ Auth::user()->name_first }}" />
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="last_name" class="control-label">@lang('base.account.last_name')</label>
                            <div>
                                <input type="text" class="form-control" name="name_last" value="{{ Auth::user()->name_last }}" />
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="password" class="control-label">@lang('strings.username')</label>
                            <div>
                                <input type="text" class="form-control" name="username" value="{{ Auth::user()->username }}" />
                                <p class="text-muted small no-margin">@lang('base.account.username_help', [ 'requirements' => '<code>a-z A-Z 0-9 _ - .</code>'])</p>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="language" class="control-label">@lang('base.account.language')</label>
                            <div>
                                <select name="language" id="language" class="form-control">
                                    @foreach($languages as $key => $value)
                                        <option value="{{ $key }}" {{ Auth::user()->language !== $key ?: 'selected' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {!! csrf_field() !!}
                        <input type="hidden" name="do_action" value="identity" />
                        <button type="submit" class="btn btn-outline-primary">@lang('base.account.update_identity')</button>
                    </div>
                </form>
            </div>
            <div class="card card-body">
                <h3>@lang('base.account.update_email')</h3>
                <form action="{{ route('account') }}" method="post">
                    <div class="form-group">
                        <label for="new_email" class="control-label">@lang('base.account.new_email')</label>
                        <div>
                            <input type="email" class="form-control" name="new_email" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">@lang('base.account.current_password')</label>
                        <div>
                            <input type="password" class="form-control" name="current_password" />
                        </div>
                    </div>
                    <div class="text-right">
                        {!! csrf_field() !!}
                        <input type="hidden" name="do_action" value="email" />
                        <input type="submit" class="btn btn-outline-primary" value="@lang('base.account.update_email')" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
