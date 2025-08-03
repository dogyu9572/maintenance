@extends('layouts.app')

@section('title', '유지보수 요청 상세')

@section('content')
<div id="mainContent" class="container sub_wrap pb0">
	<div class="inner">
		<a href="javascript:history.back();" class="goback">뒤로</a>
		<div class="title">{{ $gName ?? '유지보수 요청' }}</div>

		<div class="maintenance_info">
			<dl class="c1">
				<dt>요청상태</dt>
				<dd>{{ $request->status->name ?? '접수' }}</dd>
			</dl>
			<dl class="c2">
				<dt>담당자</dt>
				<dd>{{ $request->assignedUser->name ?? '미배정' }}</dd>
			</dl>
		</div>

		<div class="stit s mtb">작업공수</div>
		<div class="work_hours glbox">
			<div class="box">
				<div class="tit">예상공수(h)</div>
				<ul>
					<li class="{{ ($request->estimated_pm_hours ?? 0) > 0 ? 'in' : '' }}">
						<strong>{{ $request->estimated_pm_hours ?? 0 }}</strong>
						<p>PM/기획</p>
					</li>
					<li class="{{ ($request->estimated_design_hours ?? 0) > 0 ? 'in' : '' }}">
						<strong>{{ $request->estimated_design_hours ?? 0 }}</strong>
						<p>디자인</p>
					</li>
					<li class="{{ ($request->estimated_publishing_hours ?? 0) > 0 ? 'in' : '' }}">
						<strong>{{ $request->estimated_publishing_hours ?? 0 }}</strong>
						<p>퍼블리싱</p>
					</li>
					<li class="{{ ($request->estimated_development_hours ?? 0) > 0 ? 'in' : '' }}">
						<strong>{{ $request->estimated_development_hours ?? 0 }}</strong>
						<p>개발</p>
					</li>
				</ul>
				<button class="btn">예상공수 확인<span>공수확인 버튼을 눌러주세요.</span></button>
			</div>
			<div class="box">
				<div class="tit">실제공수(h)</div>
				<ul>
					<li class="{{ ($request->actual_pm_hours ?? 0) > 0 ? 'in' : '' }}">
						<strong>{{ $request->actual_pm_hours ?? 0 }}</strong>
						<p>PM/기획</p>
					</li>
					<li class="{{ ($request->actual_design_hours ?? 0) > 0 ? 'in' : '' }}">
						<strong>{{ $request->actual_design_hours ?? 0 }}</strong>
						<p>디자인</p>
					</li>
					<li class="{{ ($request->actual_publishing_hours ?? 0) > 0 ? 'in' : '' }}">
						<strong>{{ $request->actual_publishing_hours ?? 0 }}</strong>
						<p>퍼블리싱</p>
					</li>
					<li class="{{ ($request->actual_development_hours ?? 0) > 0 ? 'in' : '' }}">
						<strong>{{ $request->actual_development_hours ?? 0 }}</strong>
						<p>개발</p>
					</li>
				</ul>
			</div>
		</div>

		<div class="stit s mtb">요청내용</div>
		<div class="board_view glbox">
			<div class="tit">{{ $request->title }}</div>
			<div class="writer">
				<dl>
					<dt>작성자</dt>
					<dd>{{ $request->user->name ?? '미지정' }}/{{ $request->user->position ?? '' }}/{{ $request->user->phone ?? '' }}/{{ $request->user->email ?? '' }}</dd>
				</dl>
				<dl>
					<dt>유지보수 종류</dt>
					<dd>{{ $request->maintenanceType->name ?? '미지정' }}</dd>
				</dl>
				<dl>
					<dt>접수일</dt>
					<dd>{{ $request->created_at ? $request->created_at->format('Y.m.d H:i:s') : '2024.06.24 15:54:45' }}</dd>
				</dl>
			</div>
			@if($request->attachments && $request->attachments->count() > 0)
			<div class="download_file">
				@foreach($request->attachments as $attachment)
				<a href="{{ asset('storage/' . $attachment->file_path) }}" class="down" download>{{ $attachment->original_name }}</a>
				@endforeach
			</div>
			@endif
			<div class="con">
				{!! nl2br(e($request->content)) !!}
			</div>
			@if($request->attachments && $request->attachments->where('mime_type', 'like', 'image/%')->count() > 0)
			<div class="imgs">
				@foreach($request->attachments->where('mime_type', 'like', 'image/%') as $attachment)
				<i class="imgfit"><img src="{{ asset('storage/' . $attachment->file_path) }}" alt="image"></i>
				@endforeach
			</div>
			@endif
		</div>
	</div>

	<div class="gbox reply_area">
		<div class="inner">
			<div class="stit s">댓글·답변</div>

			<!-- 답변 입력 폼 -->
			@if(auth()->check())
			<div class="wbox">
				<form method="POST" action="{{ route('maintenance.requests.comments.store', $request->idx) }}">
					@csrf
					<div class="tit">
						<select name="comment_type" class="text">
							<option value="comment">댓글</option>
							<option value="reply">답변</option>
							<option value="rework">재요청</option>
							<option value="complete">작업완료</option>
						</select>
						<button type="submit" class="btn">저장</button>
					</div>
					<div class="con">
						<textarea name="content" cols="30" rows="10" class="text w100p" placeholder="댓글을 입력하세요..."></textarea>
					</div>
				</form>
			</div>
			@endif

			<!-- 댓글 목록 -->
			@forelse($request->comments ?? [] as $comment)
			<div class="wbox">
				<div class="tit">
					<span class="state {{ $comment->type ?? 'reply' }}">{{ $comment->getTypeName() }}</span>
					{{ $comment->user->name ?? '미지정' }} / {{ $comment->user->position ?? '' }} / {{ $comment->user->phone ?? '' }} / {{ $comment->user->email ?? '' }} / {{ $comment->created_at ? $comment->created_at->format('Y.m.d H:i:s') : '' }}
					@if(auth()->check() && (auth()->id() == $comment->user_id || auth()->user()->is_admin))
					<div class="btns">
						<button type="button" class="btn btn_l edit-comment" data-comment-id="{{ $comment->idx }}">수정</button>
						<form method="POST" action="{{ route('maintenance.requests.comments.destroy', [$request->idx, $comment->idx]) }}" style="display: inline;">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn_l" onclick="return confirm('정말 삭제하시겠습니까?')">삭제</button>
						</form>
					</div>
					@endif
				</div>
				<div class="con">
					{!! nl2br(e($comment->content)) !!}
				</div>
			</div>
			@empty
			<div class="wbox">
				<div class="con">
					<p>등록된 댓글이 없습니다.</p>
				</div>
			</div>
			@endforelse

			<a href="{{ route('maintenance.requests.index') }}" class="btn_list">목록</a>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // 예상공수 섹션에 대해 처리
    $('.work_hours .box ul li').each(function() {
        var strongValue = parseInt($(this).find('strong').text());
        if (strongValue !== 0) {
            $(this).addClass('in');
        }
    });
});
</script>
@endpush
