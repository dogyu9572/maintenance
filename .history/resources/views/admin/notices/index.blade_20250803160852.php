@extends('layouts.app')

@section('title', '공지사항')

@section('content')
<div id="mainContent" class="container sub_wrap notices_wrap">

    <div class="inner">
        <div class="title">공지사항
            <a href="{{ route('admin.notices.create') }}" class="btn_write btn_bl">글쓰기</a>
        </div>

        <div class="board_top">
            <div class="total">총 <strong class="col_blue">{{ $totalCount ?? 3243 }}</strong>개의 게시글</div>
            <div class="inputs">
                <form method="GET" action="{{ route('admin.notices.index') }}">
                    <div class="datepicker_area">
                        <input type="text" class="text datepicker datepicker_start" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <span class="bar"></span>
                    <div class="datepicker_area">
                        <input type="text" class="text datepicker datepicker_end" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <input type="text" class="text input" name="search" placeholder="제목으로 검색이 가능합니다." value="{{ request('search') }}">
                    <button type="submit" class="btn">조회</button>
                </form>
            </div>
        </div>

        <div class="board_list">
            <table>
                <colgroup>
                    <col class="w8">
                    <col width="*">
                    <col class="w12">
                    <col class="w12">
                    <col class="w12">
                </colgroup>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>제목</th>
                        <th>담당자</th>
                        <th>등록일</th>
                        <th>조회수</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notices ?? [] as $notice)
                    <tr class="{{ $notice->is_notice ? 'notice' : '' }}">
                        <td class="num">
                            @if($notice->is_notice)
                            <i class="icon">📢 공지</i>
                            @else
                            {{ $notice->idx }}
                            @endif
                        </td>
                        <td class="tt order1">
                            <a href="{{ route('admin.notices.show', $notice->idx) }}">
                                {{ Str::limit($notice->title ?? '홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다.', 80) }}
                            </a>
                        </td>
                        <td class="mobe_tit name order2">{{ $notice->writer_name ?? '오유림' }}</td>
                        <td class="mobe_tit date order3">{{ $notice->created_at ? $notice->created_at->format('Y.m.d') : '2024.07.11' }}</td>
                        <td class="mobe_tit hit order4">{{ $notice->view_count ?? 1234 }}</td>
                    </tr>
                    @empty
                    <tr class="notice">
                        <td class="num"><i class="icon">📢 공지</i></td>
                        <td class="tt order1">
                            <a href="{{ route('admin.notices.show', 1) }}">
                                홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..
                            </a>
                        </td>
                        <td class="mobe_tit name order2">오유림</td>
                        <td class="mobe_tit date order3">2024.07.11</td>
                        <td class="mobe_tit hit order4">1234</td>
                    </tr>
                    <tr>
                        <td class="num">9</td>
                        <td class="tt order1">
                            <a href="{{ route('admin.notices.show', 2) }}">
                                홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..
                            </a>
                        </td>
                        <td class="mobe_tit name order2">오유림</td>
                        <td class="mobe_tit date order3">2024.07.11</td>
                        <td class="mobe_tit hit order4">1234</td>
                    </tr>
                    <tr>
                        <td class="num">8</td>
                        <td class="tt order1">
                            <a href="{{ route('admin.notices.show', 3) }}">
                                홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..
                            </a>
                        </td>
                        <td class="mobe_tit name order2">오유림</td>
                        <td class="mobe_tit date order3">2024.07.11</td>
                        <td class="mobe_tit hit order4">1234</td>
                    </tr>
                    <tr>
                        <td class="num">7</td>
                        <td class="tt order1">
                            <a href="{{ route('admin.notices.show', 4) }}">
                                홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..
                            </a>
                        </td>
                        <td class="mobe_tit name order2">오유림</td>
                        <td class="mobe_tit date order3">2024.07.11</td>
                        <td class="mobe_tit hit order4">1234</td>
                    </tr>
                    <tr>
                        <td class="num">6</td>
                        <td class="tt order1">
                            <a href="{{ route('admin.notices.show', 5) }}">
                                홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..
                            </a>
                        </td>
                        <td class="mobe_tit name order2">오유림</td>
                        <td class="mobe_tit date order3">2024.07.11</td>
                        <td class="mobe_tit hit order4">1234</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="board_bottom">
            <x-pagination :paginator="$notices" />
        </div>
    </div>
</div>
@endsection
