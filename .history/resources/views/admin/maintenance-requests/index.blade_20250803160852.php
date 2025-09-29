@extends('layouts.app')

@section('title', '유지보수 요청')

@section('content')
<div id="mainContent" class="container sub_wrap maintenance_requests_wrap">

    <div class="inner">
        <div class="title">유지보수 요청
            <a href="{{ route('admin.maintenance-requests.create') }}" class="btn_write">유지보수 요청하기</a>
        </div>

        <div class="btit">처리현황
            <a href="javascript:void(0);" class="btn_state btn_state01">처리현황(과정)안내</a>
        </div>
        <div class="state_area">
            <a href="{{ route('admin.maintenance-requests.index') }}" class="btn {{ request('status') == '' ? 'on' : '' }}">
                전체요청 <strong>{{ $totalCount ?? 9 }}</strong>
            </a>
            <a href="{{ route('admin.maintenance-requests.index', ['status' => 'received']) }}" class="btn {{ request('status') == 'received' ? 'on' : '' }}">
                접수<strong>{{ $receivedCount ?? 4 }}</strong>
            </a>
            <a href="{{ route('admin.maintenance-requests.index', ['status' => 'manpower_request']) }}" class="btn {{ request('status') == 'manpower_request' ? 'on' : '' }}">
                공수확인요청<strong>{{ $manpowerRequestCount ?? 2 }}</strong>
            </a>
            <a href="{{ route('admin.maintenance-requests.index', ['status' => 'manpower_completed']) }}" class="btn {{ request('status') == 'manpower_completed' ? 'on' : '' }}">
                공수확인완료<strong>{{ $manpowerCompletedCount ?? 1 }}</strong>
            </a>
            <a href="{{ route('admin.maintenance-requests.index', ['status' => 'in_progress']) }}" class="btn {{ request('status') == 'in_progress' ? 'on' : '' }}">
                진행중<strong>{{ $inProgressCount ?? 1 }}</strong>
            </a>
            <a href="{{ route('admin.maintenance-requests.index', ['status' => 're_request']) }}" class="btn {{ request('status') == 're_request' ? 'on' : '' }}">
                재요청<strong>{{ $reRequestCount ?? 1 }}</strong>
            </a>
        </div>

        <div class="board_top long_set">
            <div class="total">총 <strong class="col_blue">{{ $totalCount ?? 3243 }}</strong>개의 게시글</div>
            <div class="inputs">
                <form method="GET" action="{{ route('admin.maintenance-requests.index') }}">
                    <select name="client_id" class="text mr">
                        <option value="">고객사명</option>
                        @foreach($clients ?? [] as $client)
                        <option value="{{ $client->idx }}" {{ request('client_id') == $client->idx ? 'selected' : '' }}>
                            {{ $client->company_name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="datepicker_area">
                        <input type="text" class="text datepicker datepicker_start" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <span class="bar"></span>
                    <div class="datepicker_area">
                        <input type="text" class="text datepicker datepicker_end" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <input type="text" class="text input" name="search" placeholder="제목, 작성자로 검색이 가능합니다." value="{{ request('search') }}">
                    <button type="submit" class="btn">조회</button>
                    <select name="per_page" class="text ml">
                        <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20개씩 보기</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50개씩 보기</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100개씩 보기</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="board_list tablet_break chk_board">
            <table>
                <colgroup>
                    <col class="w4">
                    <col class="w7">
                    <col class="w10">
                    <col class="w11">
                    <col class="w11">
                    <col width="*">
                    <col class="w6">
                    <col class="w9">
                    <col class="w9">
                    <col class="w6">
                    <col class="w10">
                    <col class="w5">
                    <col class="w9">
                </colgroup>
                <thead>
                    <tr>
                        <th class="chk"><label class="check solo"><input type="checkbox" id="allCheck"><i></i></label></th>
                        <th>No.</th>
                        <th>상태</th>
                        <th>고객사명</th>
                        <th>유지보수 종류</th>
                        <th>제목</th>
                        <th>작성자</th>
                        <th>접수일</th>
                        <th>처리예정일</th>
                        <th>담당자</th>
                        <th>작업자</th>
                        <th>비고</th>
                        <th>완료일</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests ?? [] as $request)
                    <tr class="{{ $request->is_urgent ? 'hot' : '' }}">
                        <td class="chk">
                            <label class="check solo">
                                <input type="checkbox" name="check" value="{{ $request->idx }}">
                                <i></i>
                            </label>
                        </td>
                        <td class="tac num">
                            @if($request->is_urgent)
                            <i class="icon">🔥긴급</i>
                            @else
                            {{ $request->idx }}
                            @endif
                        </td>
                        <td class="statebox">
                            <span class="state i{{ $request->status_id ?? 1 }}">
                                {{ $request->status_name ?? '접수' }}
                            </span>
                        </td>
                        <td class="mobe_tit customer">{{ Str::limit($request->client_name ?? '강동성심병원', 10) }}...</td>
                        <td class="mobe_tit type">{{ $request->maintenance_type_name ?? '콘텐츠 수정' }}</td>
                        <td class="tt">
                            <a href="{{ route('admin.maintenance-requests.show', $request->idx) }}">
                                {{ Str::limit($request->title ?? '간호간병통합서비스 병동 홈페이지 게시물 수정요청건', 50) }}...
                            </a>
                        </td>
                        <td class="mobe_tit writer">{{ $request->writer_name ?? '허지선' }}</td>
                        <td class="mobe_tit date_recep">{{ $request->created_at ? $request->created_at->format('Y.m.d') : '2024.07.11' }}</td>
                        <td class="mobe_tit date_sched">{{ $request->scheduled_date ? $request->scheduled_date->format('Y.m.d') : '2024.07.11' }}</td>
                        <td class="mobe_tit manager">{{ $request->manager_name ?? '강심장' }}</td>
                        <td class="mobe_tit worker">{{ $request->worker_names ?? '지현수,오유림' }}</td>
                        <td class="note">
                            <a href="{{ route('admin.maintenance-requests.notes', $request->idx) }}" class="btn_note fancybox fancybox.ajax">보기</a>
                        </td>
                        <td class="mobe_tit date_end">{{ $request->completed_at ? $request->completed_at->format('Y.m.d') : '' }}</td>
                    </tr>
                    @empty
                    <tr class="hot">
                        <td class="chk">
                            <label class="check solo">
                                <input type="checkbox" name="check" value="1">
                                <i></i>
                            </label>
                        </td>
                        <td class="tac num"><i class="icon">🔥긴급</i></td>
                        <td class="statebox"><span class="state i1">접수</span></td>
                        <td class="mobe_tit customer">강동성심병원...</td>
                        <td class="mobe_tit type">콘텐츠 수정</td>
                        <td class="tt">
                            <a href="{{ route('admin.maintenance-requests.show', 1) }}">
                                간호간병통합서비스 병동 홈페이지 게시물 수정요청건...
                            </a>
                        </td>
                        <td class="mobe_tit writer">허지선</td>
                        <td class="mobe_tit date_recep">2024.07.11</td>
                        <td class="mobe_tit date_sched">2024.07.11</td>
                        <td class="mobe_tit manager">강심장</td>
                        <td class="mobe_tit worker">지현수,오유림</td>
                        <td class="note">
                            <a href="{{ route('admin.maintenance-requests.notes', 1) }}" class="btn_note fancybox fancybox.ajax">보기</a>
                        </td>
                        <td class="mobe_tit date_end">2024.07.11</td>
                    </tr>
                    <tr class="hot">
                        <td class="chk">
                            <label class="check solo">
                                <input type="checkbox" name="check" value="2">
                                <i></i>
                            </label>
                        </td>
                        <td class="tac num"><i class="icon">🔥긴급</i></td>
                        <td class="statebox"><span class="state i4">진행중</span></td>
                        <td class="mobe_tit customer">강동성심병원...</td>
                        <td class="mobe_tit type">메일, 뉴스레터 발송</td>
                        <td class="tt">
                            <a href="{{ route('admin.maintenance-requests.show', 2) }}">
                                제15회 DAWAS 뉴스레터 발송의 건
                            </a>
                        </td>
                        <td class="mobe_tit writer">허지선</td>
                        <td class="mobe_tit date_recep">2024.07.11</td>
                        <td class="mobe_tit date_sched">2024.07.11</td>
                        <td class="mobe_tit manager">강심장</td>
                        <td class="mobe_tit worker">지현수,오유림</td>
                        <td class="note">
                            <a href="{{ route('admin.maintenance-requests.notes', 2) }}" class="btn_note fancybox fancybox.ajax">보기</a>
                        </td>
                        <td class="mobe_tit date_end">2024.07.11</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="board_bottom">
            <x-pagination :paginator="$requests" />
        </div>
    </div>
</div>

<div class="popup pop_state01">
    <div class="dm"></div>
    <div class="inbox">
        <a href="javascript:void(0);" class="btn_close">닫기</a>
        <div class="tit">처리과정(상태) 안내</div>
        <div class="state_step">
            <dl class="c1">
                <dt>접수</dt>
                <dd>요청이 접수되었습니다.<br>
                    요청내용 확인 및 공수파악 후 담당자가 배정됩니다.<br>
                    <p class="col_blue">* 금요일 오후 2시 이후 접수 건은 월요일부터 순차적으로 확인합니다.</p>
                </dd>
            </dl>
            <dl class="c1">
                <dt>진행중</dt>
                <dd>작업이 진행중입니다. 작업 진행 중 상태에서는 <br>
                    요청내용 수정이 불가능합니다.<br>
                    요청한 작업에 추가사항이 있을 경우, 댓글로 요청 부탁드립니다.
                </dd>
            </dl>
            <dl class="c1">
                <dt>완료</dt>
                <dd>작업이 완료되었습니다.<br>
                    완료된 작업에 대한 확인 및 추가 요청사항이 있을 경우, 댓글로 요청 부탁드립니다.
                </dd>
            </dl>
        </div>
    </div>
</div>
@endsection
