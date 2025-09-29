@extends('layouts.app')

@section('title', '유지보수 요청')

@section('content')
<div id="mainContent" class="container sub_wrap maintenance_requests_wrap">

	<div class="inner">
		<div class="title">유지보수 요청 <a href="{{ route('maintenance.requests.create') }}" class="btn_write">유지보수 요청하기</a></div>

		<div class="btit">처리현황 <a href="javascript:void(0);" class="btn_state btn_state01">처리현황(과정)안내</a></div>
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
						<td class="tt"><a href="{{ route('maintenance.requests.show', 10) }}">간호간병통합서비스 병동 홈페이지 게시물 수정요청건...</a></td>
						<td class="mobe_tit writer">강심장</td>
						<td class="mobe_tit manager"></td>
						<td class="mobe_tit date_in">2024.07.11</td>
						<td class="mobe_tit date_end"></td>
					</tr>
					<tr>
						<td class="num">9</td>
						<td class="state_box"><span class="state i4">진행중</span></td>
						<td class="type">메일, 뉴스레터 발송</td>
						<td class="tt"><a href="{{ route('maintenance.requests.show', 9) }}">제15회 DAWAS 뉴스레터 발송의 건</a></td>
						<td class="mobe_tit writer">박은지</td>
						<td class="mobe_tit manager">오유림</td>
						<td class="mobe_tit date_in">2024.07.11</td>
						<td class="mobe_tit date_end"></td>
					</tr>
					<tr>
						<td class="num">8</td>
						<td class="state_box"><span class="state i2">공수확인요청</span></td>
						<td class="type">오류발생</td>
						<td class="tt"><a href="{{ route('maintenance.requests.show', 8) }}">심초음파학회 오류</a></td>
						<td class="mobe_tit writer">박은지</td>
						<td class="mobe_tit manager">오유림</td>
						<td class="mobe_tit date_in">2024.07.11</td>
						<td class="mobe_tit date_end"></td>
					</tr>
					<tr>
						<td class="num">7</td>
						<td class="state_box"><span class="state i3">공수확인완료</span></td>
						<td class="type">SSL(보안인증서)</td>
						<td class="tt"><a href="{{ route('maintenance.requests.show', 7) }}">휴대폰으로 사이트 접속 시 오류 확인 요청 건</a></td>
						<td class="mobe_tit writer">김지혜</td>
						<td class="mobe_tit manager">오유림</td>
						<td class="mobe_tit date_in">2024.07.11</td>
						<td class="mobe_tit date_end"></td>
					</tr>
					<tr>
						<td class="num">6</td>
						<td class="state_box"><span class="state i5">재요청</span></td>
						<td class="type">콘텐츠 수정</td>
						<td class="tt"><a href="{{ route('maintenance.requests.show', 6) }}">재활용의무이행 실적 변경사항 송부</a></td>
						<td class="mobe_tit writer">김지혜</td>
						<td class="mobe_tit manager">오유림</td>
						<td class="mobe_tit date_in">2024.07.11</td>
						<td class="mobe_tit date_end"></td>
					</tr>
				</tbody>
			</table>
		</div>

		@if(isset($requests))
		<x-pagination :paginator="$requests" />
		@endif
	</div>

</div>
@endsection
