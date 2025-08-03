@extends('layouts.app')

@section('title', '월간보고서')

@section('content')
<div id="mainContent" class="container sub_wrap maintenance_requests_wrap">
    <div class="inner">
        <div class="title">월간보고서</div>

        <ul class="monthly_reports_top">
            <li>
                <span>01</span>
                <p><strong>월간보고서 등록일</strong>은 매월 다를 수 있습니다.<br>월간보고서 등록 시 대표 담당자 메일 및 알림내역에 표시됩니다.</p>
                <img src="{{ asset('images/img_monthly_reports01.png') }}" alt="image">
            </li>
            <li>
                <span>02</span>
                <p><strong>PDF 다운로드</strong>는 출력창에서 PDF로 <br class="pc_vw">저장을 선택하여 다운로드 가능합니다</p>
                <img src="{{ asset('images/img_monthly_reports02.png') }}" alt="image">
            </li>
        </ul>

        <div class="board_top">
            <div class="total">총 <strong class="col_blue">{{ $totalCount ?? 3243 }}</strong>개의 게시글</div>
        </div>

        <div class="board_list">
            <table>
                <colgroup>
                    <col class="w6">
                    <col class="w10">
                    <col class="w6">
                    <col width="*">
                    <col class="w22">
                    <col class="w10">
                    <col class="w12">
                    <col class="w12">
                </colgroup>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>연</th>
                        <th>월</th>
                        <th>제목</th>
                        <th>업무기간</th>
                        <th>담당자</th>
                        <th>등록일</th>
                        <th>출력/다운로드</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports ?? [] as $report)
                    <tr>
                        <td class="num">{{ $report->idx }}</td>
                        <td class="mobe_tit year">{{ $report->year }}</td>
                        <td class="mobe_tit month">{{ $report->month }}</td>
                        <td class="tt">{{ $report->title }}</td>
                        <td class="mobe_tit dates">{{ $report->work_period }}</td>
                        <td class="mobe_tit name">{{ $report->manager_name }}</td>
                        <td class="mobe_tit date">{{ $report->created_at->format('Y.m.d') }}</td>
                        <td class="print">
                            <a href="{{ route('monthly-reports.print', $report->idx) }}" target="_blank" class="btn_print">출력</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">등록된 월간보고서가 없습니다.</td>
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
