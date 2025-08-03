@extends('layouts.app')

@section('title', '관리자 계정 관리')

@section('content')
<div id="mainContent" class="container sub_wrap account_wrap">
    <div class="inner">
        <div class="title">계정 관리
            <a href="{{ route('admin.accounts.create') }}" class="btn_write btn_ann">계정생성</a>
        </div>

        <div class="tabs">
            <a href="{{ route('admin.accounts.index') }}">일반</a>
            <a href="{{ route('admin.accounts.admins') }}" class="on">관리자</a>
        </div>

        <div class="board_top">
            <div class="total">총 <strong class="col_blue">{{ $totalCount }}</strong>개의 게시글</div>
            <div class="inputs">
                <form method="GET" action="{{ route('admin.accounts.admins') }}" class="search-form">
                    <div class="datepicker_area">
                        <input type="text" class="text datepicker datepicker_start" name="start_date" value="{{ request('start_date') }}" placeholder="시작일">
                    </div>
                    <span class="bar"></span>
                    <div class="datepicker_area">
                        <input type="text" class="text datepicker datepicker_end" name="end_date" value="{{ request('end_date') }}" placeholder="종료일">
                    </div>
                    <input type="text" class="text input" name="search" placeholder="관리자 이름, 아이디로 검색" value="{{ request('search') }}">
                    <button type="submit" class="btn">조회</button>
                    <select name="per_page" class="text ml2 mo_w100p">
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
                        <td class="mobe_tit type1 order3">{{ $account->account_type == 'new' ? '신규' : '기존' }}</td>
                        <td class="mobe_tit type2 order4">{{ $account->client ? ($account->client->client_type == 'company' ? '병원' : ($account->client->client_type == 'association' ? '협회' : '개인')) : '-' }}</td>
                        <td class="mobe_tit customer order5">{{ $account->client->name ?? '-' }}</td>
                        <td class="mobe_tit id order6">{{ $account->login_id ?? 'admin' }}</td>
                        <td class="mobe_tit contract order7 mo_w100p">
                            {{ $account->contract_start ?? '-' }}~{{ $account->contract_end ?? '-' }}
                        </td>
                        <td class="mobe_tit person order8">{{ $account->name ?? '관리자' }}</td>
                        <td class="mobe_tit position order9">{{ $account->position ?? '-' }}</td>
                        <td class="mobe_tit phone order10">{{ $account->phone ?? '-' }}</td>
                        <td class="mobe_tit mail order11">{{ $account->email ?? 'admin@example.com' }}</td>
                        <td class="mobe_tit creation order12">{{ $account->created_at ? $account->created_at->format('Y.m.d') : '-' }}</td>
                        <td class="mobe_tit used order13">{{ $account->is_active ? 'Y' : 'N' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="tac">등록된 관리자 계정이 없습니다.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="board_bottom">
            <div class="btns_tal">
                <button type="button" class="btn" id="deleteSelected">삭제</button>
            </div>
            <x-pagination :paginator="$accounts" />
        </div>
    </div>
</div>

<script src="/pub/js/jquery-ui.js"></script>
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
        buttonImage: "/pub/images/icon_month.svg",
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
