@extends('layouts.app')

@section('title', '유지보수 요청 작성')

@section('content')
<div id="mainContent" class="container sub_wrap">
	<div class="inner">
		<div class="input_area">
			<a href="javascript:history.back();" class="goback">뒤로</a>
			<div class="title">{{ $gName ?? '유지보수 요청' }}</div>

			<dl>
				<dt>작성자 <span class="col_red2">*</span></dt>
				<dd>
					<select name="" id="" class="text w100p">
						<option value="">허지선</option>
					</select>
					<p>*다양한 요청사항을 남겨주실 경우 작업자별로 확인이 필요하여 처리가 지연될수 있으므로 <br class="pc_vw">유지보수 종류별로 각각 접수 부탁 드립니다.</p>
				</dd>
			</dl>
			<dl>
				<dt>유지보수 종류 <span class="col_red2">*</span></dt>
				<dd>
					<select name="" id="" class="text w100p">
						<option value="">콘텐츠 수정</option>
					</select>
					<p>* 선택해주신 담당자님의 이메일로 작업 관련 메일이 발송됩니다. 담당자 정보변경은 계정 관리에서 가능합니다.</p>
				</dd>
			</dl>
			<dl>
				<dt>요청 제목 <span class="col_red2">*</span></dt>
				<dd><input type="text" class="text w100p" value="제목입니다"></dd>
			</dl>
			<dl>
				<dt>내용 <span class="col_red2">*</span></dt>
				<dd>
					<textarea name="" id="" cols="30" rows="10" class="text w100p" placeholder="홈페이지 내 콘텐츠의 수정이 필요한 페이지 URL과 수정(추가/변경/삭제) 내용을 입력해주세요.
요청내용이 많을 경우, 첨부파일로 첨부해주셔도 됩니다.
[입력내용]
- 수정요청 페이지 URL :
- 요청내용(필수) :"></textarea>
				</dd>
			</dl>
			<dl>
				<dt>첨부파일</dt>
				<dd>
					<label class="file">
						<input type="file" id="file-input" multiple>
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
						<div class="screen"><label><input type="file" class="file-input"><span class="box"><span class="imgfit"></span></span></label></div>
						<div class="screen"><label><input type="file" class="file-input"><span class="box"><span class="imgfit"></span></span></label></div>
						<div class="screen"><label><input type="file" class="file-input"><span class="box"><span class="imgfit"></span></span></label></div>
						<div class="screen"><label><input type="file" class="file-input"><span class="box"><span class="imgfit"></span></span></label></div>
						<div class="screen"><label><input type="file" class="file-input"><span class="box"><span class="imgfit"></span></span></label></div>
					</div>
					<p>*jpg, png 형식 첨부, 파일 1개당 최대 1MB까지 업로드 가능 (최대 5개까지 첨부 가능)</p>
				</dd>
			</dl>
			<button type="submit" class="btn">저장</button>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
//<![CDATA[
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
            var fileIndex = uploadedFiles.length;  // 파일 인덱스 저장
            uploadedFiles.push(files[i]);  // 업로드된 파일을 배열에 저장
            var fileButton = $('<button class="del">' + fileName + '</button>');
            fileButton.on('click', function() {
                var index = $(this).data('index');  // 버튼의 인덱스 가져오기
                uploadedFiles.splice(index, 1);  // 해당 파일을 배열에서 삭제
                $(this).remove();  // 버튼 삭제
                // 파일 인풋을 초기화 후 다시 설정
                updateFileInput();
                toggleFileBoxClass();
            });
            fileButton.data('index', fileIndex);  // 파일 인덱스를 버튼에 저장
            fileBox.append(fileButton);
            currentFiles++;
        }
        // 파일 인풋을 업데이트
        updateFileInput();
        toggleFileBoxClass();
    });
    function updateFileInput() {
        var dataTransfer = new DataTransfer();
        for (var i = 0; i < uploadedFiles.length; i++) {
            dataTransfer.items.add(uploadedFiles[i]);
        }
        $('#file-input')[0].files = dataTransfer.files;
    }
    function toggleFileBoxClass() {
        var fileBox = $('.file_box');
        if (fileBox.children('button').length > 0) {
            fileBox.addClass('on');
        } else {
            fileBox.removeClass('on');
        }
    }
//스크린샷
	$('.file-input').on('change', function(e) {
        var input = $(this);
        var file = this.files[0];
        var screenDiv = input.closest('.screen');
        var imgFit = screenDiv.find('.imgfit');
        var box = screenDiv.find('.box');

        if (file) {
            var reader = new FileReader();
            reader.onload = function(event) {
                // 이미지와 삭제 버튼 삽입
                imgFit.html('<img src="' + event.target.result + '" alt="">');
                screenDiv.append('<button class="del"></button>');
                // on 클래스 추가
                screenDiv.addClass('on');
                // 삭제 버튼 클릭 시
                screenDiv.find('.del').on('click', function() {
                    input.val(''); // 파일 입력 내용 삭제
                    imgFit.empty(); // 이미지 삭제
                    $(this).remove(); // 삭제 버튼 삭제
                    // on 클래스 제거
                    screenDiv.removeClass('on');
                });
            };
            reader.readAsDataURL(file);
        }
    });
});
//]]>
</script>
@endpush
