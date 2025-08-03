@extends('layouts.app')

@section('content')
<div id="mainContent" class="container main_wrap">

	<div class="mo_tab_menu mo_vw">
		<a href="javascript:void(0);" class="tab01 on">요청현황</a>
		<a href="javascript:void(0);" class="tab02">담당자 정보</a>
		<a href="javascript:void(0);" class="tab03">작업통계</a>
		<a href="javascript:void(0);" class="tab04">공지사항</a>
	</div>

	<div class="info_area">
		<div class="btn_opcl">
			<button type="button" class="btn_open">열기</button>
			<button type="button" class="btn_close">닫기</button>
		</div>
		<div class="contact">
			<div class="tt">유지보수를 <br>요청하고 싶으신가요?</div>
			<a href="{{ route('maintenance.requests.create') }}" class="btn"><span class="mo_vw">유지보수 </span>요청하기</a>
		</div>
		<div class="client_area">
			<div class="name">한국심초음파학회</div>
			<dl class="period">
				<dt>유지보수 기간</dt>
				<dd>2024.06.28~2025.06.27</dd>
			</dl>
			<div class="link">
				<a href="{{ route('home') }}">사용자 페이지</a>
				<a href="{{ route('admin.dashboard') }}">관리자 페이지</a>
			</div>
		</div>
		<div class="human_wrap mo_con mo_con02">
			<div class="tit">담당자 정보 <a href="javascript:void(0);" class="setting btn_setting">설정</a></div>
			<div class="human_list">
				<div class="point basic"></div>
				<div class="box boss">
					<div class="name"><i></i><strong>{{ auth()->user()->name }}</strong>{{ auth()->user()->position }}<span>관리자</span></div>
					<ul>
						<li class="tel">010-1234-5678</li>
						<li class="email">{{ auth()->user()->email }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- //좌측 인포 -->

	<div class="dashboard_wrap">
		<div class="list_wrap">
			<div class="wbox list_area mo_con mo_con01 on">
				<div class="mo_state_wrap">
					<button class="btn_select mo_vw">전체요청 <strong>{{ $allRequests->count() }}</strong></button>
					<div class="state_area">
						<a href="javascript:void(0);" class="btn on">전체요청 <strong>{{ $allRequests->count() }}</strong></a>
						@foreach($statusStats as $status)
						<a href="javascript:void(0);" class="btn">{{ $status->name }}<strong>{{ $status->maintenance_requests_count }}</strong></a>
						@endforeach
					</div>
				</div>
				<div class="list">
					<table>
						<colgroup>
							<col class="w6"></col>
							<col class="w12"></col>
							<col class="w15"></col>
							<col width="*"></col>
							<col class="w10"></col>
							<col class="w10"></col>
							<col class="w13"></col>
							<col class="w13"></col>
						</colgroup>
						<thead>
							<tr>
								<th>No.</th>
								<th>상태</th>
								<th>유지보수 종류</th>
								<th>제목</th>
								<th>작성자</th>
								<th>담당자</th>
								<th>접수일</th>
								<th>완료일</th>
							</tr>
						</thead>
						<tbody>
							@foreach($allRequests as $request)
							<tr>
								<td class="num">{{ $request->idx }}</td>
								<td class="state_box"><span class="state i{{ $request->status->id }}">{{ $request->status->name }}</span></td>
								<td class="type">{{ $request->maintenanceType->name ?? '기타' }}</td>
								<td class="tt"><a href="{{ route('maintenance.requests.show', $request->idx) }}">{{ $request->title }}</a></td>
								<td class="mobe_tit writer">{{ $request->user->name ?? '-' }}</td>
								<td class="mobe_tit manager">{{ $request->manager->name ?? '-' }}</td>
								<td class="mobe_tit date_in">{{ $request->created_at->format('Y.m.d') }}</td>
								<td class="mobe_tit date_end">{{ $request->completed_at ? $request->completed_at->format('Y.m.d') : '' }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<div class="statistics_wrap mo_con mo_con03">
				<div class="stit mt">작업 통계
					<div class="month_area">
						<button class="btn prev">이전달</button>
						<div class="to">{{ now()->format('Y.m') }}</div>
						<button class="btn next">다음달</button>
					</div>
				</div>
				<div class="statistics_area">
					<div class="box total"><div class="tt">총 작업요청(건)</div><strong>{{ $allRequests->count() }}</strong></div>
					<div class="box cbox i1">
						<div class="tt">운영공수(h)</div>
						<div class="list">
							<dl>
								<dt>PM/기획</dt>
								<dd>0.1</dd>
							</dl>
							<dl>
								<dt>디자인</dt>
								<dd>0.3</dd>
							</dl>
							<dl>
								<dt>퍼블리싱</dt>
								<dd>1.2</dd>
							</dl>
							<dl>
								<dt>개발</dt>
								<dd>1.2</dd>
							</dl>
						</div>
					</div>
					<div class="box cbox i2">
						<div class="tt">잔여공수(h)</div>
						<div class="list">
							<dl>
								<dt>PM/기획</dt>
								<dd>0.1</dd>
							</dl>
							<dl>
								<dt>디자인</dt>
								<dd>0.3</dd>
							</dl>
							<dl>
								<dt>퍼블리싱</dt>
								<dd>1.2</dd>
							</dl>
							<dl>
								<dt>개발</dt>
								<dd>1.2</dd>
							</dl>
						</div>
					</div>
					<div class="box cbox i3">
						<div class="tt">계약공수(h)</div>
						<div class="list">
							<dl>
								<dt>PM/기획</dt>
								<dd>0.1</dd>
							</dl>
							<dl>
								<dt>디자인</dt>
								<dd>0.3</dd>
							</dl>
							<dl>
								<dt>퍼블리싱</dt>
								<dd>1.2</dd>
							</dl>
							<dl>
								<dt>개발</dt>
								<dd>1.2</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="notice_wrap">
			<div class="wbox board1">
				<div class="stit">알림내역 <a href="#notifications" class="more">더보기</a></div>
				<div class="list">
					<a href="#this">
						<p>YYYY-MM-DD에 {허지선}님이 요청주신 내역이 접수되었습니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
					<a href="#this">
						<p>YYYY-MM-DD에 {허지선}님이 요청주신 내역이 접수되었습니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
					<a href="#this">
						<p>YYYY-MM-DD에 {허지선}님이 요청주신 내역이 접수되었습니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
				</div>
			</div>
			<div class="wbox board2 mo_con mo_con04">
				<div class="stit">공지사항 <a href="#notices" class="more">더보기</a></div>
				<div class="list">
					<a href="#this">
						<p>홈페이지코리아 설날휴무 입니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
					<a href="#this">
						<p>홈페이지코리아 설날휴무 입니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
					<a href="#this">
						<p>홈페이지코리아 설날휴무 입니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
// Moblie
$(document).ready(function () {
// Tab
	$(".mo_tab_menu a").click(function () {
		const tabIndex = $(this).attr('class').match(/tab(\d+)/)[1];
		$(this).addClass("on").siblings().removeClass("on");
		$(".mo_con").removeClass("on")
		$(".mo_con" + tabIndex).addClass("on");
	});
// 요청현황 select
    $(".mo_state_wrap .btn_select").click(function(){
		$(".mo_state_wrap").stop(false,true).toggleClass("on");
	});
    $(".mo_state_wrap .state_area .btn").click(function(){
		$(".mo_state_wrap").removeClass("on");
	});
    $('.state_area .btn').on('click', function () {
        const $this = $(this);
        const newContent = $this.html();
        $('.btn_select').html(newContent);
        $('.state_area .btn').removeClass('on');
        $this.addClass('on');
    });
	$(window).scroll(function () {
		if ($(window).scrollTop() > $('#point_foot').offset().top) {
			$('.main_wrap').addClass("unfixed");
		} else {
			$('.main_wrap').removeClass("unfixed");
		}
	});
});
</script>
@endsection
