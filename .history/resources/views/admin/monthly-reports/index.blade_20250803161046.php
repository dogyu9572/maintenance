@extends('layouts.app')

@section('title', '월간보고서')

@section('content')
<div id="mainContent" class="container sub_wrap maintenance_requests_wrap">

    <div class="inner">
        <div class="title">월간보고서
            <div class="btns">
                <a href="javascript:void(0);" class="btn_write">이번달 보고서 생성</a>
                <a href="{{ route('admin.monthly-reports.create') }}" class="btn_write btn_bl">직접작성</a>
            </div>
        </div>

        <div class="board_top">
            <div class="total">총 <strong class="col_blue">{{ $totalCount ?? 3243 }}</strong>개의 게시글</div>
            <div class="inputs mo_flex_sqr">
                <form method="GET" action="{{ route('admin.monthly-reports.index') }}">
                    <select name="client_id" class="text mr">
                        <option value="">고객사명</option>
                        @foreach($clients ?? [] as $client)
                        <option value="{{ $client->idx }}" {{ request('client_id') == $client->idx ? 'selected' : '' }}>
                            {{ $client->company_name }}
                        </option>
                        @endforeach
                    </select>
                    <select name="year" class="text mr">
                        <option value="">연</option>
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <select name="month" class="text mr">
                        <option value="">월</option>
                        @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endfor
                    </select>
                    <select name="per_page" class="text">
                        <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20개씩 보기</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50개씩 보기</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100개씩 보기</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="board_list chk_board">
            <table>
                <colgroup>
                    <col class="w4">
                    <col class="w6">
                    <col class="w6">
                    <col class="w16">
                    <col width="*">
                    <col class="w18">
                    <col class="w6">
                    <col class="w12">
                    <col class="w10">
                    <col class="w7">
                </colgroup>
                <thead>
                    <tr>
                        <th class="chk"><label class="check solo"><input type="checkbox" id="allCheck"><i></i></label></th>
                        <th>No.</th>
                        <th>연</th>
                        <th>고객사명</th>
                        <th>제목</th>
                        <th>업무기간</th>
                        <th>담당자</th>
                        <th>보고일(등록일)</th>
                        <th>출력/다운로드</th>
                        <th>노출여부</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports ?? [] as $report)
                    <tr>
                        <td class="chk order1">
                            <label class="check solo">
                                <input type="checkbox" name="check" value="{{ $report->idx }}">
                                <i></i>
                            </label>
                        </td>
                        <td class="tac num">{{ $report->idx }}</td>
                        <td class="mobe_tit year order2">{{ $report->year ?? '2024' }}</td>
                        <td class="mobe_tit customer order3">{{ $report->client_name ?? '강동성심병원' }}</td>
                        <td class="tt order4">
                            <a href="{{ route('admin.monthly-reports.show', $report->idx) }}">
                                {{ $report->year ?? '2024' }}년 {{ $report->month ?? '6' }}월 업무현황보고서
                            </a>
                        </td>
                        <td class="mobe_tit dates order5">{{ $report->work_period ?? '2024.05.01~2024.05.31' }}</td>
                        <td class="mobe_tit name order6">{{ $report->manager_name ?? '오유림' }}</td>
                        <td class="mobe_tit report order6">{{ $report->created_at ? $report->created_at->format('Y.m.d') : '2024.07.11' }}</td>
                        <td class="print order9">
                            <a href="{{ route('admin.monthly-reports.print', $report->idx) }}" target="_blank" class="btn_print">출력</a>
                        </td>
                        <td class="mobe_tit view order6">{{ $report->is_visible ? 'Y' : 'N' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="chk order1">
                            <label class="check solo">
                                <input type="checkbox" name="check" value="10">
                                <i></i>
                            </label>
                        </td>
                        <td class="tac num">10</td>
                        <td class="mobe_tit year order2">2024</td>
                        <td class="mobe_tit customer order3">강동성심병원</td>
                        <td class="tt order4">
                            <a href="{{ route('admin.monthly-reports.show', 10) }}">
                                2024년 6월 업무현황보고서
                            </a>
                        </td>
                        <td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
                        <td class="mobe_tit name order6">오유림</td>
                        <td class="mobe_tit report order6">2024.07.11</td>
                        <td class="print order9">
                            <a href="{{ route('admin.monthly-reports.print', 10) }}" target="_blank" class="btn_print">출력</a>
                        </td>
                        <td class="mobe_tit view order6">N</td>
                    </tr>
                    <tr>
                        <td class="chk order1">
                            <label class="check solo">
                                <input type="checkbox" name="check" value="9">
                                <i></i>
                            </label>
                        </td>
                        <td class="tac num">9</td>
                        <td class="mobe_tit year order2">2024</td>
                        <td class="mobe_tit customer order3">강동성심병원</td>
                        <td class="tt order4">
                            <a href="{{ route('admin.monthly-reports.show', 9) }}">
                                2024년 5월 업무현황보고서
                            </a>
                        </td>
                        <td class="mobe_tit dates order5">2024.04.01~2024.04.30</td>
                        <td class="mobe_tit name order6">오유림</td>
                        <td class="mobe_tit report order6">2024.07.11</td>
                        <td class="print order9">
                            <a href="{{ route('admin.monthly-reports.print', 9) }}" target="_blank" class="btn_print">출력</a>
                        </td>
                        <td class="mobe_tit view order6">N</td>
                    </tr>
                    <tr>
                        <td class="chk order1">
                            <label class="check solo">
                                <input type="checkbox" name="check" value="8">
                                <i></i>
                            </label>
                        </td>
                        <td class="tac num">8</td>
                        <td class="mobe_tit year order2">2024</td>
                        <td class="mobe_tit customer order3">강동성심병원</td>
                        <td class="tt order4">
                            <a href="{{ route('admin.monthly-reports.show', 8) }}">
                                2024년 4월 업무현황보고서
                            </a>
                        </td>
                        <td class="mobe_tit dates order5">2024.03.01~2024.03.31</td>
                        <td class="mobe_tit name order6">오유림</td>
                        <td class="mobe_tit report order6">2024.07.11</td>
                        <td class="print order9">
                            <a href="{{ route('admin.monthly-reports.print', 8) }}" target="_blank" class="btn_print">출력</a>
                        </td>
                        <td class="mobe_tit view order6">N</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="board_bottom">
            <x-pagination :paginator="$reports" />
        </div>
    </div>
</div>
@endsection
