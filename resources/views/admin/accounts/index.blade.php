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

        <form method="GET" action="{{ route('admin.accounts.index') }}">
            <div class="board_top">
                <div class="total">총 <strong class="col_blue">{{ $totalCount }}</strong>개의 게시글</div>
                <div class="inputs">
                    <div class="datepicker_area"><input type="text" class="text datepicker datepicker_start" name="start_date" value="{{ request('start_date') }}" placeholder="시작일"></div>
                    <span class="bar"></span>
                    <div class="datepicker_area"><input type="text" class="text datepicker datepicker_end" name="end_date" value="{{ request('end_date') }}" placeholder="종료일"></div>
                    <input type="text" class="text input" name="search" placeholder="고객사명, 대표 담당자 이름으로 검색" value="{{ request('search') }}">
                    <button type="submit" class="btn">조회</button>
                    <select name="per_page" class="text ml2 mo_w100p" onchange="this.form.submit()">
                        <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20개씩 보기</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50개씩 보기</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100개씩 보기</option>
                    </select>
                </div>
            </div>
        </form>

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
                        <td class="num_view order2">{{ $totalCount - (($accounts->currentPage() - 1) * $accounts->perPage() + $loop->index) }}</td>
                        <td class="mobe_tit type1 order3">{{ $account->account_type_text }}</td>
                        <td class="mobe_tit type2 order4">{{ $account->client_type_text }}</td>
                        <td class="mobe_tit customer order5">{{ $account->name ?? '' }}</td>
                        <td class="mobe_tit id order6">{{ $account->login_id ?? '' }}</td>
                        <td class="mobe_tit contract order7 mo_w100p">{{ $account->contract_period_text }}</td>
                        <td class="mobe_tit person order8">{{ $account->manager_name ?? '' }}</td>
                        <td class="mobe_tit position order9">{{ $account->manager_position ?? '' }}</td>
                        <td class="mobe_tit phone order10">{{ $account->manager_phone ?? '' }}</td>
                        <td class="mobe_tit mail order11">{{ $account->manager_email ?? '' }}</td>
                        <td class="mobe_tit creation order12">{{ $account->created_at_formatted }}</td>
                        <td class="mobe_tit used order13">{{ $account->status_text }}</td>
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
            <x-pagination :paginator="$accounts" />
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/admin/accounts.js') }}"></script>
@endpush
@endsection
