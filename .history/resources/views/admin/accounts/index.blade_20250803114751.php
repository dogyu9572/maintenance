@extends('layouts.app')

@section('title', '계정 관리')

@section('content')
<div id="mainContent" class="container sub_wrap account_wrap">
    <div class="inner">
        <div class="title">계정 관리
            <a href="{{ route('admin.accounts.create') }}" class="btn_write btn_ann">계정생성</a>
        </div>

        <div class="tabs">
            <a href="{{ route('admin.accounts.index') }}" class="on">일반</a>
            <a href="{{ route('admin.accounts.admins') }}">관리자</a>
        </div>

        <div class="board_top">
            <div class="total">총 <strong class="col_blue">{{ $totalCount }}</strong>개의 게시글</div>
           
        </div>

        <div class="board_list chk_board">
            <table>
                <colgroup>
                    <col class="w4">
                    <col class="w6">
                    <col class="w5">
                    <col class="w5">
                    <col class="w11">
                    <col class="w10">
                    <col width="*">
                    <col class="w9">
                    <col class="w8">
                    <col class="w13">
                    <col class="w13">
                    <col class="w10">
                    <col class="w7">
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
                        <th>유형</th>
                        <th>타입</th>
                        <th>고객사명</th>
                        <th>아이디</th>
                        <th>계약기간</th>
                        <th>대표 담당자</th>
                        <th>직위/직급</th>
                        <th>담당자 휴대폰</th>
                        <th>담당자 이메일</th>
                        <th>생성일</th>
                        <th>사용여부</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                    <tr>
                        <td class="chk order1">
                            <label class="check solo">
                                <input type="checkbox" name="check" value="{{ $account->idx }}">
                                <i></i>
                            </label>
                        </td>
                        <td class="num_view order2">{{ $account->idx }}</td>
                        <td class="mobe_tit type1 order3">{{ $account->type ?? '신규' }}</td>
                        <td class="mobe_tit type2 order4">{{ $account->client->type ?? '병원' }}</td>
                        <td class="mobe_tit customer order5">{{ $account->client->name ?? '강동성심병원' }}</td>
                        <td class="mobe_tit id order6">{{ $account->login_id ?? 'djgslkdjg13' }}</td>
                        <td class="mobe_tit contract order7 mo_w100p">
                            {{ $account->contract_start ?? '2024.07.18' }}~{{ $account->contract_end ?? '2024.12.05' }}
                        </td>
                        <td class="mobe_tit person order8">{{ $account->name ?? '허지선' }}</td>
                        <td class="mobe_tit position order9">{{ $account->position ?? '국장' }}</td>
                        <td class="mobe_tit phone order10">{{ $account->phone ?? '02-1234-5678' }}</td>
                        <td class="mobe_tit mail order11">{{ $account->email ?? 'test@gmail.com' }}</td>
                        <td class="mobe_tit creation order12">{{ $account->created_at ? $account->created_at->format('Y.m.d') : '2024.07.18' }}</td>
                        <td class="mobe_tit used order13">{{ $account->is_active ? 'Y' : 'N' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="tac">등록된 계정이 없습니다.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="board_bottom">
            <div class="btns_tal">
                <button type="button" class="btn" id="deleteSelected">삭제</button>
            </div>
            <div class="paging mt1">
                @if($accounts->hasPages())
                    @if($accounts->onFirstPage())
                        <span class="arrow one first">맨끝</span>
                        <span class="arrow two prev">이전</span>
                    @else
                        <a href="{{ $accounts->url(1) }}" class="arrow one first">맨끝</a>
                        <a href="{{ $accounts->previousPageUrl() }}" class="arrow two prev">이전</a>
                    @endif

                    @foreach($accounts->getUrlRange(max(1, $accounts->currentPage() - 2), min($accounts->lastPage(), $accounts->currentPage() + 2)) as $page => $url)
                        @if($page == $accounts->currentPage())
                            <span class="on">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($accounts->hasMorePages())
                        <a href="{{ $accounts->nextPageUrl() }}" class="arrow two next">다음</a>
                        <a href="{{ $accounts->url($accounts->lastPage()) }}" class="arrow one last">맨끝</a>
                    @else
                        <span class="arrow two next">다음</span>
                        <span class="arrow one last">맨끝</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
    // datepicker
    var today = new Date();
    var sixMonthsAgo = new Date();
    sixMonthsAgo.setMonth(today.getMonth() - 6);

    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        showMonthAfterYear: true,
        showOn: "both",
        buttonImage: "{{ asset('images/icon_month.svg') }}",
        buttonImageOnly: true,
        changeYear: true,
        changeMonth: true,
        yearRange: 'c-100:c+10',
        yearSuffix: "년 ",
        monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
        dayNamesMin: ['일','월','화','수','목','금','토']
    });

    if (!$(".datepicker_start").val()) {
        $(".datepicker_start").datepicker("setDate", sixMonthsAgo);
    }
    if (!$(".datepicker_end").val()) {
        $(".datepicker_end").datepicker("setDate", today);
    }

    // 체크박스
    var $allCheck = $('#allCheck');
    $allCheck.change(function () {
        var $this = $(this);
        var checked = $this.prop('checked');
        $('input[name="check"]').prop('checked', checked);
    });

    var boxes = $('input[name="check"]');
    boxes.change(function () {
        var boxLength = boxes.length;
        var checkedLength = $('input[name="check"]:checked').length;
        var selectallCheck = (boxLength == checkedLength);
        $allCheck.prop('checked', selectallCheck);
    });

    // 삭제 기능
    $('#deleteSelected').click(function() {
        var selectedIds = [];
        $('input[name="check"]:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            alert('삭제할 항목을 선택해주세요.');
            return;
        }

        if (confirm('선택한 항목을 삭제하시겠습니까?')) {
            $.ajax({
                url: '{{ route("admin.accounts.bulk-delete") }}',
                method: 'POST',
                data: {
                    ids: selectedIds,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('삭제 중 오류가 발생했습니다.');
                    }
                },
                error: function() {
                    alert('삭제 중 오류가 발생했습니다.');
                }
            });
        }
    });
});
</script>
@endsection
