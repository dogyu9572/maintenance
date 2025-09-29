@extends('layouts.app')

@section('title', '공지사항')

@section('content')
<div id="mainContent" class="container sub_wrap notices_wrap">
    <div class="inner">
        <a href="{{ route('admin.notices.index') }}" class="goback">뒤로</a>
        <div class="title">공지사항</div>

        <div class="board_view glbox">
            <div class="tit">{{ $notice->title }}</div>
            <div class="writer row">
                <dl>
                    <dt>작성자</dt>
                    <dd>{{ $notice->user->name ?? '' }}</dd>
                </dl>
                <dl>
                    <dt>등록일</dt>
                    <dd>{{ $notice->created_at ? $notice->created_at->format('Y.m.d') : '' }}</dd>
                </dl>
                <dl>
                    <dt>조회수</dt>
                    <dd>{{ $notice->view_count }}</dd>
                </dl>
            </div>

            @if($notice->files->count())
            <div class="download_file">
                @foreach($notice->files as $file)
                    <a href="{{ route('admin.notices.files.download', $file->idx) }}" class="down" download>{{ $file->original_name }}</a>
                @endforeach
            </div>
            @endif

            <div class="con">{!! nl2br(e($notice->content)) !!}</div>
        </div>

        <a href="{{ route('admin.notices.index') }}" class="btn_list">목록</a>
    </div>
</div>
@endsection


