<?php $type="adm"; $gNum="04"; $gName="계정생성"; ?>
<?php include("../pub/inc/_dtd.php") ?>
<?php include("../pub/inc/_header.php") ?>
<div id="mainContent" class="container sub_wrap notices_wrap">

	<div class="inner">
		<a href="javascript:history.back();" class="goback">뒤로</a>
		<div class="title"><?=$gName?></div>

		<div class="stit s mtb">기본정보</div>
		<div class="tbl">
			<table>
				<tbody>
					<tr>
						<th>회원구분*</th>
						<td>
							<div class="flex radios">
								<label class="radio"><input type="radio" name="member_type"><i></i>일반</label>
								<label class="radio"><input type="radio" name="member_type"><i></i>관리자</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>유형</th>
						<td>
							<div class="flex radios">
								<label class="radio"><input type="radio" name="new_type"><i></i>신규</label>
								<label class="radio"><input type="radio" name="new_type"><i></i>갱신</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>이름(고객사명)*</th>
						<td>
							<div class="flex inchk">
								<input type="text" class="text w45">
								<label class="check"><input type="checkbox"><i></i>공수 확인 고객사</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>타입</th>
						<td>
							<select name="" id="" class="text w45">
								<option value="">협회</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>ID</th>
						<td>
							<div class="flex inbtn">
								<input type="text" class="text">
								<button class="btn">중복확인</button>
							</div>
						</td>
					</tr>
					<tr>
						<th>PW</th>
						<td><input type="text" class="text w45"></td>
					</tr>
					<tr>
						<th>PW 확인*</th>
						<td><input type="text" class="text w45"></td>
					</tr>
					<tr>
						<th>월간보고서 사용</th>
						<td>
							<div class="flex radios">
								<label class="radio"><input type="radio" name="weekend"><i></i>Y</label>
								<label class="radio"><input type="radio" name="weekend"><i></i>N</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>생성일</th>
						<td><input type="text" class="text w45" value="2024.07.01" disabled></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="stit s mtb">담당자 정보</div>
		<div class="board_list manager_info_list">
			<table>
				<colgroup>
					<col class="w10">
					<col width="*">
					<col width="*">
					<col width="*">
					<col width="*">
				</colgroup>
				<thead>
					<tr>
						<th>담당자</th>
						<th>이름</th>
						<th>직위/직급</th>
						<th>연락처</th>
						<th>이메일</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="mobe_tit manager order1">대표 담당자*</td>
						<td class="mobe_tit name order2"><input type="text" class="text w100p"></td>
						<td class="mobe_tit position order3"><input type="text" class="text w100p"></td>
						<td class="mobe_tit phone order4"><input type="text" class="text w100p"></td>
						<td class="mobe_tit mail order5"><input type="text" class="text w100p"></td>
					</tr>
					<tr>
						<td class="mobe_tit manager order1">담당자1</td>
						<td class="mobe_tit name order2"><input type="text" class="text w100p"></td>
						<td class="mobe_tit position order3"><input type="text" class="text w100p"></td>
						<td class="mobe_tit phone order4"><input type="text" class="text w100p"></td>
						<td class="mobe_tit mail order5"><input type="text" class="text w100p"></td>
					</tr>
					<tr>
						<td class="mobe_tit manager order1">담당자2</td>
						<td class="mobe_tit name order2"><input type="text" class="text w100p"></td>
						<td class="mobe_tit position order3"><input type="text" class="text w100p"></td>
						<td class="mobe_tit phone order4"><input type="text" class="text w100p"></td>
						<td class="mobe_tit mail order5"><input type="text" class="text w100p"></td>
					</tr>
					<tr>
						<td class="mobe_tit manager order1">담당자3</td>
						<td class="mobe_tit name order2"><input type="text" class="text w100p"></td>
						<td class="mobe_tit position order3"><input type="text" class="text w100p"></td>
						<td class="mobe_tit phone order4"><input type="text" class="text w100p"></td>
						<td class="mobe_tit mail order5"><input type="text" class="text w100p"></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="stit s mtb">유지보수 정보 <button class="btn btn_long">필드추가</button></div>
		<div class="board_list maintenance_info_list">
			<table>
				<colgroup>
					<col class="w4">
					<col class="w31">
					<col width="*">
					<col class="w19">
					<col class="w8">
				</colgroup>
				<thead>
					<tr>
						<th>No.</th>
						<th>계약기간</th>
						<th>
							<div class="flex">
								계약공수
								<select name="" id="" class="text">
									<option value="">일(d)/시(h)/분(m)</option>
									<option value="">일(d)</option>
									<option value="">시(h)</option>
									<option value="">분(m)</option>
								</select>
							</div>
						</th>
						<th>계약서</th>
						<th>삭제</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="num">3</td>
						<td class="order1">
							<div class="flex datepicker_wrap">
								<div class="datepicker_area"><input type="text" class="text datepicker datepicker_today w100p" value="2024.06.28"></div>
								<span></span>
								<div class="datepicker_area"><input type="text" class="text datepicker datepicker_today w100p" value="2024.06.28"></div>
							</div>
						</td>
						<td class="order2">
							<div class="flex">
								<dl>
									<dt>PM,기획</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
								<dl>
									<dt>디자인</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
								<dl>
									<dt>퍼블리싱</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
								<dl>
									<dt>개발</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
							</div>
						</td>
						<td class="order3 file_wrap">
							<div class="file_input">
								<label class="filebutton">
									<span>파일찾기</span>
									<input type="file" name="egovComFileUploader" class="searchfile" title="파일 찾기">
								</label>
								<div class="filebox"></div>
							</div>
						</td>
						<td class="order4 del_wrap"><button type="button" class="btn_del">삭제</button></td>
					</tr>
					<tr>
						<td class="num">2</td>
						<td class="order1">
							<div class="flex datepicker_wrap">
								<div class="datepicker_area"><input type="text" class="text datepicker datepicker_today w100p" value="2024.06.28"></div>
								<span></span>
								<div class="datepicker_area"><input type="text" class="text datepicker datepicker_today w100p" value="2024.06.28"></div>
							</div>
						</td>
						<td class="order2">
							<div class="flex">
								<dl>
									<dt>PM,기획</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
								<dl>
									<dt>디자인</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
								<dl>
									<dt>퍼블리싱</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
								<dl>
									<dt>개발</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
							</div>
						</td>
						<td class="order3 file_wrap">
							<div class="file_input">
								<label class="filebutton">
									<span>파일찾기</span>
									<input type="file" name="egovComFileUploader" class="searchfile" title="파일 찾기">
								</label>
								<div class="filebox"></div>
							</div>
						</td>
						<td class="order4 del_wrap"><button type="button" class="btn_del">삭제</button></td>
					</tr>
					<tr>
						<td class="num">1</td>
						<td class="order1">
							<div class="flex datepicker_wrap">
								<div class="datepicker_area"><input type="text" class="text datepicker datepicker_today w100p" value="2024.06.28"></div>
								<span></span>
								<div class="datepicker_area"><input type="text" class="text datepicker datepicker_today w100p" value="2024.06.28"></div>
							</div>
						</td>
						<td class="order2">
							<div class="flex">
								<dl>
									<dt>PM,기획</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
								<dl>
									<dt>디자인</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
								<dl>
									<dt>퍼블리싱</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
								<dl>
									<dt>개발</dt>
									<dd><input type="text" class="text bgw" value="100"></dd>
								</dl>
							</div>
						</td>
						<td class="order3 file_wrap"><a href="#this" download>2023년 계약서.hwp</a></td>
						<td class="order4 del_wrap"><button type="button" class="btn_del">삭제</button></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="stit s mtb">서버, 기타정보</div>
		<div class="tbl bdrs_l">
			<table>
				<tbody>
					<tr>
						<th>도메인</th>
						<td colspan="3"><input type="text" class="text w100p"></td>
						<th>서브 도메인</th>
						<td colspan="3"><input type="text" class="text w100p"></td>
					</tr>
					<tr>
						<th>관리자 주소</th>
						<td colspan="3"><input type="text" class="text w100p"></td>
						<th>관리자 계정 <br class="pc_vw">(ID/PW)</th>
						<td colspan="3"><input type="text" class="text w100p"></td>
					</tr>
					<tr>
						<th>개발언어(버전)</th>
						<td colspan="3"><input type="text" class="text w100p"></td>
						<th>DB 종류</th>
						<td colspan="3"><input type="text" class="text w100p"></td>
					</tr>
					<tr>
						<th>도메인 기관</th>
						<td colspan="3"><input type="text" class="text w100p"></td>
						<th>서버 기관</th>
						<td colspan="3"><input type="text" class="text w100p"></td>
					</tr>
					<tr>
						<th>SSL 기관</th>
						<td colspan="3"><input type="text" class="text w100p"></td>
						<th>SSL 만료일</th>
						<td colspan="3"><input type="text" class="text w100p"></td>
					</tr>
					<tr>
						<th>FTP 주소</th>
						<td><input type="text" class="text w100p"></td>
						<th>FTP ID</th>
						<td><input type="text" class="text w100p"></td>
						<th>FTP PW</th>
						<td><input type="text" class="text w100p"></td>
						<th>FTP ID</th>
						<td><input type="text" class="text w100p"></td>
					</tr>
					<tr>
						<th>DB 호스트</th>
						<td><input type="text" class="text w100p"></td>
						<th>DB ID</th>
						<td><input type="text" class="text w100p"></td>
						<th>DB 호스트</th>
						<td><input type="text" class="text w100p"></td>
						<th>DB ID</th>
						<td><input type="text" class="text w100p"></td>
					</tr>
					<tr>
						<th>비고</th>
						<td colspan="7" class="pd16"><textarea name="" id="" cols="30" rows="10" class="text w100p"></textarea></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="board_bottom">
			<div class="btns_tac">
				<button class="btn btn_g">저장</button>
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
	$(".datepicker_today").datepicker("setDate", today);
//fileinput
	$(".searchfile").on('change',function(){
		val = $(this).val().split("\\");
		f_name = val[val.length-1]; 
		s_name = f_name.substring(f_name.length-4, f_name.length);
		$(this).parent().siblings('.filebox').html(f_name);
		$(this).parent().parent().addClass("on");
	});
});	
//]]>
</script>
<?php include("../pub/inc/_footer.php") ?>