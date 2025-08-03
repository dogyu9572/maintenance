<?php $type="adm"; $gNum="03"; $gName="공지사항"; ?>
<?php include("../pub/inc/_dtd.php") ?>
<?php include("../pub/inc/_header.php") ?>
<div id="mainContent" class="container sub_wrap notices_wrap">

	<div class="inner">
		<a href="javascript:history.back();" class="goback">뒤로</a>
		<div class="title"><?=$gName?></div>

		<div class="board_view glbox">
			<div class="tit">제목이 표출되는 공간입니다. 제목이 표출되는 공간입니다.</div>
			<div class="writer row">
				<dl>
					<dt>작성자</dt>
					<dd>오유림</dd>
				</dl>
				<dl>
					<dt>등록일</dt>
					<dd>2024.06.27</dd>
				</dl>
				<dl>
					<dt>조회수</dt>
					<dd>1223</dd>
				</dl>
			</div>
			<div class="download_file">
				<a href="#this" class="down" download>파일명이 표출됩니다.pdf</a>
				<a href="#this" class="down" download>파일명이 표출됩니다.pdf</a>
				<a href="#this" class="down" download>파일명이 표출됩니다.pdf</a>
			</div>
			<div class="con">
				국가는 농지에 관하여 경자유전의 원칙이 달성될 수 있도록 노력하여야 하며, 농지의 소작제도는 금지된다. 대통령의 선거에 관한 사항은 법률로 정한다.<br>
				대통령은 법률이 정하는 바에 의하여 훈장 기타의 영전을 수여한다. 저작자·발명가·과학기술자와 예술가의 권리는 법률로써 보호한다. 국민경제의 발전을 위한 중요정책의 수립에 관하여 대통령의 자문에 응하기 위하여 국민경제자문회의를 둘 수 있다.<br>
				국가안전보장에 관련되는 대외정책·군사정책과 국내정책의 수립에 관하여 국무회의의 심의에 앞서 대통령의 자문에 응하기 위하여 국가안전보장회의를 둔다.
			</div>
		</div>

		<a href="/page_adm/notices.php" class="btn_list">목록</a>
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