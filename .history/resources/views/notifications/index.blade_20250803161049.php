@extends('layouts.app')

@section('title', '알림내역')

@section('content')
<div id="mainContent" class="container sub_wrap notices_wrap">
    <div class="inner">
        <div class="title">알림내역</div>

        <div class="board_top">
            <div class="total">총 <strong class="col_blue">{{ $totalCount ?? 3243 }}</strong>개의 게시글</div>
            <div class="inputs">
                <form method="GET" action="{{ route('notifications.index') }}">
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
                    <col class="w6">
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
                    @forelse($notifications ?? [] as $notification)
                    <tr>
                        <td class="num">{{ $notification->idx }}</td>
                        <td class="tt">
                            <a href="{{ route('notifications.show', $notification->idx) }}">
                                {{ Str::limit($notification->title, 80) }}
                            </a>
                        </td>
                        <td class="mobe_tit name">{{ $notification->user_name ?? '오유림' }}</td>
                        <td class="mobe_tit date">{{ $notification->created_at->format('Y.m.d') }}</td>
                        <td class="mobe_tit hit">{{ $notification->view_count ?? 1234 }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">등록된 알림이 없습니다.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="board_bottom">
            <x-pagination :paginator="$notifications" />
        </div>
    </div>
</div>

<div class="popup pop_state01">
    <div class="dm"></div>
    <div class="inbox">
        <a href="javascript:void(0);" class="btn_close">닫기</a>
        <div class="tit">처리과정(상태) 안내</div>
        <div class="state_step">
            <dl class="c1">
                <dt>접수</dt>
                <dd>요청이 접수되었습니다.<br>
                    요청내용 확인 및 공수파악 후 담당자가 배정됩니다.<br>
                    <p class="col_blue">* 금요일 오후 2시 이후 접수 건은 월요일부터 순차적으로 확인합니다.</p>
                </dd>
            </dl>
            <dl class="c1">
                <dt>진행중</dt>
                <dd>작업이 진행중입니다. 작업 진행 중 상태에서는 <br>
                    요청내용 수정이 불가능합니다.<br>
                    요청한 작업에 추가사항이 있을 경우, 댓글로 요청 부탁드립니다.
                </dd>
            </dl>
            <dl class="c1 none_arrow">
                <dt>작업완료</dt>
                <dd>작업이 완료되었습니다.</dd>
            </dl>
            <div class="bar"></div>
            <dl class="c2">
                <dt>재요청</dt>
                <dd>작업완료 후 요청한 작업에 누락이 있거나 제대로 진행되지 않은 경우, 작업을 재요청합니다.</dd>
            </dl>
            <dl class="c2 none_arrow">
                <dt>답변완료</dt>
                <dd>재요청한 작업이 완료되었습니다.</dd>
            </dl>
        </div>
    </div>
</div>

<div class="popup pop_state02">
    <div class="dm"></div>
    <div class="inbox">
        <a href="javascript:void(0);" class="btn_close">닫기</a>
        <div class="tit">처리과정(상태) 안내</div>
        <div class="state_step">
            <dl class="c1">
                <dt>접수</dt>
                <dd>요청이 접수되었습니다.<br>
                    요청내용 확인 및 공수파악 후 담당자가 배정됩니다.<br>
                    <p class="col_blue">* 금요일 오후 2시 이후 접수 건은 월요일부터 순차적으로 확인합니다.</p>
                </dd>
            </dl>
            <dl class="c1">
                <dt>공수 <br>확인요청</dt>
                <dd>담당자가 요청내용을 바탕으로 작업 공수를 파악했습니다.<br>
                    작업공수 확인 후 <i>공수확인완료</i>처리가 필요합니다.
                </dd>
            </dl>
            <dl class="c1">
                <dt>공수 <br>확인완료</dt>
                <dd>공수확인을 완료했습니다.<br>
                    담당자가 작업자에게 작업을 요청합니다.
                </dd>
            </dl>
            <dl class="c1">
                <dt>진행중</dt>
                <dd>작업이 진행중입니다. 작업 진행 중 상태에서는 <br>
                    요청내용 수정이 불가능합니다.<br>
                    요청한 작업에 추가사항이 있을 경우, 댓글로 요청 부탁드립니다.
                </dd>
            </dl>
            <dl class="c1 none_arrow">
                <dt>작업완료</dt>
                <dd>작업이 완료되었습니다.</dd>
            </dl>
            <div class="bar"></div>
            <dl class="c2">
                <dt>재요청</dt>
                <dd>작업완료 후 요청한 작업에 누락이 있거나 제대로 진행되지 않은 경우, 작업을 재요청합니다.</dd>
            </dl>
            <dl class="c2 none_arrow">
                <dt>답변완료</dt>
                <dd>재요청한 작업이 완료되었습니다.</dd>
            </dl>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
    //datepicker
    var today = new Date();
    var sixMonthsAgo = new Date();
    sixMonthsAgo.setMonth(today.getMonth() - 6);
    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        showMonthAfterYear:true,
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

    @if(!request('start_date'))
    $(".datepicker_start").datepicker("setDate", sixMonthsAgo);
    @endif
    @if(!request('end_date'))
    $(".datepicker_end").datepicker("setDate", today);
    @endif

    //popup
    $(".btn_state").click(function(){
        $(".pop_state01").fadeIn("fast");
    });
});
</script>
@endpush
@endsection
