<?php include("../pub/inc/_dtd.php") ?>

<div id="printarea">
	<div class="monthly_reports_print">
		<div class="head">
			<div class="title">월간보고서</div>
			<div class="date">보고일 : YYYY년 MM월 DD일</div>
				
			<div class="tit"><strong>2024년 6월</strong> 유지보수 업무현황</div>
			<div class="tbl">
				<table>
					<tbody>
						<tr>
							<th>· 사업명</th>
							<td>{고객사명} 유지보수 진행업무</td>
						</tr>
						<tr>
							<th>· 업무기간</th>
							<td>2024.05.01~2024.05.31</td>
						</tr>
						<tr>
							<th>· 용역책임자</th>
							<td>염희경</td>
						</tr>
						<tr>
							<th>· 사업책임자</th>
							<td>홈페이지코리아</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	
		<div class="body">
			<table class="tbl1">
				<colgroup>
					<col width="9%">
					<col width="6%">
					<col width="*">
					<col width="10%">
					<col width="11%">
					<col width="13%">
					<col width="13%">
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>NO.</th>
						<th>내용</th>
						<th>진행율(%)</th>
						<th>처리상태</th>
						<th>접수일</th>
						<th>완료일</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th rowspan="4">업무내용</th>
						<td class="tac">1</td>
						<td>홈페이지 메인 수정 요청</td>
						<td>100</td>
						<td>완료</td>
						<td>2024.06.27</td>
						<td>2024.06.27</td>
					</tr>
					<tr>
						<td class="tac">2</td>
						<td>홈페이지 메인 수정 요청</td>
						<td>100</td>
						<td>완료</td>
						<td>2024.06.27</td>
						<td>2024.06.27</td>
					</tr>
					<tr>
						<td class="tac">3</td>
						<td>홈페이지 메인 수정 요청</td>
						<td>100</td>
						<td>완료</td>
						<td>2024.06.27</td>
						<td>2024.06.27</td>
					</tr>
					<tr>
						<td class="tac">4</td>
						<td>홈페이지 메인 수정 요청</td>
						<td>30</td>
						<td>진행중</td>
						<td>2024.06.27</td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<table class="tbl2">
				<thead>
					<tr>
						<th>특이사항</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>특이사항이 나오는 곳 입니다.</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	// 페이지 로드 시 바로 인쇄를 시작
	window.print();

	// 인쇄 대화 상자가 닫힌 후 실행되는 함수
	$(window).on("afterprint", function() {
		// 페이지를 닫습니다.
		window.close();
	});

	// 인쇄가 취소되거나 실패할 경우를 대비하여 페이지를 닫습니다.
	$(window).on("beforeunload", function() {
		window.close();
	});
});
</script>

<style>
@media print {
	@page {margin:0; size: A4;}
	.transaction_statement {page-break-inside: avoid;}
}
</style>

</body>
</html>