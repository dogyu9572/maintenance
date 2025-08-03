<?php $type="adm"; $gNum="04"; $gName="계정 관리"; ?>
<?php include("../pub/inc/_dtd.php") ?>
<?php include("../pub/inc/_header.php") ?>
<div id="mainContent" class="container sub_wrap account_wrap">

	<div class="inner">
		<div class="title"><?php echo $gName; ?>
			<a href="/page_adm/announcement.php" class="btn_write btn_ann">계정생성</a>
		</div>

		<div class="tabs">
			<a href="/page_adm/account.php" class="on">일반</a>
			<a href="/page_adm/account_adm.php">관리자</a>
		</div>

		<div class="board_top">
			<div class="total">총 <strong class="col_blue">3243</strong>개의 게시글</div>
			<div class="inputs">
				<div class="datepicker_area"><input type="text" class="text datepicker datepicker_start"></div>
				<span class="bar"></span>
				<div class="datepicker_area"><input type="text" class="text datepicker datepicker_end"></div>
				<input type="text" class="text input" placeholder="고객사명, 대표 담당자 이름으로 검색">
				<button type="submit" class="btn">조회</button>
				<select name="" id="" class="text ml2 mo_w100p">
					<option value="">20개씩 보기</option>
				</select>
			</div>
		</div>

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
						<th class="chk"><label class="check solo"><input type="checkbox" id="allCheck"><i></i></label></th>
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
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="num_view order2">32343</td>
						<td class="mobe_tit type1 order3">신규</td>
						<td class="mobe_tit type2 order4">병원</td>
						<td class="mobe_tit customer order5">강동성심병원</td>
						<td class="mobe_tit id order6">djgslkdjg13</td>
						<td class="mobe_tit contract order7 mo_w100p">2024.07.18~2024.12.05</td>
						<td class="mobe_tit person order8">허지선</td>
						<td class="mobe_tit position order9">국장</td>
						<td class="mobe_tit phone order10">02-1234-5678</td>
						<td class="mobe_tit mail order11">test@gmail.com</td>
						<td class="mobe_tit creation order12">2024.07.18</td>
						<td class="mobe_tit used order13">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="num_view order2">32343</td>
						<td class="mobe_tit type1 order3">신규</td>
						<td class="mobe_tit type2 order4">병원</td>
						<td class="mobe_tit customer order5">강동성심병원</td>
						<td class="mobe_tit id order6">djgslkdjg13</td>
						<td class="mobe_tit contract order7 mo_w100p">2024.07.18~2024.12.05</td>
						<td class="mobe_tit person order8">허지선</td>
						<td class="mobe_tit position order9">국장</td>
						<td class="mobe_tit phone order10">02-1234-5678</td>
						<td class="mobe_tit mail order11">test@gmail.com</td>
						<td class="mobe_tit creation order12">2024.07.18</td>
						<td class="mobe_tit used order13">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="num_view order2">32343</td>
						<td class="mobe_tit type1 order3">신규</td>
						<td class="mobe_tit type2 order4">병원</td>
						<td class="mobe_tit customer order5">강동성심병원</td>
						<td class="mobe_tit id order6">djgslkdjg13</td>
						<td class="mobe_tit contract order7 mo_w100p">2024.07.18~2024.12.05</td>
						<td class="mobe_tit person order8">허지선</td>
						<td class="mobe_tit position order9">국장</td>
						<td class="mobe_tit phone order10">02-1234-5678</td>
						<td class="mobe_tit mail order11">test@gmail.com</td>
						<td class="mobe_tit creation order12">2024.07.18</td>
						<td class="mobe_tit used order13">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="num_view order2">32343</td>
						<td class="mobe_tit type1 order3">신규</td>
						<td class="mobe_tit type2 order4">병원</td>
						<td class="mobe_tit customer order5">강동성심병원</td>
						<td class="mobe_tit id order6">djgslkdjg13</td>
						<td class="mobe_tit contract order7 mo_w100p">2024.07.18~2024.12.05</td>
						<td class="mobe_tit person order8">허지선</td>
						<td class="mobe_tit position order9">국장</td>
						<td class="mobe_tit phone order10">02-1234-5678</td>
						<td class="mobe_tit mail order11">test@gmail.com</td>
						<td class="mobe_tit creation order12">2024.07.18</td>
						<td class="mobe_tit used order13">N</td>
					</tr>
					<tr>
						<td class="chk order1"><label class="check solo"><input type="checkbox" name="check"><i></i></label></td>
						<td class="num_view order2">32343</td>
						<td class="mobe_tit type1 order3">신규</td>
						<td class="mobe_tit type2 order4">병원</td>
						<td class="mobe_tit customer order5">강동성심병원</td>
						<td class="mobe_tit id order6">djgslkdjg13</td>
						<td class="mobe_tit contract order7 mo_w100p">2024.07.18~2024.12.05</td>
						<td class="mobe_tit person order8">허지선</td>
						<td class="mobe_tit position order9">국장</td>
						<td class="mobe_tit phone order10">02-1234-5678</td>
						<td class="mobe_tit mail order11">test@gmail.com</td>
						<td class="mobe_tit creation order12">2024.07.18</td>
						<td class="mobe_tit used order13">N</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- 한페이지 20개 -->

		<div class="board_bottom">
			<div class="btns_tal">
				<button type="button" class="btn">삭제</button>
			</div>
			<div class="paging mt1">
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