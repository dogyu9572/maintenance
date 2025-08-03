<?php $gNum="01"; $gName="유지보수 요청"; ?>
<?php include("../pub/inc/_dtd.php") ?>
<?php include("../pub/inc/_header.php") ?>
<div id="mainContent" class="container sub_wrap pb0">

	<div class="inner">
		<a href="javascript:history.back();" class="goback">뒤로</a>
		<div class="title"><?=$gName?></div>

		<div class="maintenance_info">
			<dl class="c1">
				<dt>요청상태</dt>
				<dd>접수</dd>
			</dl>
			<dl class="c2">
				<dt>담당자</dt>
				<dd>오유림</dd>
			</dl>
		</div>

		<div class="stit s mtb">작업공수</div>
		<div class="work_hours glbox">
			<div class="box">
				<div class="tit">예상공수(h)</div>
				<ul>
					<li>
						<strong>0</strong>
						<p>PM/기획</p>
					</li>
					<li>
						<strong>2</strong>
						<p>디자인</p>
					</li>
					<li>
						<strong>0</strong>
						<p>퍼블리싱</p>
					</li>
					<li>
						<strong>0</strong>
						<p>개발</p>
					</li>
				</ul>
				<button class="btn">예상공수 확인<span>공수확인 버튼을 눌러주세요.</span></button>
			</div>
			<div class="box">
				<div class="tit">실제공수(h)</div>
				<ul>
					<li>
						<strong>0</strong>
						<p>PM/기획</p>
					</li>
					<li>
						<strong>2</strong>
						<p>디자인</p>
					</li>
					<li>
						<strong>1</strong>
						<p>퍼블리싱</p>
					</li>
					<li>
						<strong>0</strong>
						<p>개발</p>
					</li>
				</ul>
			</div>
		</div>

		<div class="stit s mtb">요청내용</div>
		<div class="board_view glbox">
			<div class="tit">휴무 팝업 시안 부탁드립니다</div>
			<div class="writer">
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
			<!-- 답변 입력 전 -->
			<div class="wbox">
				<div class="tit">
					<select name="" id="" class="text">
						<option value="">작성자</option>
					</select>
					<button type="button" class="btn">저장</button>
				</div>
				<div class="con">
					<textarea name="" id="" cols="30" rows="10" class="text w100p"></textarea>
				</div>
			</div>
			<!-- //답변 입력 전 -->
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
				<div class="tit"><span class="state reply">작업완료</span>오유림 / 2024.0a6.27 15:00:11</div>
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
			<div class="wbox">
				<div class="tit"><span class="state end">답변완료</span>오유림 / 2024.0a6.27 15:00:11</div>
				<div class="con">
					안녕하세요. 유지보수팀 오유림입니다.<br>
					작업이 완료되어 답변드립니다.
				</div>
			</div>
			<!-- //답변 입력 후 -->

			<a href="/page/maintenance_requests.php" class="btn_list">목록</a>
		</div>
	</div>

</div>

<script>
$(document).ready(function() {
    // 예상공수 섹션에 대해 처리
    $('.work_hours .box ul li').each(function() {
        var strongValue = parseInt($(this).find('strong').text());
        if (strongValue !== 0) {
            $(this).addClass('in');
        }
    });
});
</script>

<?php include("../pub/inc/_footer.php") ?>