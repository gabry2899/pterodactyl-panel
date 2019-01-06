
@extends('layouts.master')

@section('title')
{{ $file }}
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('navigation.account.my_servers')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.files.index', $server->uuidShort) }}">@lang('navigation.server.file_management')</a></li>
            <li class="breadcrumb-item active">{{ $file }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <input type="hidden" name="file" value="{{ $file }}" />
    <textarea id="editorSetContent" class="d-none">{{ $contents }}</textarea>
    <div style="height:500px; width: 100%; margin: 1em 0;" id="editor"></div>
    <div class="text-right">
        <button class="btn btn-primary" id="save_file"><i class="fa fa-fw fa-save"></i> &nbsp;@lang('server.files.edit.save')</button>
        <a href="/server/{{ $server->uuidShort }}/files#{{ rawurlencode($directory) }}"><button class="btn btn-secondary">@lang('server.files.edit.return')</button></a>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    {!! Theme::js('vendor/ace/ace.js') !!}
    {!! Theme::js('vendor/ace/ext-modelist.js') !!}
    {!! Theme::js('vendor/ace/ext-whitespace.js') !!}
    {!! Theme::js('js/frontend/files/editor.js') !!}
    <script>
        $(document).ready(function () {
            Editor.setValue($('#editorSetContent').val(), -1);
            Editor.getSession().setUndoManager(new ace.UndoManager());
            $('#editorLoadingOverlay').hide();
        });
    </script>
@endsection
