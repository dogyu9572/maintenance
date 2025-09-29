@extends('layouts.app')

@section('title', '유지보수 요청 상세')

@section('content')
<div class="container sub_wrap pb0">
    <div class="inner">
        <a href="javascript:history.back();" class="goback">뒤로</a>
        <div class="title">유지보수 요청</div>

        <div class="maintenance_info">
            <dl class="c1">
                <dt>요청상태</dt>
                <dd>
                    <select name="status_id" id="status_id" class="text">
                        <option value="">상태</option>
                        @foreach($statuses ?? [] as $status)
                        <option value="{{ $status->idx }}" {{ $request->status_id == $status->idx ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                        @endforeach
                    </select>
                </dd>
            </dl>
            <dl class="c2">
                <dt>담당자</dt>
                <dd>
                    <select name="manager_id" id="manager_id" class="text">
                        <option value="">담당자</option>
                        @foreach($users ?? [] as $user)
                        <option value="{{ $user->idx }}" {{ $request->manager_id == $user->idx ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </dd>
            </dl>
        </div>

        <div class="stit s mtb">작업공수 <button type="button" class="btn btn_l" onclick="saveWorkHours()">저장하기</button></div>
        <div class="work_hours glbox">
            <div class="box">
                <div class="tit">예상공수(h)</div>
                <ul>
                    <li class="{{ $request->expected_pm_hours > 0 ? 'in' : '' }}">
                        <input type="text" class="text" value="{{ $request->expected_pm_hours ?? 0 }}" id="expected_pm_hours">
                        <p>PM/기획</p>
                    </li>
                    <li class="{{ $request->expected_design_hours > 0 ? 'in' : '' }}">
                        <input type="text" class="text" value="{{ $request->expected_design_hours ?? 0 }}" id="expected_design_hours">
                        <p>디자인</p>
                    </li>
                    <li class="{{ $request->expected_pub_hours > 0 ? 'in' : '' }}">
                        <input type="text" class="text" value="{{ $request->expected_pub_hours ?? 0 }}" id="expected_pub_hours">
                        <p>퍼블리싱</p>
                    </li>
                    <li class="{{ $request->expected_dev_hours > 0 ? 'in' : '' }}">
                        <input type="text" class="text" value="{{ $request->expected_dev_hours ?? 0 }}" id="expected_dev_hours">
                        <p>개발</p>
                    </li>
                </ul>
                <button class="btn" onclick="requestWorkHours()">공수확인요청</button>
            </div>
            <div class="box">
                <div class="tit">실제공수(h)</div>
                <ul>
                    <li class="{{ $request->actual_pm_hours > 0 ? 'in' : '' }}">
                        <input type="text" class="text" value="{{ $request->actual_pm_hours ?? 0 }}" id="actual_pm_hours">
                        <p>PM/기획</p>
                    </li>
                    <li class="{{ $request->actual_design_hours > 0 ? 'in' : '' }}">
                        <input type="text" class="text" value="{{ $request->actual_design_hours ?? 0 }}" id="actual_design_hours">
                        <p>디자인</p>
                    </li>
                    <li class="{{ $request->actual_pub_hours > 0 ? 'in' : '' }}">
                        <input type="text" class="text" value="{{ $request->actual_pub_hours ?? 0 }}" id="actual_pub_hours">
                        <p>퍼블리싱</p>
                    </li>
                    <li class="{{ $request->actual_dev_hours > 0 ? 'in' : '' }}">
                        <input type="text" class="text" value="{{ $request->actual_dev_hours ?? 0 }}" id="actual_dev_hours">
                        <p>개발</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="stit s mtb">관리자 사용 <button type="button" class="btn btn_l" onclick="saveAdminSettings()">저장하기</button></div>
        <div class="board_write">
            <table>
                <tbody>
                    <tr>
                        <th>긴급</th>
                        <td><label class="check"><input type="checkbox" id="is_urgent" {{ $request->is_urgent ? 'checked' : '' }}><i></i><span class="hot">🔥긴급</span></label></td>
                    </tr>
                    <tr>
                        <th>작업자</th>
                        <td>
                            <select name="worker_id" id="worker_id" class="text w1">
                                <option value="">작업자</option>
                                @foreach($users ?? [] as $user)
                                <option value="{{ $user->idx }}" {{ $request->worker_id == $user->idx ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>처리예정일</th>
                        <td><div class="datepicker_area w1"><input type="text" class="text datepicker" id="expected_date" value="{{ $request->expected_date ? $request->expected_date->format('Y-m-d') : '' }}"></div></td>
                    </tr>
                    <tr>
                        <th>비고</th>
                        <td><textarea name="notes" id="notes" cols="30" rows="10" class="text w100p">{{ $request->notes ?? '' }}</textarea></td>
                    </tr>
                    <tr>
                        <th>이슈사항</th>
                        <td><textarea name="issues" id="issues" cols="30" rows="10" class="text w100p">{{ $request->issues ?? '' }}</textarea></td>
                    </tr>
                    <tr>
                        <th>제목(보고서용)</th>
                        <td><input type="text" class="text w1" id="report_title" value="{{ $request->report_title ?? '' }}"></td>
                    </tr>
                    <tr>
                        <th>진행율 (보고서용)</th>
                        <td><input type="text" class="text w2" id="progress_rate" value="{{ $request->progress_rate ?? 0 }}"> %</td>
                    </tr>
                    <tr>
                        <th>처리현황 (보고서용)</th>
                        <td>
                            <select name="progress_status" id="progress_status" class="text w1">
                                <option value="">완료</option>
                                <option value="진행중" {{ $request->progress_status == '진행중' ? 'selected' : '' }}>진행중</option>
                                <option value="대기중" {{ $request->progress_status == '대기중' ? 'selected' : '' }}>대기중</option>
                                <option value="검토중" {{ $request->progress_status == '검토중' ? 'selected' : '' }}>검토중</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="stit s mtb">요청내용</div>
        <div class="board_view glbox">
            <div class="tit">{{ $request->title }}</div>
            <div class="writer">
                <dl>
                    <dt>고객사</dt>
                    <dd>{{ $request->user->name ?? '' }}<i class="gong">✔ {{ $request->status->name ?? '접수' }}</i></dd>
                </dl>
                <dl>
                    <dt>작성자</dt>
                    <dd>{{ $request->user->name ?? '' }}/{{ $request->user->position ?? '직책' }}/{{ $request->user->phone ?? '전화번호' }}/{{ $request->user->email ?? '이메일' }}</dd>
                </dl>
                <dl>
                    <dt>유지보수 종류</dt>
                    <dd>{{ $request->maintenanceType->name ?? '' }}</dd>
                </dl>
                <dl>
                    <dt>접수일</dt>
                    <dd>{{ $request->request_date ? $request->request_date->format('Y.m.d H:i:s') : '' }}</dd>
                </dl>
            </div>
            @if($request->attachments && $request->attachments->count() > 0)
            <div class="download_file">
                @foreach($request->attachments as $attachment)
                <a href="{{ asset('storage/' . $attachment->file_path) }}" class="down" download>{{ $attachment->file_name }}</a>
                @endforeach
            </div>
            @endif
            <div class="con">
                {!! nl2br(e($request->content)) !!}
            </div>
            @if($request->images && $request->images->count() > 0)
            <div class="imgs">
                @foreach($request->images as $image)
                <i class="imgfit"><img src="{{ asset('storage/' . $image->file_path) }}" alt="image"></i>
                @endforeach
            </div>
            @endif
        </div>

        @if($request->attachments && $request->attachments->count() > 0)
        <div class="stit s mtb">첨부파일</div>
        <div class="attachments">
            @foreach($request->attachments as $attachment)
            <div class="attachment-item">
                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                    {{ $attachment->file_name }}
                </a>
                <span class="file-size">({{ number_format($attachment->file_size / 1024, 2) }} KB)</span>
            </div>
            @endforeach
        </div>
        @endif

        <div class="gbox reply_area">
            <div class="inner">
                <div class="stit s">댓글·답변</div>
                
                @if($request->comments && $request->comments->count() > 0)
                @foreach($request->comments->where('parent_id', null) as $comment)
                <div class="wbox">
                    <div class="tit">
                        <span class="state {{ $comment->type }}">
                            @if($comment->type == 'comment') 댓글
                            @elseif($comment->type == 'reply') 답변
                            @elseif($comment->type == 'rework') 재요청
                            @elseif($comment->type == 'complete') 작업완료
                            @else 댓글
                            @endif
                        </span>
                        {{ $comment->user->name ?? '' }} / {{ $comment->user->position ?? '직책' }} / {{ $comment->user->phone ?? '전화번호' }} / {{ $comment->user->email ?? '이메일' }} / {{ $comment->created_at ? $comment->created_at->format('Y.m.d H:i:s') : '' }}
                        @if(Auth::id() == $comment->user_id)
                        <div class="btns">
                            <button type="button" class="btn btn_l" onclick="editComment({{ $comment->idx }})">수정</button>
                            <button type="button" class="btn btn_l" onclick="deleteComment({{ $comment->idx }})">삭제</button>
                        </div>
                        @endif
                    </div>
                    <div class="con" id="comment-content-{{ $comment->idx }}">
                        {!! nl2br(e($comment->content)) !!}
                    </div>
                    <div class="con" id="comment-edit-{{ $comment->idx }}" style="display: none;">
                        <textarea class="text w100p" rows="10" id="edit-content-{{ $comment->idx }}">{{ $comment->content }}</textarea>
                        <div class="btn-group" style="margin-top: 10px;">
                            <button type="button" class="btn btn_l" onclick="updateComment({{ $comment->idx }})">저장</button>
                            <button type="button" class="btn btn_l" onclick="cancelEdit({{ $comment->idx }})">취소</button>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

                <!-- 댓글 작성 폼 -->
                <div class="wbox">
                    <div class="tit">{{ Auth::user()->name ?? '사용자' }} / {{ date('Y.m.d H:i:s') }} <button type="button" class="btn btn_b" onclick="addComment()">작업완료</button></div>
                    <div class="con">
                        <textarea id="comment_content" placeholder="댓글을 입력하세요..." class="text w100p" rows="10"></textarea>
                    </div>
                </div>

                <a href="{{ route('admin.maintenance-requests.index') }}" class="btn_list">목록</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 유지보수 요청 ID를 전역 변수로 설정
const maintenanceRequestId = {{ $request->idx }};
</script>
<script src="{{ asset('js/pages/maintenance-requests-show.js') }}"></script>
@endpush
