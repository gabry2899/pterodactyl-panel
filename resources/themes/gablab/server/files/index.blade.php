@extends('layouts.master')

@section('title')
    @lang('navigation.server.file_management')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('navigation.account.my_servers')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.file_management')</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card card-body" id="load_files">
        <div class="text-center">
            <div class="fa-5x">
                <i class="fas fa-circle-notch fa-spin"></i>
            </div>
            <p class="mt-5">@lang('server.files.loading')</p>
        </div>
    </div>
    <p class="text-muted small mt-3" style="margin: 0 0 2px;">@lang('server.files.path', ['path' => '<code>/home/container</code>', 'size' => '<code>' . $node->upload_size . ' MB</code>'])</p>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js?t={cache-version}') !!}
    {!! Theme::js('vendor/async/async.min.js?t={cache-version}') !!}
    {!! Theme::js('vendor/lodash/lodash.js?t={cache-version}') !!}
    {!! Theme::js('vendor/siofu/client.min.js?t={cache-version}') !!}
    @if(App::environment('production') && false)
        {!! Theme::js('js/frontend/files/filemanager.min.js?updated-cancel-buttons&t={cache-version}') !!}
    @else
        {!! Theme::js('js/frontend/files/src/index.js?t={cache-version}') !!}
        {!! Theme::js('js/frontend/files/src/contextmenu.js?t={cache-version}') !!}
        {!! Theme::js('js/frontend/files/src/actions.js?t={cache-version}') !!}
    @endif
    {!! Theme::js('js/frontend/files/upload.js?t={cache-version}') !!}
@endsection
