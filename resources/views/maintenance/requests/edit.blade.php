@extends('layouts.app')

@section('title', '유지보수 요청 수정')

@section('content')
<div id="mainContent" class="container sub_wrap">
	<div class="inner">
		<div class="input_area">
			<a href="javascript:history.back();" class="goback">뒤로</a>
			<div class="title">{{ $gName ?? '유지보수 요청' }}</div>

			<form action="{{ route('maintenance.requests.update', $request->idx) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<dl>
					<dt>작성자 <span class="col_red2">*</span></dt>
					<dd>
						<select name="user_id" class="text w100p">
							@foreach($users ?? [] as $user)
							<option value="{{ $user->idx }}" @if($user->idx == $request->user_id) selected @endif>{{ $user->name }}</option>
							@endforeach
						</select>
						<p>*다양한 요청사항을 남겨주실 경우 작업자별로 확인이 필요하여 처리가 지연될수 있으므로 <br class="pc_vw">유지보수 종류별로 각각 접수 부탁 드립니다.</p>
					</dd>
				</dl>
				<dl>
					<dt>유지보수 종류 <span class="col_red2">*</span></dt>
					<dd>
						<select name="maintenance_type_id" class="text w100p">
							<option value="">선택해주세요</option>
							@foreach($maintenanceTypes ?? [] as $type)
							<option value="{{ $type->idx }}" @if($type->idx == $request->maintenance_type_id) selected @endif>{{ $type->name }}</option>
							@endforeach
						</select>
						<p>* 선택해주신 담당자님의 이메일로 작업 관련 메일이 발송됩니다. 담당자 정보변경은 계정 관리에서 가능합니다.</p>
					</dd>
				</dl>
				<dl>
					<dt>상태 <span class="col_red2">*</span></dt>
					<dd>
						<select name="status_id" class="text w100p">
							@foreach($requestStatuses ?? [] as $status)
							<option value="{{ $status->idx }}" @if($status->idx == $request->status_id) selected @endif>{{ $status->name }}</option>
							@endforeach
						</select>
					</dd>
				</dl>
				<dl>
					<dt>담당자</dt>
					<dd>
						<select name="assigned_user_id" class="text w100p">
							<option value="">미배정</option>
							@foreach($users ?? [] as $user)
							<option value="{{ $user->idx }}" @if($user->idx == $request->assigned_user_id) selected @endif>{{ $user->name }}</option>
							@endforeach
						</select>
					</dd>
				</dl>
				<dl>
					<dt>요청 제목 <span class="col_red2">*</span></dt>
					<dd><input type="text" name="title" class="text w100p" value="{{ old('title', $request->title) }}" placeholder="제목을 입력해주세요"></dd>
				</dl>
				<dl>
					<dt>내용 <span class="col_red2">*</span></dt>
					<dd>
						<textarea name="content" cols="30" rows="10" class="text w100p" placeholder="홈페이지 내 콘텐츠의 수정이 필요한 페이지 URL과 수정(추가/변경/삭제) 내용을 입력해주세요.
요청내용이 많을 경우, 첨부파일로 첨부해주셔도 됩니다.
[입력내용]
- 수정요청 페이지 URL :
- 요청내용(필수) :">{{ old('content', $request->content) }}</textarea>
					</dd>
				</dl>
				<dl>
					<dt>첨부파일</dt>
					<dd>
						@if($request->attachments && $request->attachments->count() > 0)
						<div class="existing_files">
							<p>기존 첨부파일:</p>
							@foreach($request->attachments as $attachment)
							<div class="file_item">
								<a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">{{ $attachment->original_name }}</a>
								<button type="button" class="btn_del" onclick="deleteAttachment({{ $attachment->idx }})">삭제</button>
							</div>
							@endforeach
						</div>
						@endif
						<label class="file">
							<input type="file" name="attachments[]" id="file-input" multiple>
							<span class="tt">첨부파일 업로드</span>
							<p>파일 1개당 최대 20MB까지 업로드 가능 (최대 3개까지 첨부 가능)</p>
							<i>파일첨부</i>
						</label>
						<div class="file_box"></div>
					</dd>
				</dl>
				<dl>
					<dt>스크린샷</dt>
					<dd>
						<div class="screenshot_box">
							<div class="screen"><label><input type="file" name="screenshots[]" class="file-input" accept="image/*"><span class="box"><span class="imgfit"></span></span></label></div>
							<div class="screen"><label><input type="file" name="screenshots[]" class="file-input" accept="image/*"><span class="box"><span class="imgfit"></span></span></label></div>
							<div class="screen"><label><input type="file" name="screenshots[]" class="file-input" accept="image/*"><span class="box"><span class="imgfit"></span></span></label></div>
							<div class="screen"><label><input type="file" name="screenshots[]" class="file-input" accept="image/*"><span class="box"><span class="imgfit"></span></span></label></div>
							<div class="screen"><label><input type="file" name="screenshots[]" class="file-input" accept="image/*"><span class="box"><span class="imgfit"></span></span></label></div>
						</div>
						<p>*jpg, png 형식 첨부, 파일 1개당 최대 1MB까지 업로드 가능 (최대 5개까지 첨부 가능)</p>
					</dd>
				</dl>
				<button type="submit" class="btn">저장</button>
			</form>
		</div>
	</div>
</div>

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
	//첨부파일
	var maxFiles = 3;
	var uploadedFiles = [];

	$('#file-input').on('change', function(e) {
		var files = e.target.files;
		var fileBox = $('.file_box');
		var currentFiles = fileBox.children('button').length;
		if (files.length + currentFiles > maxFiles) {
			alert('최대 ' + maxFiles + '개의 파일만 업로드할 수 있습니다.');
			return;
		}
		for (var i = 0; i < files.length; i++) {
			if (currentFiles >= maxFiles) {
				break;
			}
			var fileName = files[i].name;
			var fileIndex = uploadedFiles.length;
			uploadedFiles.push(files[i]);
			var fileButton = $('<button type="button" class="del">' + fileName + '</button>');
			fileButton.data('index', fileIndex);
			fileButton.on('click', function() {
				var index = $(this).data('index');
				uploadedFiles.splice(index, 1);
				$(this).remove();
			});
			fileBox.append(fileButton);
			currentFiles++;
		}
	});
});

function deleteAttachment(attachmentId) {
	if (confirm('첨부파일을 삭제하시겠습니까?')) {
		// AJAX로 첨부파일 삭제 요청
		$.ajax({
			url: '/maintenance/attachments/' + attachmentId,
			type: 'DELETE',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				location.reload();
			},
			error: function(xhr) {
				alert('삭제 중 오류가 발생했습니다.');
			}
		});
	}
}
</script>
@endpush
@endsection
