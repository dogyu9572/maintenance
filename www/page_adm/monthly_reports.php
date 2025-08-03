<?php $type="adm"; $gNum="02"; $gName="월간보고서"; ?>
<?php include("../pub/inc/_dtd.php") ?>
<?php include("../pub/inc/_header.php") ?>
<div id="mainContent" class="container sub_wrap maintenance_requests_wrap">

	<div class="inner">
		<div class="title"><?=$gName?>
			<div class="btns">
				<a href="javascript:void(0);" class="btn_write">이번달 보고서 생성</a>
				<a href="/page_adm/monthly_reports_write.php" class="btn_write btn_bl">직접작성</a>
			</div>
		</div>

		<div class="board_top">
			<div class="total">총 <strong class="col_blue">3243</strong>개의 게시글</div>
			<div class="inputs mo_flex_sqr">
				<select name="" id="" class="text mr">
					<option value="">고객사명</option>
				</select>
				<select name="" id="" class="text mr">
					<option value="">연</option>
				</select>
				<select name="" id="" class="text mr">
					<option value="">월</option>
				</select>
				<select name="" id="" class="text">
					<option value="">20개씩 보기</option>
				</select>
			</div>
		</div>

		<div class="board_list chk_board">
			<table>
				<colgroup>
					<col class="w4">
					<col class="w6">
					<col class="w6">
					<col class="w16">
					<col width="*">
					<col class="w18">
					<col class="w6">
					<col class="w12">
					<col class="w10">
					<col class="w7">
				</colgroup>
				<thead>
					<tr>
						<th class="chk"><label class="check solo"><input type="checkbox" id="allCheck"><i></i></label></th>
						<th>No.</th>
						<th>연</th>
						<th>고객사명</th>
						<th>제목</th>
						<th>업무기간</th>
						<th>담당자</th>
						<th>보고일(등록일)</th>
						<th>출력/다운로드</th>
						<th>노출여부</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="tac num">10</td>
						<td class="mobe_tit year order2">2024</td>
						<td class="mobe_tit customer order3">강동성심병원</td>
						<td class="tt order4"><a href="#this">{Year}년 {Month}월 업무현황보고서</a></td>
						<td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
						<td class="mobe_tit name order6">오유림</td>
						<td class="mobe_tit report order6">2024.07.11</td>
						<td class="print order9"><a href="/page_adm/monthly_reports_print.php" target="_blank" class="btn_print">출력</a></td>
						<td class="mobe_tit view order6">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="tac num">9</td>
						<td class="mobe_tit year order2">2024</td>
						<td class="mobe_tit customer order3">강동성심병원</td>
						<td class="tt order4"><a href="#this">{Year}년 {Month}월 업무현황보고서</a></td>
						<td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
						<td class="mobe_tit name order6">오유림</td>
						<td class="mobe_tit report order6">2024.07.11</td>
						<td class="print order9"><a href="/page_adm/monthly_reports_print.php" target="_blank" class="btn_print">출력</a></td>
						<td class="mobe_tit view order6">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="tac num">8</td>
						<td class="mobe_tit year order2">2024</td>
						<td class="mobe_tit customer order3">강동성심병원</td>
						<td class="tt order4"><a href="#this">{Year}년 {Month}월 업무현황보고서</a></td>
						<td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
						<td class="mobe_tit name order6">오유림</td>
						<td class="mobe_tit report order6">2024.07.11</td>
						<td class="print order9"><a href="/page_adm/monthly_reports_print.php" target="_blank" class="btn_print">출력</a></td>
						<td class="mobe_tit view order6">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="tac num">7</td>
						<td class="mobe_tit year order2">2024</td>
						<td class="mobe_tit customer order3">강동성심병원</td>
						<td class="tt order4"><a href="#this">{Year}년 {Month}월 업무현황보고서</a></td>
						<td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
						<td class="mobe_tit name order6">오유림</td>
						<td class="mobe_tit report order6">2024.07.11</td>
						<td class="print order9"><a href="/page_adm/monthly_reports_print.php" target="_blank" class="btn_print">출력</a></td>
						<td class="mobe_tit view order6">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="tac num">6</td>
						<td class="mobe_tit year order2">2024</td>
						<td class="mobe_tit customer order3">강동성심병원</td>
						<td class="tt order4"><a href="#this">{Year}년 {Month}월 업무현황보고서</a></td>
						<td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
						<td class="mobe_tit name order6">오유림</td>
						<td class="mobe_tit report order6">2024.07.11</td>
						<td class="print order9"><a href="/page_adm/monthly_reports_print.php" target="_blank" class="btn_print">출력</a></td>
						<td class="mobe_tit view order6">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="tac num">5</td>
						<td class="mobe_tit year order2">2024</td>
						<td class="mobe_tit customer order3">강동성심병원</td>
						<td class="tt order4"><a href="#this">{Year}년 {Month}월 업무현황보고서</a></td>
						<td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
						<td class="mobe_tit name order6">오유림</td>
						<td class="mobe_tit report order6">2024.07.11</td>
						<td class="print order9"><a href="/page_adm/monthly_reports_print.php" target="_blank" class="btn_print">출력</a></td>
						<td class="mobe_tit view order6">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="tac num">4</td>
						<td class="mobe_tit year order2">2024</td>
						<td class="mobe_tit customer order3">강동성심병원</td>
						<td class="tt order4"><a href="#this">{Year}년 {Month}월 업무현황보고서</a></td>
						<td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
						<td class="mobe_tit name order6">오유림</td>
						<td class="mobe_tit report order6">2024.07.11</td>
						<td class="print order9"><a href="/page_adm/monthly_reports_print.php" target="_blank" class="btn_print">출력</a></td>
						<td class="mobe_tit view order6">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="tac num">3</td>
						<td class="mobe_tit year order2">2024</td>
						<td class="mobe_tit customer order3">강동성심병원</td>
						<td class="tt order4"><a href="#this">{Year}년 {Month}월 업무현황보고서</a></td>
						<td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
						<td class="mobe_tit name order6">오유림</td>
						<td class="mobe_tit report order6">2024.07.11</td>
						<td class="print order9"><a href="/page_adm/monthly_reports_print.php" target="_blank" class="btn_print">출력</a></td>
						<td class="mobe_tit view order6">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="tac num">2</td>
						<td class="mobe_tit year order2">2024</td>
						<td class="mobe_tit customer order3">강동성심병원</td>
						<td class="tt order4"><a href="#this">{Year}년 {Month}월 업무현황보고서</a></td>
						<td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
						<td class="mobe_tit name order6">오유림</td>
						<td class="mobe_tit report order6">2024.07.11</td>
						<td class="print order9"><a href="/page_adm/monthly_reports_print.php" target="_blank" class="btn_print">출력</a></td>
						<td class="mobe_tit view order6">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="tac num">1</td>
						<td class="mobe_tit year order2">2024</td>
						<td class="mobe_tit customer order3">강동성심병원</td>
						<td class="tt order4"><a href="#this">{Year}년 {Month}월 업무현황보고서</a></td>
						<td class="mobe_tit dates order5">2024.05.01~2024.05.31</td>
						<td class="mobe_tit name order6">오유림</td>
						<td class="mobe_tit report order6">2024.07.11</td>
						<td class="print order9"><a href="/page_adm/monthly_reports_print.php" target="_blank" class="btn_print">출력</a></td>
						<td class="mobe_tit view order6">N</td>
					</tr>
				</tbody>
			</table>
			<div class="btn_tal">
				<button type="button" class="btn">삭제</button>
				<button type="button" class="btn">노출 Y</button>
			</div>
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

<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
//체크박스
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
});	
//]]>
</script>

<?php include("../pub/inc/_footer.php") ?>