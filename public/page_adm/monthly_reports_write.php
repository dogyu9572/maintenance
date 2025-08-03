<?php $type="adm"; $gNum="02"; $gName="보고서 작성"; ?>
<?php include("../pub/inc/_dtd.php") ?>
<?php include("../pub/inc/_header.php") ?>
<div id="mainContent" class="container sub_wrap maintenance_requests_wrap">

	<div class="inner">
		<a href="javascript:history.back();" class="goback">뒤로</a>
		<div class="title"><?=$gName?></div>

		<div class="stit s">보고서 작성 <button type="button" class="btn btn_l">저장하기</button></div>
		<div class="tbl">
			<table>
				<tbody>
					<tr>
						<th>고객사명</th>
						<td>
							<select name="" id="" class="text w50">
								<option value="">고객사명</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>제목</th>
						<td><input type="text" class="text w50" value="{Year}년 {Month}월 유지보수 업무현황 월간보고서"></td>
					</tr>
					<tr>
						<th>업무기간</th>
						<td>
							<div class="inputs flex">
								<div class="datepicker_area"><input type="text" class="text datepicker datepicker_start"></div>
								<span class="bar"></span>
								<div class="datepicker_area"><input type="text" class="text datepicker datepicker_end"></div>
							</div>
						</td>
					</tr>
					<tr>
						<th>사업명</th>
						<td><input type="text" class="text w50" value="유지보수 진행업무"></td>
					</tr>
					<tr>
						<th>용역책임자</th>
						<td><input type="text" class="text w50" value="홈리아"></td>
					</tr>
					<tr>
						<th>사업책임자</th>
						<td><input type="text" class="text w50" value="홈페이지코리아"></td>
					</tr>
					<tr>
						<th>보고일(등록일)</th>
						<td><div class="datepicker_area"><input type="text" class="text datepicker" value="2024.06.28"></div></td>
					</tr>
					<tr>
						<th>작성자</th>
						<td>오유림</td>
					</tr>
					<tr>
						<th>노출여부</th>
						<td>
							<div class="flex radios">
								<label class="radio"><input type="radio" name="radio"><i></i>Y</label>
								<label class="radio"><input type="radio" name="radio"><i></i>N</label>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="stit s mt">업무현황 <button type="button" class="btn btn_l btn_addfield">필드추가</button></div>
		<div class="board_list over_v tbl_addfield">
			<table>
				<colgroup>
					<col class="w6">
					<col width="*">
					<col class="w16">
					<col class="w16">
					<col class="w16">
					<col class="w16">
					<col class="w16">
				</colgroup>
				<thead>
					<tr>
						<th>No.</th>
						<th>내용</th>
						<th>진행율(%)</th>
						<th>처리상태</th>
						<th>담당자</th>
						<th>완료일</th>
						<th>완료일</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="num">1</td>
						<td class="report1"><input type="text" class="text w100p" value="홈페이지 수정요청"></td>
						<td class="report2"><input type="text" class="text w100p" value="100"></td>
						<td class="report3">
							<select name="" id="" class="text w100p">
								<option value="">진행중/완료</option>
								<option value="">진행중</option>
								<option value="">완료</option>
							</select>
						</td>
						<td class="report4">
							<select name="" id="" class="text w100p">
								<option value="">담당자 선택</option>
								<option value="">오유림</option>
							</select>
						</td>
						<td class="report5"><div class="datepicker_area w100p"><input type="text" class="text datepicker w100p" value="2024.06.28"></div></td>
						<td class="report6"><div class="datepicker_area w100p"><input type="text" class="text datepicker w100p" value="2024.06.28"></div></td>
					</tr>
					<tr>
						<td class="num">2</td>
						<td class="report1"><input type="text" class="text w100p" value="홈페이지 수정요청"></td>
						<td class="report2"><input type="text" class="text w100p" value="100"></td>
						<td class="report3">
							<select name="" id="" class="text w100p">
								<option value="">진행중/완료</option>
								<option value="">진행중</option>
								<option value="">완료</option>
							</select>
						</td>
						<td class="report4">
							<select name="" id="" class="text w100p">
								<option value="">담당자 선택</option>
								<option value="">오유림</option>
							</select>
						</td>
						<td class="report5"><div class="datepicker_area w100p"><input type="text" class="text datepicker w100p" value="2024.06.28"></div></td>
						<td class="report6"><div class="datepicker_area w100p"><input type="text" class="text datepicker w100p" value="2024.06.28"></div></td>
					</tr>
					<tr>
						<td class="num">3</td>
						<td class="report1"><input type="text" class="text w100p" value="홈페이지 수정요청"></td>
						<td class="report2"><input type="text" class="text w100p" value="100"></td>
						<td class="report3">
							<select name="" id="" class="text w100p">
								<option value="">진행중/완료</option>
								<option value="">진행중</option>
								<option value="">완료</option>
							</select>
						</td>
						<td class="report4">
							<select name="" id="" class="text w100p">
								<option value="">담당자 선택</option>
								<option value="">오유림</option>
							</select>
						</td>
						<td class="report5"><div class="datepicker_area w100p"><input type="text" class="text datepicker w100p" value="2024.06.28"></div></td>
						<td class="report6"><div class="datepicker_area w100p"><input type="text" class="text datepicker w100p" value="2024.06.28"></div></td>
					</tr>
					<tr>
						<td class="num">4</td>
						<td class="report1"><input type="text" class="text w100p" value="홈페이지 수정요청"></td>
						<td class="report2"><input type="text" class="text w100p" value="100"></td>
						<td class="report3">
							<select name="" id="" class="text w100p">
								<option value="">진행중/완료</option>
								<option value="">진행중</option>
								<option value="">완료</option>
							</select>
						</td>
						<td class="report4">
							<select name="" id="" class="text w100p">
								<option value="">담당자 선택</option>
								<option value="">오유림</option>
							</select>
						</td>
						<td class="report5"><div class="datepicker_area w100p"><input type="text" class="text datepicker w100p" value="2024.06.28"></div></td>
						<td class="report6"><div class="datepicker_area w100p"><input type="text" class="text datepicker w100p" value="2024.06.28"></div></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="stit s mt">특이사항</div>
		<div class="glbox outgray">
			<textarea name="" id="" cols="30" rows="10" class="text w100p"></textarea>
		</div>

		<div class="board_bottom">
			<div class="btns_tac">
				<button class="btn btn_g">저장</button>
				<a href="/page_adm/monthly_reports.php" class="btn btn_l">목록</a>
			</div>
		</div> <!-- //board_bottom -->

	</div>

</div>

<script src="/pub/js/jquery-ui.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // datepicker
    var today = new Date();
    var sixMonthsAgo = new Date();
    sixMonthsAgo.setMonth(today.getMonth() - 6);
    $(".datepicker").datepicker({
        dateFormat: 'yy.mm.dd',
        showMonthAfterYear: true,
        showOn: "both",
        buttonImage: "/pub/images/icon_month.svg",
        buttonImageOnly: true,
        changeYear: true,
        changeMonth: true,
        yearRange: 'c-100:c+10',
        yearSuffix: "년 ",
        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토']
    });
    $(".datepicker_start").datepicker("setDate", sixMonthsAgo);
    $(".datepicker_end").datepicker("setDate", today);

    // btn_addfield click event
    $(".btn_addfield").click(function() {
        // 현재 테이블에 있는 tr 개수 + 1로 번호 생성
        var rowCount = $(".tbl_addfield table tbody tr").length + 1;

        // 새롭게 추가할 tr 내용을 정의
        var newRow = `
          <tr>
            <td class="num">${rowCount}</td>
            <td class="report1"><input type="text" class="text w100p" value="홈페이지 수정요청"></td>
            <td class="report2"><input type="text" class="text w100p" value="100"></td>
            <td class="report3">
                <select name="" id="" class="text w100p">
                    <option value="">진행중/완료</option>
                    <option value="">진행중</option>
                    <option value="">완료</option>
                </select>
            </td>
            <td class="report4">
                <select name="" id="" class="text w100p">
                    <option value="">담당자 선택</option>
                    <option value="">오유림</option>
                </select>
            </td>
            <td class="report5"><div class="datepicker_area w100p"><input type="text" class="text datepicker w100p" value="2024.06.28"></div></td>
            <td class="report6"><div class="datepicker_area w100p"><input type="text" class="text datepicker w100p" value="2024.06.28"></div></td>
          </tr>
        `;

        // 마지막 tr 뒤에 새로운 tr을 추가
        $(".tbl_addfield table tbody").append(newRow);

        // 새로 추가된 select 요소에 niceSelect 초기화
        $("select").niceSelect();

        // 새로 추가된 datepicker 요소에 datepicker 초기화
        $(".datepicker").datepicker({
            dateFormat: 'yy.mm.dd',
            showMonthAfterYear: true,
            showOn: "both",
            buttonImage: "/pub/images/icon_month.svg",
            buttonImageOnly: true,
            changeYear: true,
            changeMonth: true,
            yearRange: 'c-100:c+10',
            yearSuffix: "년 ",
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토']
        });
    });
});
//]]>
</script>

<?php include("../pub/inc/_footer.php") ?>