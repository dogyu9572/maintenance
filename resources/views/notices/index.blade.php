@extends('layouts.app')

@section('title', '공지사항')

@section('content')
<div id="mainContent" class="container sub_wrap notices_wrap">

	<div class="inner">
		<div class="title">공지사항</div>

		<div class="board_top">
			<div class="total">총 <strong class="col_blue">3243</strong>개의 게시글</div>
			<div class="inputs">
				<div class="datepicker_area"><input type="text" class="text datepicker datepicker_start"></div>
				<span class="bar"></span>
				<div class="datepicker_area"><input type="text" class="text datepicker datepicker_end"></div>
				<input type="text" class="text input" placeholder="제목으로 검색이 가능합니다.">
				<button type="submit" class="btn">조회</button>
			</div>
		</div>

		<div class="board_list">
			<table>
				<colgroup>
					<col class="w8">
					<col width="*">
					<col class="w12">
					<col class="w12">
					<col class="w12">
				</colgroup>
				<thead>
					<tr>
						<th>No.</th>
						<th>제목</th>
						<th>담당자</th>
						<th>등록일</th>
						<th>조회수</th>
					</tr>
				</thead>
				<tbody>
					<tr class="notice">
						<td class="num"><i class="icon">공지</i></td>
						<td class="tt"><a href="{{ route('notices.show', 1) }}">홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..</a></td>
						<td class="mobe_tit name">오유림</td>
						<td class="mobe_tit date">2024.07.11</td>
						<td class="mobe_tit hit">1234</td>
					</tr>
					<tr>
						<td class="num">9</td>
						<td class="tt"><a href="{{ route('notices.show', 9) }}">홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..</a></td>
						<td class="mobe_tit name">오유림</td>
						<td class="mobe_tit date">2024.07.11</td>
						<td class="mobe_tit hit">1234</td>
					</tr>
					<tr>
						<td class="num">8</td>
						<td class="tt"><a href="{{ route('notices.show', 8) }}">홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..</a></td>
						<td class="mobe_tit name">오유림</td>
						<td class="mobe_tit date">2024.07.11</td>
						<td class="mobe_tit hit">1234</td>
					</tr>
					<tr>
						<td class="num">7</td>
						<td class="tt"><a href="{{ route('notices.show', 7) }}">홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..</a></td>
						<td class="mobe_tit name">오유림</td>
						<td class="mobe_tit date">2024.07.11</td>
						<td class="mobe_tit hit">1234</td>
					</tr>
					<tr>
						<td class="num">6</td>
						<td class="tt"><a href="{{ route('notices.show', 6) }}">홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..</a></td>
						<td class="mobe_tit name">오유림</td>
						<td class="mobe_tit date">2024.07.11</td>
						<td class="mobe_tit hit">1234</td>
					</tr>
					<tr>
						<td class="num">5</td>
						<td class="tt"><a href="{{ route('notices.show', 5) }}">홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..</a></td>
						<td class="mobe_tit name">오유림</td>
						<td class="mobe_tit date">2024.07.11</td>
						<td class="mobe_tit hit">1234</td>
					</tr>
					<tr>
						<td class="num">4</td>
						<td class="tt"><a href="{{ route('notices.show', 4) }}">홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..</a></td>
						<td class="mobe_tit name">오유림</td>
						<td class="mobe_tit date">2024.07.11</td>
						<td class="mobe_tit hit">1234</td>
					</tr>
					<tr>
						<td class="num">3</td>
						<td class="tt"><a href="{{ route('notices.show', 3) }}">홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..</a></td>
						<td class="mobe_tit name">오유림</td>
						<td class="mobe_tit date">2024.07.11</td>
						<td class="mobe_tit hit">1234</td>
					</tr>
					<tr>
						<td class="num">2</td>
						<td class="tt"><a href="{{ route('notices.show', 2) }}">홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..</a></td>
						<td class="mobe_tit name">오유림</td>
						<td class="mobe_tit date">2024.07.11</td>
						<td class="mobe_tit hit">1234</td>
					</tr>
					<tr>
						<td class="num">1</td>
						<td class="tt"><a href="{{ route('notices.show', 1) }}">홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이지코리아 설날휴무로 인한 업무시간 안내드립니다. 홈페이..</a></td>
						<td class="mobe_tit name">오유림</td>
						<td class="mobe_tit date">2024.07.11</td>
						<td class="mobe_tit hit">1234</td>
					</tr>
				</tbody>
			</table>
		</div>

		@if(isset($notices))
		<x-pagination :paginator="$notices" />
		@endif
	</div>

</div>
@endsection
