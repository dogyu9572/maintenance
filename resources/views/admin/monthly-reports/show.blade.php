@extends('layouts.app')

@section('title', '월간보고서 상세')

@section('content')
<div id="mainContent" class="container sub_wrap maintenance_requests_wrap">
    <div class="inner">
        <a href="{{ route('admin.monthly-reports.index') }}" class="goback">뒤로</a>
        <div class="title">월간보고서</div>

        <div class="board_view glbox">
            <div class="tit">{{ $report->title }}</div>
            <div class="writer row">
                <dl>
                    <dt>고객사명</dt>
                    <dd>{{ $report->client->name ?? ($report->client->company_name ?? '') }}</dd>
                </dl>
                <dl>
                    <dt>연/월</dt>
                    <dd>{{ $report->year }} / {{ $report->month }}</dd>
                </dl>
                <dl>
                    <dt>작성자</dt>
                    <dd>{{ $report->user->name ?? '' }}</dd>
                </dl>
                <dl>
                    <dt>등록일</dt>
                    <dd>{{ optional($report->created_at)->format('Y.m.d') }}</dd>
                </dl>
                <dl>
                    <dt>노출여부</dt>
                    <dd>{{ $report->is_published ? 'Y' : 'N' }}</dd>
                </dl>
            </div>

            <div class="con">{!! nl2br(e($report->content)) !!}</div>
        </div>

        <a href="{{ route('admin.monthly-reports.index') }}" class="btn_list">목록</a>
    </div>
</div>
@endsection


