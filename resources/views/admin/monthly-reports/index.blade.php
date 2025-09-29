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
            <div class="total">총 <strong class="col_blue">{{ $reports->total() }}</strong>개의 게시글</div>
            <div class="inputs mo_flex_sqr">
                <form method="GET" action="{{ route('admin.monthly-reports.index') }}">
                    <select name="client_id" class="text mr" onchange="this.form.submit()">
                        <option value="">고객사명</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->idx }}" {{ request('client_id') == $client->idx ? 'selected' : '' }}>
                            {{ $client->name ?? '' }}
                        </option>
                        @endforeach
                    </select>
                    <select name="year" class="text mr" onchange="this.form.submit()">
                        <option value="">연</option>
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <select name="month" class="text mr" onchange="this.form.submit()">
                        <option value="">월</option>
                        @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endfor
                    </select>
                    <select name="per_page" class="text" onchange="this.form.submit()">
                        <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20개씩 보기</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50개씩 보기</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100개씩 보기</option>
                    </select>
                    {{-- <button type="button" class="btn btn_s" onclick="resetFilters()">초기화</button> --}}
                </form>
            </div>
        </div>

        <div class="board_list chk_board g02">
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
                    @forelse($reports as $report)
                    <tr>
                        <td class="chk order1">
                            <label class="check solo">
                                <input type="checkbox" name="check" value="{{ $report->idx }}">
                                <i></i>
                            </label>
                        </td>
                        <td class="tac num">{{ $reports->total() - (($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration - 1) }}</td>
                        <td class="mobe_tit year order2">{{ $report->year ?? '' }}</td>
                        <td class="mobe_tit customer order3">{{ $report->client->name ?? '' }}</td>
                        <td class="tt order4">
                            <a href="{{ route('admin.monthly-reports.show', $report->idx) }}">
                                {{ \Illuminate\Support\Str::limit($report->title ?? '', 80) }}
                            </a>
                        </td>
                        <td class="mobe_tit dates order5">
                            @if($report->work_start_date && $report->work_end_date)
                                {{ \Carbon\Carbon::parse($report->work_start_date)->format('Y.m.d') }}~{{ \Carbon\Carbon::parse($report->work_end_date)->format('Y.m.d') }}
                            @endif
                        </td>
                        <td class="mobe_tit name order6">{{ $report->user->name ?? '' }}</td>
                        <td class="mobe_tit report order7">{{ optional($report->created_at)->format('Y.m.d') }}</td>
                        <td class="print order8">
                            <a href="{{ route('admin.monthly-reports.print', $report->idx) }}" target="_blank" class="btn_print">출력</a>
                        </td>
                        <td class="mobe_tit view order9">{{ isset($report->is_published) ? ($report->is_published ? 'Y' : 'N') : '' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="tac">등록된 월간보고서가 없습니다.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="btn_tal">
                <button type="button" class="btn" id="deleteSelected">삭제</button>
                <button type="button" class="btn" id="publishSelected">노출 Y</button>
            </div>
        </div>

        <div class="board_bottom">
            <x-pagination :paginator="$reports" />
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('js/admin/monthly-reports.js') }}"></script>
<script>
function resetFilters() {
    // 모든 필터 값을 초기화
    document.querySelector('select[name="client_id"]').value = '';
    document.querySelector('select[name="year"]').value = '';
    document.querySelector('select[name="month"]').value = '';
    document.querySelector('select[name="per_page"]').value = '20';
    
    // 폼 제출
    document.querySelector('form').submit();
}
</script>
@endpush
@endsection
