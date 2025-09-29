@extends('layouts.app')

@section('title', '공지사항')

@section('content')
<div id="mainContent" class="container sub_wrap notices_wrap">

    <div class="inner">
        <div class="title">공지사항
            <a href="{{ route('admin.notices.create') }}" class="btn_write btn_bl">글쓰기</a>
        </div>

        <div class="board_top">
            <div class="total">총 <strong class="col_blue">{{ $notices->total() }}</strong>개의 게시글</div>
            <div class="inputs">
                <form method="GET" action="{{ route('admin.notices.index') }}">
                    <div class="datepicker_area">
                        <input type="text" class="text datepicker datepicker_start" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <span class="bar"></span>
                    <div class="datepicker_area">
                        <input type="text" class="text datepicker datepicker_end" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <input type="text" class="text input" name="search" placeholder="제목 검색" value="{{ request('search') }}">
                    <button type="submit" class="btn">조회</button>
                </form>
            </div>
        </div>

        <div class="board_list chk_board">
            <table>
                <colgroup>
                    <col class="w4">
                    <col class="w8">
                    <col width="*">
                    <col class="w12">
                    <col class="w12">
                    <col class="w12">
                </colgroup>
                <thead>
                    <tr>
                        <th class="chk">
                            <label class="check solo">
                                <input type="checkbox" id="allCheck">
                                <i></i>
                            </label>
                        </th>
                        <th>No.</th>
                        <th>제목</th>
                        <th>담당자</th>
                        <th>등록일</th>
                        <th>조회수</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notices as $notice)
                    <tr class="@if($notice->is_important) notice @endif" data-id="{{ $notice->idx }}">
                        <td class="chk">
                            <label class="check solo">
                                <input type="checkbox" name="check" value="{{ $notice->idx }}">
                                <i></i>
                            </label>
                        </td>
                        <td class="num">
                            @if($notice->is_important)
                                <i class="icon">📢 공지</i>
                            @else
                                {{ $notices->total() - (($notices->currentPage() - 1) * $notices->perPage() + $loop->index) }}
                            @endif
                        </td>
                        <td class="tt order1">
                            <a href="{{ route('admin.notices.show', $notice->idx) }}">
                                {{ \Illuminate\Support\Str::limit($notice->title ?? '', 80) }}
                            </a>
                        </td>
                        <td class="mobe_tit name order2">{{ $notice->user->name ?? '-' }}</td>
                        <td class="mobe_tit date order3">{{ $notice->created_at ? $notice->created_at->format('Y.m.d') : '-' }}</td>
                        <td class="mobe_tit hit order4">{{ $notice->view_count }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="tac">등록된 공지사항이 없습니다.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="board_bottom">
            <div class="btns_tal">
                <button type="button" class="btn" id="deleteSelected">삭제</button>
            </div>
            <x-pagination :paginator="$notices" />
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('js/admin/notices.js') }}"></script>
@endpush
@endsection
