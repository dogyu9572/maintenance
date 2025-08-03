<?php $gNum="main"; ?>
<?php include("pub/inc/_dtd.php") ?>
<?php include("pub/inc/_header.php") ?>

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
			<a href="/page/maintenance_requests.php" class="btn"><span class="mo_vw">유지보수 </span>요청하기</a>
		</div>
		<div class="client_area">
			<div class="name">한국심초음파학회</div>
			<dl class="period">
				<dt>유지보수 기간</dt>
				<dd>2024.06.28~2025.06.27</dd>
			</dl>
			<div class="link">
				<a href="#this">홈페이지</a>
				<a href="/main_adm.php">관리자</a>
			</div>
		</div>
		<div class="human_wrap mo_con mo_con02">
			<div class="tit">담당자 정보 <a href="javascript:void(0);" class="setting btn_setting">설정</a></div>
			<div class="human_list">
				<div class="point basic"></div>
				<div class="box boss">
					<div class="name"><i></i><strong>강심장</strong>국장<span>대표</span></div>
					<ul>
						<li class="tel">010-1234-5678</li>
						<li class="email">heart@gmail.com</li>
					</ul>
				</div>
				<div class="box">
					<div class="name"><i></i><strong>박은지</strong>대리</div>
					<ul>
						<li class="tel">010-1346-4812</li>
						<li class="email">eunji@gmail.com</li>
					</ul>
				</div>
				<div class="box">
					<div class="name"><i></i><strong>김지혜</strong>주임</div>
					<ul>
						<li class="tel">010-8875-5512</li>
						<li class="email">kimjh@gmail.com</li>
					</ul>
				</div>
				<div class="box">
					<div class="name"><i></i><strong>김지혜</strong>주임</div>
					<ul>
						<li class="tel">010-8875-5512</li>
						<li class="email">kimjh@gmail.com</li>
					</ul>
				</div>
				<div class="box">
					<div class="name"><i></i><strong>김지혜</strong>주임</div>
					<ul>
						<li class="tel">010-8875-5512</li>
						<li class="email">kimjh@gmail.com</li>
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
							<tr>
								<td class="num">10</td>
								<td class="state_box"><span class="state i1">접수</span></td>
								<td class="type">콘텐츠 수정</td>
								<td class="tt"><a href="/page/maintenance_requests_view.php">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
								<td class="mobe_tit writer">강심장</td>
								<td class="mobe_tit manager"></td>
								<td class="mobe_tit date_in">2024.07.11</td>
								<td class="mobe_tit date_end"></td>
							</tr>
							<tr>
								<td class="num">9</td>
								<td class="state_box"><span class="state i4">진행중</span></td>
								<td class="type">메일, 뉴스레터 발송</td>
								<td class="tt"><a href="/page/maintenance_requests_view.php">제15회 DAWAS 뉴스레터 발송의 건</a></td>
								<td class="mobe_tit writer">박은지</td>
								<td class="mobe_tit manager">오유림</td>
								<td class="mobe_tit date_in">2024.07.11</td>
								<td class="mobe_tit date_end"></td>
							</tr>
							<tr>
								<td class="num">8</td>
								<td class="state_box"><span class="state i2">공수확인요청</span></td>
								<td class="type">오류발생</td>
								<td class="tt"><a href="/page/maintenance_requests_view.php">심초음파학회 오류</a></td>
								<td class="mobe_tit writer">박은지</td>
								<td class="mobe_tit manager">오유림</td>
								<td class="mobe_tit date_in">2024.07.11</td>
								<td class="mobe_tit date_end"></td>
							</tr>
							<tr>
								<td class="num">7</td>
								<td class="state_box"><span class="state i3">공수확인완료</span></td>
								<td class="type">SSL(보안인증서)</td>
								<td class="tt"><a href="/page/maintenance_requests_view.php">휴대폰으로 사이트 접속 시 오류 확인 요청 건</a></td>
								<td class="mobe_tit writer">김지혜</td>
								<td class="mobe_tit manager">오유림</td>
								<td class="mobe_tit date_in">2024.07.11</td>
								<td class="mobe_tit date_end"></td>
							</tr>
							<tr>
								<td class="num">6</td>
								<td class="state_box"><span class="state i5">재요청</span></td>
								<td class="type">콘텐츠 수정</td>
								<td class="tt"><a href="/page/maintenance_requests_view.php">재활용의무이행 실적 변경사항 송부</a></td>
								<td class="mobe_tit writer">김지혜</td>
								<td class="mobe_tit manager">오유림</td>
								<td class="mobe_tit date_in">2024.07.11</td>
								<td class="mobe_tit date_end"></td>
							</tr>
							<tr>
								<td class="num">5</td>
								<td class="state_box"><span class="state i6">작업완료</span></td>
								<td class="type">콘텐츠 수정</td>
								<td class="tt"><a href="/page/maintenance_requests_view.php">자사몰 구매제한 추가 관련</a></td>
								<td class="mobe_tit writer">김지혜</td>
								<td class="mobe_tit manager">오유림</td>
								<td class="mobe_tit date_in">2024.07.11</td>
								<td class="mobe_tit date_end">2024.07.11</td>
							</tr>
							<tr>
								<td class="num">4</td>
								<td class="state_box"><span class="state i4">진행중</span></td>
								<td class="type">콘텐츠 수정</td>
								<td class="tt"><a href="/page/maintenance_requests_view.php">관리자 페이지 기능 문의</a></td>
								<td class="mobe_tit writer">김지혜</td>
								<td class="mobe_tit manager">오유림</td>
								<td class="mobe_tit date_in">2024.07.11</td>
								<td class="mobe_tit date_end">2024.07.11</td>
							</tr>
							<tr>
								<td class="num">3</td>
								<td class="state_box"><span class="state i6">작업완료</span></td>
								<td class="type">콘텐츠 수정</td>
								<td class="tt"><a href="/page/maintenance_requests_view.php">틴매일경제 홈페이지 수정사항 요청의 건</a></td>
								<td class="mobe_tit writer">김지혜</td>
								<td class="mobe_tit manager">오유림</td>
								<td class="mobe_tit date_in">2024.07.11</td>
								<td class="mobe_tit date_end">2024.07.11</td>
							</tr>
							<tr>
								<td class="num">2</td>
								<td class="state_box"><span class="state i6">작업완료</span></td>
								<td class="type">콘텐츠 수정</td>
								<td class="tt"><a href="/page/maintenance_requests_view.php">자사몰 구매제한 추가 관련</a></td>
								<td class="mobe_tit writer">서은정</td>
								<td class="mobe_tit manager">오유림</td>
								<td class="mobe_tit date_in">2024.07.11</td>
								<td class="mobe_tit date_end">2024.07.11</td>
							</tr>
							<tr>
								<td class="num">1</td>
								<td class="state_box"><span class="state i6">작업완료</span></td>
								<td class="type">콘텐츠 수정</td>
								<td class="tt"><a href="/page/maintenance_requests_view.php">제15회 DAWAS 뉴스레터 발송의 건</a></td>
								<td class="mobe_tit writer">서은정</td>
								<td class="mobe_tit manager">오유림</td>
								<td class="mobe_tit date_in">2024.07.11</td>
								<td class="mobe_tit date_end">2024.07.11</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="statistics_wrap mo_con mo_con03">
				<div class="stit mt">작업 통계
					<div class="month_area">
						<button class="btn prev">이전달</button>
						<div class="to">2024.05</div>
						<button class="btn next">다음달</button>
					</div>
				</div>
				<div class="statistics_area">
					<div class="box total"><div class="tt">총 작업요청(건)</div><strong>120</strong></div>
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
			<div class="wbox board2 mo_con mo_con04">
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

<?php include("pub/inc/_footer.php") ?>