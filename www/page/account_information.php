<?php $gNum="05"; $gName="계정정보"; ?>
<?php include("../pub/inc/_dtd.php") ?>
<?php include("../pub/inc/_header.php") ?>
<div id="mainContent" class="container sub_wrap">

	<div class="inner">
		<div class="title"><?=$gName?></div>

		<div class="stit s mtb">기본정보</div>
		<div class="tbl">
			<table>
				<tbody>
					<tr>
						<th>ID</th>
						<td>kse0701</td>
					</tr>
					<tr>
						<th>PW</th>
						<td><button class="copy">복사</button></td>
					</tr>
					<tr>
						<th>이름(고객사명)</th>
						<td>한국심초음파학회</td>
					</tr>
					<tr>
						<th>생성일</th>
						<td>2024.07.01</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="stit s mtb">담당자 정보 <a href="javascript:void(0);" class="btn btn_setting">정보수정</a></div>
		<div class="tbl">
			<table>
				<tbody>
					<tr>
						<th>대표 담당자</th>
						<td>허지선 / 국장 / 02-123-2342 / test@gmail.com</td>
					</tr>
					<tr>
						<th>담당자1</th>
						<td>김다혜 / 대리 / 02-123-2342 / test@gmail.com</td>
					</tr>
					<tr>
						<th>담당자2</th>
						<td>홍길동 / 선생 / 02-123-2342 / test@gmail.com</td>
					</tr>
					<tr>
						<th>담당자3</th>
						<td>김철수 / 주임 / 02-123-2342 / test@gmail.com</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="stit s mtb">유지보수 정보</div>
		<div class="board_list">
			<table>
				<colgroup>
					<col class="w4">
					<col class="w19">
					<col class="w12">
					<col class="w27">
					<col width="*">
				</colgroup>
				<thead>
					<tr>
						<th>No.</th>
						<th>계약기간</th>
						<th>계약금액</th>
						<th>계약서</th>
						<th>계약공수(h)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="num">3</td>
						<td class="mobe_tit dates">2024.06.28~2024.06.28</td>
						<td class="mobe_tit money">700,000</td>
						<td class="mobe_tit down"><a href="#this" download>2023년 계약서.hwp</a></td>
						<td class="mobe_tit flex_area">
							<div class="flex">
								<dl>
									<dt>PM,기획</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
								<dl>
									<dt>디자인</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
								<dl>
									<dt>퍼블리싱</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
								<dl>
									<dt>개발</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
							</div>
						</td>
					</tr>
					<tr>
						<td class="num">2</td>
						<td class="mobe_tit dates">2024.06.28~2024.06.28</td>
						<td class="mobe_tit money">700,000</td>
						<td class="mobe_tit down"><a href="#this" download>2023년 계약서.hwp</a></td>
						<td class="mobe_tit flex_area">
							<div class="flex">
								<dl>
									<dt>PM,기획</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
								<dl>
									<dt>디자인</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
								<dl>
									<dt>퍼블리싱</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
								<dl>
									<dt>개발</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
							</div>
						</td>
					</tr>
					<tr>
						<td class="num">1</td>
						<td class="mobe_tit dates">2024.06.28~2024.06.28</td>
						<td class="mobe_tit money">700,000</td>
						<td class="mobe_tit down"><a href="#this" download>2023년 계약서.hwp</a></td>
						<td class="mobe_tit flex_area">
							<div class="flex">
								<dl>
									<dt>PM,기획</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
								<dl>
									<dt>디자인</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
								<dl>
									<dt>퍼블리싱</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
								<dl>
									<dt>개발</dt>
									<dd><input type="text" class="text" value="100"></dd>
								</dl>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="stit s mtb">서버, 기타정보</div>
		<div class="tbl">
			<table>
				<tbody>
					<tr>
						<th>도메인</th>
						<td colspan="3">http://www.ksecho.org/</td>
						<th>서브 도메인</th>
						<td colspan="3"></td>
					</tr>
					<tr>
						<th>관리자 주소</th>
						<td colspan="3">http://rhksflwkwnth.com</td>
						<th>관리자 계정 <br class="pc_vw">(ID/PW)</th>
						<td colspan="3">homepage / homepagekorea</td>
					</tr>
					<tr>
						<th>개발언어(버전)</th>
						<td colspan="3">PHP(7.3)</td>
						<th>DB 종류</th>
						<td colspan="3">Maria DB</td>
					</tr>
					<tr>
						<th>도메인 기관</th>
						<td colspan="3">가비아</td>
						<th>서버 기관</th>
						<td colspan="3">닷넷피아</td>
					</tr>
					<tr>
						<th>SSL 기관</th>
						<td colspan="3">가비아</td>
						<th>SSL 만료일</th>
						<td colspan="3">2024.06.28~2024.06.28</td>
					</tr>
					<tr>
						<th>FTP 주소</th>
						<td></td>
						<th>FTP ID</th>
						<td></td>
						<th>FTP PW</th>
						<td></td>
						<th>FTP ID</th>
						<td></td>
					</tr>
					<tr>
						<th>DB 호스트</th>
						<td></td>
						<th>DB ID</th>
						<td></td>
						<th>DB 호스트</th>
						<td></td>
						<th>DB ID</th>
						<td></td>
					</tr>
					<tr>
						<th>비고</th>
						<td colspan="7"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>
<?php include("../pub/inc/_footer.php") ?>