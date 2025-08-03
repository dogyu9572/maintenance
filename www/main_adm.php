<?php $type="adm"; $gNum="main"; ?>
<?php include("pub/inc/_dtd.php") ?>
<?php include("pub/inc/_header.php") ?>

<div id="mainContent" class="container main_wrap">

	<div class="admin_info mo_vw">
		<span>관리자</span>
		<div class="name">오유림님 안녕하세요</div>
	</div>

	<div class="mo_tab_menu mo_vw">
		<a href="javascript:void(0);" class="tab01 on">요청현황</a>
		<a href="javascript:void(0);" class="tab02">고객사 목록</a>
		<a href="javascript:void(0);" class="tab03">공지사항</a>
	</div>

	<div class="info_area">
		<div class="btn_opcl">
			<button type="button" class="btn_open">열기</button>
			<button type="button" class="btn_close">닫기</button>
		</div>
		<div class="admin_wrap mo_con mo_con02">
			<div class="tit mt0">고객사 목록(200)</div>
			<div class="search_area">
				<input type="text" class="text" placeholder="고객사명 검색">
				<button type="button" class="btn">검색</button>
			</div>
			<div class="client_list">
				<a href="#this">강동성심병원<span>(1)</span></a>
				<a href="#this">고대발전기금<span>(1)</span></a>
				<a href="#this">교보자산신탁<span>(1)</span></a>
				<a href="#this">김천의료원<span>(1)</span></a>
				<a href="#this">대한고혈압학회<span>(1)</span></a>
				<a href="#this">대한안과의사회<span>(1)</span></a>
				<a href="#this">더테이스터블<span>(1)</span></a>
				<a href="#this">도원스타일<span>(1)</span></a>
				<a href="#this">서울통합건강증진사업지원단<span>(1)</span></a>
				<a href="#this">성의교정<span>(1)</span></a>
				<a href="#this">수풍석박물관<span>(1)</span></a>
				<a href="#this">숭실대글로벌미래교육원<span>(1)</span></a>
				<a href="#this">시도지사협의회<span>(1)</span></a>
				<a href="#this">심부전학회<span>(1)</span></a>
				<a href="#this">심초음파학회<span>(1)</span></a>
				<a href="#this">아셈<span>(1)</span></a>
				<a href="#this">여성기업종합정보포털<span>(1)</span></a>
				<a href="#this">유엔거버넌스센터<span>(1)</span></a>
				<a href="#this">유통물가<span>(1)</span></a>
				<a href="#this">이화의원<span>(1)</span></a>
				<a href="#this">인천감염병관리지원단<span>(1)</span></a>
				<a href="#this">장원의료재단<span>(1)</span></a>
			</div>
		</div>
	</div>
	<!-- //좌측 인포 -->

	<div class="dashboard_wrap admin_set">
		<div class="list_wrap">
			<div class="wbox list_area mo_con mo_con01 on">
				<div class="mo_state_wrap">
					<button class="btn_select mo_vw">전체요청 <strong>9</strong></button>
					<div class="state_area">
						<a href="javascript:void(0);" class="btn on">전체요청 <strong>9</strong></a>
						<a href="javascript:void(0);" class="btn">접수<strong>4</strong></a>
						<a href="javascript:void(0);" class="btn">공수확인요청<strong>2</strong></a>
						<a href="javascript:void(0);" class="btn">공수확인완료<strong>1</strong></a>
						<a href="javascript:void(0);" class="btn">진행중<strong>1</strong></a>
						<a href="javascript:void(0);" class="btn">재요청<strong>1</strong></a>
					</div>
				</div>
				<div class="list">
					<table>
						<colgroup>
							<col class="w7">
							<col class="w10">
							<col class="w13">
							<col class="w14">
							<col width="*">
							<col class="w10">
							<col class="w10">
							<col class="w7">
							<col class="w11">
							<col class="w6">
						</colgroup>
						<thead>
							<tr>
								<th>No.</th>
								<th>상태</th>
								<th>고객사명</th>
								<th>유지보수 종류</th>
								<th>제목</th>
								<th>접수일</th>
								<th>처리예정일</th>
								<th>담당자</th>
								<th>작업자</th>
								<th>비고</th>
							</tr>
						</thead>
					</table>
					<div class="scroll">
						<table>
							<colgroup>
								<col class="w7">
								<col class="w10">
								<col class="w13">
								<col class="w14">
								<col width="*">
								<col class="w10">
								<col class="w10">
								<col class="w7">
								<col class="w11">
								<col class="w6">
							</colgroup>
							<tbody>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i1">접수</span></td>
									<td class="mobe_tit customer">서울통합건강증진센터</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i4">진행중</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i2">공수확인요청</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i3">공수확인완료</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i5">재요청</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i1">접수</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i4">진행중</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i2">공수확인요청</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i3">공수확인완료</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i5">재요청</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i1">접수</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i4">진행중</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i2">공수확인요청</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i3">공수확인완료</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
								<tr>
									<td class="num">99999</td>
									<td class="statebox"><span class="state i5">재요청</span></td>
									<td class="mobe_tit customer">강동성심병원</td>
									<td class="type">콘텐츠 수정</td>
									<td class="tt"><a href="#this">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
									<td class="mobe_tit date_recep">2024.07.11</td>
									<td class="mobe_tit date_sched">2024.07.11</td>
									<td class="mobe_tit manager">오유림</td>
									<td class="mobe_tit worker">지현수,오유림</td>
									<td class="note"><a href="/page_adm/pop_note.php" class="btn_note fancybox fancybox.ajax">보기</a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="notice_wrap">
			<div class="wbox board1">
				<div class="stit">알림내역 <a href="/page/notifications.php" class="more">더보기</a></div>
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
			<div class="wbox board2 mo_con mo_con03">
				<div class="stit">공지사항 <a href="/page/notices.php" class="more">더보기</a></div>
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

		<div class="popup pop_work_statistics">
			<div class="dm"></div>
			<div class="inbox">
				<a href="javascript:void(0);" class="btn_close">닫기</a>
				<div class="tit">교보자산신탁 작업통계</div>
				<div class="con">
					<dl class="date">
						<dt>계약기간</dt>
						<dd>2024.01.11~2025.01.11</dd>
					</dl>
					<div class="stit">
						<div class="month_area">
							<button class="btn prev">이전달</button>
							<div class="to">2024.05</div>
							<button class="btn next">다음달</button>
						</div>
					</div>
					<dl class="total">
						<dt>총 작업요청(건)</dt>
						<dd>24</dd>
					</dl>
					<div class="ptit">계약공수(h)</div>
					<table>
						<tbody>
							<tr>
								<th>PM,기획</th>
								<td>10</td>
							</tr>
							<tr>
								<th>디자인</th>
								<td>10</td>
							</tr>
							<tr>
								<th>퍼블리싱</th>
								<td>10</td>
							</tr>
							<tr>
								<th>개발</th>
								<td>10</td>
							</tr>
						</tbody>
					</table>
					<div class="ptit">운영공수(h)</div>
					<table>
						<tbody>
							<tr>
								<th>PM,기획</th>
								<td>10</td>
							</tr>
							<tr>
								<th>디자인</th>
								<td>10</td>
							</tr>
							<tr>
								<th>퍼블리싱</th>
								<td>10</td>
							</tr>
							<tr>
								<th>개발</th>
								<td>10</td>
							</tr>
						</tbody>
					</table>
					<div class="ptit">잔여공수(h)</div>
					<table>
						<tbody>
							<tr>
								<th>PM,기획</th>
								<td>10</td>
							</tr>
							<tr>
								<th>디자인</th>
								<td>10</td>
							</tr>
							<tr>
								<th>퍼블리싱</th>
								<td>10</td>
							</tr>
							<tr>
								<th>개발</th>
								<td>10</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
$(document).ready(function () {
	$(".main_wrap .client_list a").click(function(){
		$(".pop_work_statistics").fadeIn("fast");
	});
// Moblie
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

<?php include("pub/inc/_footer.php") ?>