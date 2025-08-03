<?php $gNum="01"; $gName="유지보수 요청"; ?>
<?php include("../pub/inc/_dtd.php") ?>
<?php include("../pub/inc/_header.php") ?>
<div id="mainContent" class="container sub_wrap maintenance_requests_wrap">

	<div class="inner">
		<div class="title"><?=$gName?> <a href="/page/maintenance_requests_write.php" class="btn_write">유지보수 요청하기</a></div>

		<div class="btit">처리현황 <a href="javascript:void(0);" class="btn_state btn_state01">처리현황(과정)안내</a></div> <!-- 공수 확인 요청이 체크된 경우 pop_state02가 열려야 합니다. - 버튼명 btn_state02로 변경 -->
		<div class="state_area">
			<a href="javascript:void(0);" class="btn on">전체요청 <strong>9</strong></a>
			<a href="javascript:void(0);" class="btn">접수<strong>4</strong></a>
			<a href="javascript:void(0);" class="btn">공수확인요청<strong>2</strong></a>
			<a href="javascript:void(0);" class="btn">공수확인완료<strong>1</strong></a>
			<a href="javascript:void(0);" class="btn">진행중<strong>1</strong></a>
			<a href="javascript:void(0);" class="btn">재요청<strong>1</strong></a>
		</div>

		<div class="board_top">
			<div class="total">총 <strong class="col_blue">3243</strong>개의 게시글</div>
			<div class="inputs">
				<div class="datepicker_area"><input type="text" class="text datepicker datepicker_start"></div>
				<span class="bar"></span>
				<div class="datepicker_area"><input type="text" class="text datepicker datepicker_end"></div>
				<input type="text" class="text input" placeholder="제목, 작성자로 검색이 가능합니다.">
				<button type="submit" class="btn">조회</button>
			</div>
		</div>

		<div class="board_list">
			<table>
				<colgroup>
					<col class="w6">
					<col class="w12">
					<col class="w15">
					<col width="*">
					<col class="w10">
					<col class="w10">
					<col class="w13">
					<col class="w13">
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

		<div class="board_bottom">
			<div class="paging">
				<a href="#this" class="arrow one first">맨끝</a>
				<a href="#this" class="arrow two prev">이전</a>
				<a href="#this" class="on">1</a>
				<a href="#this">2</a>
				<a href="#this">3</a>
				<a href="#this">4</a>
				<a href="#this">5</a>
				<a href="#this" class="arrow two next">다음</a>
				<a href="#this" class="arrow one last">맨끝</a>
			</div>
		</div> <!-- //board_bottom -->

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

<script src="/pub/js/jquery-ui.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
//datepicker
	var today = new Date();
	var sixMonthsAgo = new Date();
	sixMonthsAgo.setMonth(today.getMonth() - 6);
	$(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd',
		showMonthAfterYear:true,
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
	$(".datepicker_start").datepicker("setDate", sixMonthsAgo);
	$(".datepicker_end").datepicker("setDate", today);
//popup
	$(".btn_state01").click(function(){
		$(".pop_state01").fadeIn("fast");
	});
	$(".btn_state02").click(function(){
		$(".pop_state02").fadeIn("fast");
	});
});	
//]]>
</script>
<?php include("../pub/inc/_footer.php") ?>