@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush

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
                전체요청 <strong>{{ $statistics['totalCount'] ?? 0 }}</strong>
            </a>
            <a href="{{ route('admin.maintenance-requests.index', ['status' => 'received']) }}" class="btn {{ request('status') == 'received' ? 'on' : '' }}">
                접수<strong>{{ $statistics['receivedCount'] ?? 0 }}</strong>
            </a>
            <a href="{{ route('admin.maintenance-requests.index', ['status' => 'manpower_request']) }}" class="btn {{ request('status') == 'manpower_request' ? 'on' : '' }}">
                공수확인요청<strong>{{ $statistics['manpowerRequestCount'] ?? 0 }}</strong>
            </a>
            <a href="{{ route('admin.maintenance-requests.index', ['status' => 'manpower_completed']) }}" class="btn {{ request('status') == 'manpower_completed' ? 'on' : '' }}">
                공수확인완료<strong>{{ $statistics['manpowerCompletedCount'] ?? 0 }}</strong>
            </a>
            <a href="{{ route('admin.maintenance-requests.index', ['status' => 'in_progress']) }}" class="btn {{ request('status') == 'in_progress' ? 'on' : '' }}">
                진행중<strong>{{ $statistics['inProgressCount'] ?? 0 }}</strong>
            </a>
            <a href="{{ route('admin.maintenance-requests.index', ['status' => 're_request']) }}" class="btn {{ request('status') == 're_request' ? 'on' : '' }}">
                재요청<strong>{{ $statistics['reRequestCount'] ?? 0 }}</strong>
            </a>
        </div>

        <div class="board_top long_set">
            <div class="total">총 <strong class="col_blue">{{ $statistics['totalCount'] ?? 0 }}</strong>개의 게시글</div>
            <div class="inputs">
                <form method="GET" action="{{ route('admin.maintenance-requests.index') }}">
                    <select name="client_id" class="text mr">
                        <option value="">고객사명</option>                     
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
                    <select name="per_page" class="text ml" onchange="this.form.submit()">
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
                    <col class="w10">
                    <col class="w10">
                    <col class="w10">
                    <col class="w10">
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
                    <tr>
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
                                {{ $requests->total() - (($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration - 1) }}
                            @endif
                        </td>
                        <td class="statebox">
                            <span class="state i{{ $request->status_id }}">
                                {{ $request->status->name ?? '접수' }}
                            </span>
                        </td>
                        <td class="mobe_tit customer">{{ Str::limit($request->user->name ?? '', limit: 20) }}</td>
                        <td class="mobe_tit type">{{ Str::limit($request->maintenanceType->name ?? '', 15) }}</td>
                        <td class="tt">
                            <a href="{{ route('admin.maintenance-requests.show', $request->idx) }}">
                                {{ Str::limit($request->title, 50) }}...
                            </a>
                        </td>
                        <td class="mobe_tit writer">{{ $request->user->name ?? '' }}</td>
                        <td class="mobe_tit date_recep">{{ $request->created_at ? $request->created_at->format('Y.m.d') : '' }}</td>
                        <td class="mobe_tit date_sched">{{ $request->expected_date ? $request->expected_date->format('Y.m.d') : '' }}</td>
                        <td class="mobe_tit manager">{{ $request->manager->name ?? '' }}</td>
                        <td class="mobe_tit worker">{{ $request->worker->name ?? '' }}</td>
                        <td class="note">
                            <a href="javascript:void(0);" onclick="showNotesModal({{ $request->idx }})" class="btn_note">보기</a>
                        </td>
                        <td class="mobe_tit date_end">{{ $request->completed_date ? $request->completed_date->format('Y.m.d') : '' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="tac">등록된 유지보수 요청이 없습니다.</td>
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

<!-- 노트 모달 -->
<div class="popup pop_notes" style="display: none;">
    <div class="dm"></div>
    <div class="pop_fancy pop_note">
        <a href="javascript:void(0);" class="btn_close" onclick="closeNotesModal()">닫기</a>
        <div class="tit">비고</div>
        <div class="con" id="notes_list_content"></div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/maintenance-requests-index.js') }}"></script>
@endpush
