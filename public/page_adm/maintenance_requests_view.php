<?php $type="adm"; $gNum="01"; $gName="유지보수 요청"; ?>
<?php include("../pub/inc/_dtd.php") ?>
<?php include("../pub/inc/_header.php") ?>
<div id="mainContent" class="container sub_wrap pb0">

	<div class="inner">
		<a href="javascript:history.back();" class="goback">뒤로</a>
		<div class="title"><?=$gName?></div>

		<div class="maintenance_info">
			<dl class="c1">
				<dt>요청상태</dt>
				<dd>
					<select name="" id="" class="text">
						<option value="">상태</option>
					</select>
				</dd>
			</dl>
			<dl class="c2">
				<dt>담당자</dt>
				<dd>
					<select name="" id="" class="text">
						<option value="">오유림</option>
					</select>
				</dd>
			</dl>
		</div>

		<div class="stit s mtb">작업공수 <button type="button" class="btn btn_l">저장하기</button></div>
		<div class="work_hours glbox">
			<div class="box">
				<div class="tit">예상공수(h)</div>
				<ul>
					<li>
						<input type="text" class="text" value="0">
						<p>PM/기획</p>
					</li>
					<li>
						<input type="text" class="text" value="2">
						<p>디자인</p>
					</li>
					<li>
						<input type="text" class="text" value="0">
						<p>퍼블리싱</p>
					</li>
					<li>
						<input type="text" class="text" value="0">
						<p>개발</p>
					</li>
				</ul>
				<button class="btn">공수확인요청</button>
			</div>
			<div class="box">
				<div class="tit">실제공수(h)</div>
				<ul>
					<li>
						<input type="text" class="text" value="0">
						<p>PM/기획</p>
					</li>
					<li>
						<input type="text" class="text" value="0">
						<p>디자인</p>
					</li>
					<li>
						<input type="text" class="text" value="0">
						<p>퍼블리싱</p>
					</li>
					<li>
						<input type="text" class="text" value="0">
						<p>개발</p>
					</li>
				</ul>
			</div>
		</div>

		<div class="stit s mtb">관리자 사용 <button type="button" class="btn btn_l">저장하기</button></div>
		<div class="board_write">
			<table>
				<tbody>
					<tr>
						<th>긴급</th>
						<td><label class="check"><input type="checkbox"><i></i><span class="hot">🔥긴급</span></label></td>
					</tr>
					<tr>
						<th>작업자</th>
						<td>
							<select name="" id="" class="text w1">
								<option value="">작업자</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>처리예정일</th>
						<td><div class="datepicker_area w1"><input type="text" class="text datepicker"></div></td>
					</tr>
					<tr>
						<th>비고</th>
						<td><textarea name="" id="" cols="30" rows="10" class="text w100p"></textarea></td>
					</tr>
					<tr>
						<th>이슈사항</th>
						<td><textarea name="" id="" cols="30" rows="10" class="text w100p"></textarea></td>
					</tr>
					<tr>
						<th>제목(보고서용)</th>
						<td><input type="text" class="text w1"></td>
					</tr>
					<tr>
						<th>진행율 (보고서용)</th>
						<td><input type="text" class="text w2"> %</td>
					</tr>
					<tr>
						<th>처리현황 (보고서용)</th>
						<td>
							<select name="" id="" class="text w1">
								<option value="">완료</option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="stit s mtb">요청내용</div>
		<div class="board_view glbox">
			<div class="tit">휴무 팝업 시안 부탁드립니다</div>
			<div class="writer">
				<dl>
					<dt>고객사</dt>
					<dd>한국심초음파학회<i class="gong">✔ 공수확인완료</i></dd>
				</dl>
				<dl>
					<dt>작성자</dt>
					<dd>허지선/국장/02-123-2342/test@gmail.com</dd>
				</dl>
				<dl>
					<dt>유지보수 종류</dt>
					<dd>콘텐츠 수정</dd>
				</dl>
				<dl>
					<dt>접수일</dt>
					<dd>2024.06.24 15:54:45</dd>
				</dl>
			</div>
			<div class="download_file">
				<a href="#this" class="down" download>파일명이 표출됩니다.pdf</a>
				<a href="#this" class="down" download>파일명이 표출됩니다.pdf</a>
				<a href="#this" class="down" download>파일명이 표출됩니다.pdf</a>
			</div>
			<div class="con">
				안녕하세요.<br>
				한국심초음파학회 허지선입니다.<br>
				휴무 팝업 부탁드립니다.<br>
				아래의 시안에서 내용만 변경해주시면 됩니다.<br>
				<br>
				<내용><br>
				사무국 이전으로 7월 26일 (금)부터 - 7월 29일 (월)까지 <br>
				업무 수행이 불가하여 문의사항은 메일로 연락주시기바랍니다.<br>
				<br>
				감사합니다.<br>
				한국심초음파학회<br>사 무 국 배 상
			</div>
			<div class="imgs">
				<i class="imgfit"><img src="/pub/images/img_request_sample.jpg" alt="image"></i>
				<i class="imgfit"><img src="/pub/images/img_request_sample.jpg" alt="image"></i>
				<i class="imgfit"><img src="/pub/images/img_request_sample.jpg" alt="image"></i>
				<i class="imgfit"><img src="/pub/images/img_request_sample.jpg" alt="image"></i>
				<i class="imgfit"><img src="/pub/images/img_request_sample.jpg" alt="image"></i>
			</div>
		</div>
	</div>

	<div class="gbox reply_area">
		<div class="inner">
			<div class="stit s">댓글·답변</div>
			<!-- 답변 입력 후 -->
			<div class="wbox">
				<div class="tit">
					<span class="state reply">댓글</span>허지선 / 국장 / 02-123-2342 / test@gmail.com / 2024.06.27 15:00:11
					<div class="btns">
						<button type="button" class="btn btn_l">수정</button>
						<button type="button" class="btn btn_l">삭제</button>
					</div>
				</div>
				<div class="con">
					댓글내용입니다.댓글내용입니다.댓글내용입니다.<br>
					댓글내용입니다.댓글내용입니다.댓글내용입니다.댓글내용입니다.댓글내용입니다.
				</div>
			</div>
			<div class="wbox">
				<div class="tit"><span class="state end">작업완료</span>오유림 / 2024.0a6.27 15:00:11</div>
				<div class="con">
					안녕하세요. 오유림입니다.<br>
					작업이 완료되어 답변드립니다.
				</div>
			</div>
			<div class="wbox">
				<div class="tit">
					<span class="state rework">재요청</span>허지선 / 국장 / 02-123-2342 / test@gmail.com / 2024.06.27 15:00:11
					<div class="btns">
						<button type="button" class="btn btn_l">수정</button>
						<button type="button" class="btn btn_l">삭제</button>
					</div>
				</div>
				<div class="con">
					 안녕하세요 심초음파학회입니다 재요청 답변내용입니다.  안녕하세요 심초음파학회입니다 재요청 답변내용입니다. 안녕하세요 심초음파학회입니다 재요청 답변내용입니다. 안녕하세요 심초음파학회입니다 재요청 답변내용입니다. 안녕하세요 심초음파학회입니다 재요청 답변내용입니다. 안녕하세요 심초음파학회입니다 재요청 답변내용입니다.<br>
					 <br>
					 안녕하세요 심초음파학회입니다 재요청 답변내용입니다. 안녕하세요 심초음파학회입니다 재요청 답변내용입니다.<br>
					 안녕하세요 심초음파학회입니다 재요청 답변내용입니다. 안녕하세요 심초음파학회입니다 재요청 답변내용입니다. 안녕하세요 심초음파학회입니다 재요청 답변내용입니다.
				</div>
			</div>
			<!-- //답변 입력 후 -->
			<div class="wbox">
				<div class="tit">오유림 / 2024.06.27 15:00:11 <button type="button" class="btn btn_b">작업완료</button></div>
				<div class="con">
					<textarea name="" id="" cols="30" rows="10" class="text w100p"></textarea>
				</div>
			</div>

			<a href="/page_adm/maintenance_requests.php" class="btn_list">목록</a>
		</div>
	</div>

</div>

<script src="/pub/js/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    // 예상공수 섹션에 대해 처리
    $('.work_hours .box ul li').each(function() {
        var strongValue = parseInt($(this).find('.text').val());
        if (strongValue !== 0) {
            $(this).addClass('in');
        }
    });
//datepicker
	var today = new Date();
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
	});$(".datepicker").datepicker("setDate", today);
});
</script>

<?php include("../pub/inc/_footer.php") ?>