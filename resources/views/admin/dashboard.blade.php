@extends('layouts.app')

@section('content')
<div id="mainContent" class="container main_wrap">

	<div class="admin_info mo_vw">
		<span>관리자</span>
		<div class="name">{{ auth()->user()->name }}님 안녕하세요</div>
	</div>

	<div class="mo_tab_menu mo_vw">
		<a href="javascript:void(0);" class="tab01 on">요청현황</a>
		<a href="javascript:void(0);" class="tab02">고객사 목록</a>
		<a href="javascript:void(0);" class="tab03">공지사항</a>
	</div>

	<div class="info_area">
		<div class="btn_opcl">
			<button type="button" class="btn_open">열기</button>
			<button type="button" class="btn_close">닫기</button>
		</div>
		<div class="admin_wrap mo_con mo_con02">
			<div class="tit mt0">고객사 목록({{ $clients->count() ?? 0 }})</div>
			<div class="search_area">
				<input type="text" class="text" placeholder="고객사명 검색" id="clientSearch">
				<button type="button" class="btn" onclick="searchClients()">검색</button>
			</div>
			<div class="client_list">
				@foreach($clients ?? [] as $client)
				<a href="javascript:void(0);" onclick="showWorkStatistics({{ $client->idx }})">
					{{ $client->name ?? $client->company_name ?? '고객사' }}
					<span>({{ $client->maintenance_requests_count ?? 0 }})</span>
				</a>
				@endforeach
			</div>
		</div>
	</div>
	<!-- //좌측 인포 -->

	<div class="dashboard_wrap admin_set">
		<div class="list_wrap">
			<div class="wbox list_area mo_con mo_con01 on">
				<div class="mo_state_wrap">
					<button class="btn_select mo_vw">
						@if($currentStatus == 'all')
							전체요청 <strong>{{ $allRequests->count() }}</strong>
						@elseif($currentStatus == '1')
							접수 <strong>{{ $statistics['receivedCount'] }}</strong>
						@elseif($currentStatus == '2')
							공수확인요청 <strong>{{ $statistics['manpowerRequestCount'] }}</strong>
						@elseif($currentStatus == '3')
							공수확인완료 <strong>{{ $statistics['manpowerCompletedCount'] }}</strong>
						@elseif($currentStatus == '4')
							진행중 <strong>{{ $statistics['inProgressCount'] }}</strong>
						@elseif($currentStatus == '5')
							재요청 <strong>{{ $statistics['reRequestCount'] }}</strong>
						@endif
					</button>
					<div class="state_area">
						<a href="{{ route('admin.dashboard') }}" class="btn {{ $currentStatus == 'all' ? 'on' : '' }}" data-status="all">전체요청 <strong>{{ $totalRequestsCount }}</strong></a>
						<a href="{{ route('admin.dashboard', ['status' => '1']) }}" class="btn {{ $currentStatus == '1' ? 'on' : '' }}" data-status="1">접수<strong>{{ $statistics['receivedCount'] }}</strong></a>
						<a href="{{ route('admin.dashboard', ['status' => '2']) }}" class="btn {{ $currentStatus == '2' ? 'on' : '' }}" data-status="2">공수확인요청<strong>{{ $statistics['manpowerRequestCount'] }}</strong></a>
						<a href="{{ route('admin.dashboard', ['status' => '3']) }}" class="btn {{ $currentStatus == '3' ? 'on' : '' }}" data-status="3">공수확인완료<strong>{{ $statistics['manpowerCompletedCount'] }}</strong></a>
						<a href="{{ route('admin.dashboard', ['status' => '4']) }}" class="btn {{ $currentStatus == '4' ? 'on' : '' }}" data-status="4">진행중<strong>{{ $statistics['inProgressCount'] }}</strong></a>
						<a href="{{ route('admin.dashboard', ['status' => '5']) }}" class="btn {{ $currentStatus == '5' ? 'on' : '' }}" data-status="5">재요청<strong>{{ $statistics['reRequestCount'] }}</strong></a>
					</div>
				</div>
				<div class="list">
					<table>
						<colgroup>
							<col class="w7">
							<col class="w10">
							<col class="w13">
							<col class="w14">
							<col width="*">
							<col class="w10">
							<col class="w10">
							<col class="w7">
							<col class="w11">
							<col class="w6">
						</colgroup>
						<thead>
							<tr>
								<th>No.</th>
								<th>상태</th>
								<th>고객사명</th>
								<th>유지보수 종류</th>
								<th>제목</th>
								<th>접수일</th>
								<th>처리예정일</th>
								<th>담당자</th>
								<th>작업자</th>
								<th>비고</th>
							</tr>
						</thead>
					</table>
					<div class="scroll">
						<table>
							<colgroup>
								<col class="w7">
								<col class="w10">
								<col class="w13">
								<col class="w14">
								<col width="*">
								<col class="w10">
								<col class="w10">
								<col class="w7">
								<col class="w11">
								<col class="w6">
							</colgroup>
							<tbody>
								@forelse($filteredRequests as $index => $request)
								<tr>
									<td class="num">{{ $totalRequestsCount - $index }}</td>
									<td class="statebox"><span class="state i{{ $request->status_id ?? 1 }}">{{ $request->status->name ?? '접수' }}</span></td>
									<td class="mobe_tit customer">{{ $request->user->name ?? '고객사' }}</td>
									<td class="type">{{ $request->maintenanceType->name ?? '콘텐츠 수정' }}</td>
									<td class="tt"><a href="{{ route('admin.maintenance-requests.show', $request->idx) }}">{{ Str::limit($request->title, 50) }}...</a></td>
									<td class="mobe_tit date_recep">{{ $request->created_at ? $request->created_at->format('Y.m.d') : '' }}</td>
									<td class="mobe_tit date_sched">{{ $request->expected_date ? $request->expected_date->format('Y.m.d') : '' }}</td>
									<td class="mobe_tit manager">{{ $request->manager->name ?? '담당자' }}</td>
									<td class="mobe_tit worker">{{ $request->worker->name ?? '작업자' }}</td>
									<td class="note"><a href="javascript:void(0);" class="btn_note" onclick="showNotesModal({{ $request->idx }})">보기</a></td>
								</tr>
								@empty
								<tr>
									<td colspan="10" class="text-center">데이터가 없습니다.</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="notice_wrap">
			<div class="wbox board1">
				<div class="stit">알림내역 <a href="{{ route('admin.notices.index') }}" class="more">더보기</a></div>
				<div class="list">
					@foreach($recentNotifications ?? [] as $notification)
					<a href="#this">
						<p>{{ $notification->message ?? 'YYYY-MM-DD에 {허지선}님이 요청주신 내역이 접수되었습니다.' }}</p>
						<span class="date">{{ $notification->created_at ? $notification->created_at->format('Y.m.d(요일)') : '2024.06.02(수)' }}</span>
					</a>
					@endforeach
					@if(empty($recentNotifications))
					<a href="#this">
						<p>YYYY-MM-DD에 {허지선}님이 요청주신 내역이 접수되었습니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
					<a href="#this">
						<p>YYYY-MM-DD에 {허지선}님이 요청주신 내역이 접수되었습니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
					<a href="#this">
						<p>YYYY-MM-DD에 {허지선}님이 요청주신 내역이 접수되었습니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
					@endif
				</div>
			</div>
			<div class="wbox board2 mo_con mo_con03">
				<div class="stit">공지사항 <a href="{{ route('admin.notices.index') }}" class="more">더보기</a></div>
				<div class="list">
					@foreach($recentNotices ?? [] as $notice)
					<a href="{{ route('admin.notices.show', $notice->idx) }}">
						<p>{{ $notice->title ?? '홈페이지코리아 설날휴무 입니다.' }}</p>
						<span class="date">{{ $notice->created_at ? $notice->created_at->format('Y.m.d(요일)') : '2024.06.02(수)' }}</span>
					</a>
					@endforeach
					@if(empty($recentNotices))
					<a href="#this">
						<p>홈페이지코리아 설날휴무 입니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
					<a href="#this">
						<p>홈페이지코리아 설날휴무 입니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
					<a href="#this">
						<p>홈페이지코리아 설날휴무 입니다.</p>
						<span class="date">2024.06.02(수)</span>
					</a>
					@endif
				</div>
			</div>
		</div>

		<div class="popup pop_work_statistics">
			<div class="dm"></div>
			<div class="inbox">
				<a href="javascript:void(0);" class="btn_close">닫기</a>
				<div class="tit" id="workStatisticsTitle">고객사 작업통계</div>
				<div class="con">
					<dl class="date">
						<dt>계약기간</dt>
						<dd id="workStatisticsPeriod">2024.01.11~2025.01.11</dd>
					</dl>
					<div class="stit">
						<div class="month_area">
							<button class="btn prev">이전달</button>
							<div class="to">{{ now()->format('Y.m') }}</div>
							<button class="btn next">다음달</button>
						</div>
					</div>
					<dl class="total">
						<dt>총 작업요청(건)</dt>
						<dd id="workStatisticsTotal">0</dd>
					</dl>
					<div class="ptit">계약공수(h)</div>
					<table>
						<tbody>
							<tr>
								<th>PM,기획</th>
								<td id="contractPmHours">0</td>
							</tr>
							<tr>
								<th>디자인</th>
								<td id="contractDesignHours">0</td>
							</tr>
							<tr>
								<th>퍼블리싱</th>
								<td id="contractPubHours">0</td>
							</tr>
							<tr>
								<th>개발</th>
								<td id="contractDevHours">0</td>
							</tr>
						</tbody>
					</table>
					<div class="ptit">운영공수(h)</div>
					<table>
						<tbody>
							<tr>
								<th>PM,기획</th>
								<td id="operationPmHours">0</td>
							</tr>
							<tr>
								<th>디자인</th>
								<td id="operationDesignHours">0</td>
							</tr>
							<tr>
								<th>퍼블리싱</th>
								<td id="operationPubHours">0</td>
							</tr>
							<tr>
								<th>개발</th>
								<td id="operationDevHours">0</td>
							</tr>
						</tbody>
					</table>
					<div class="ptit">잔여공수(h)</div>
					<table>
						<tbody>
							<tr>
								<th>PM,기획</th>
								<td id="remainingPmHours">0</td>
							</tr>
							<tr>
								<th>디자인</th>
								<td id="remainingDesignHours">0</td>
							</tr>
							<tr>
								<th>퍼블리싱</th>
								<td id="remainingPubHours">0</td>
							</tr>
							<tr>
								<th>개발</th>
								<td id="remainingDevHours">0</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- 비고 모달 -->
		<div class="popup pop_note">
			<div class="dm"></div>
			<div class="inbox">
				<a href="javascript:void(0);" class="btn_close" onclick="closeNotesModal()">닫기</a>
				<div class="tit">비고</div>
				<div class="con">
					<div class="note_content" id="noteContent">
						기능추가에 대한 견적서 요청 6/18 접수됨<br>
						공수개발 1.5일 / 퍼블 2일 / 견적서 안내 완료<br>
						25일 실서버 반영예정<br>
						다시 기능개발 담당자 : 권대리님
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush
