@extends('layouts.app')

@section('title', '공지사항 글쓰기')

@section('content')
<div id="mainContent" class="container sub_wrap">
    <div class="inner">
        <div class="input_area">
            <a href="javascript:history.back();" class="goback">뒤로</a>
            <div class="title">공지사항 글쓰기</div>

            <form method="POST" action="{{ route('admin.notices.store') }}" enctype="multipart/form-data">
                @csrf
                <dl>
                    <dt>제목 <span class="col_red2">*</span></dt>
                    <dd>
                        <input type="text" name="title" class="text w100p" value="{{ old('title') }}" required>
                        <label class="check mt">
                            <input type="checkbox" name="is_important" value="1" {{ old('is_important') ? 'checked' : '' }}>
                            <i></i>공지 등록
                        </label>
                    </dd>
                </dl>
                <dl>
                    <dt>내용 <span class="col_red2">*</span></dt>
                    <dd>
                        <textarea name="content" cols="30" rows="10" class="text w100p" placeholder="에디터" required>{{ old('content') }}</textarea>
                    </dd>
                </dl>
                <dl>
                    <dt>첨부파일</dt>
                    <dd>
                        <label class="file">
                            <input type="file" id="file-input" name="attachments[]" multiple>
                            <span class="tt">첨부파일 업로드</span>
                            <p>파일 1개당 최대 20MB까지 업로드 가능 (최대 3개까지 첨부 가능)</p>
                            <i>파일첨부</i>
                        </label>
                        <div class="file_box"></div>
                    </dd>
                </dl>
                <dl>
                    <dt>작성자</dt>
                    <dd>
                        <input type="text" class="text w100p" value="{{ auth()->user()->name ?? '오유림' }}" readonly disabled>
                    </dd>
                </dl>
                <dl>
                    <dt>조회수</dt>
                    <dd>
                        <input type="text" class="text w100p" value="0" readonly disabled>
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
            var fileIndex = uploadedFiles.length;  // 파일 인덱스 저장
            uploadedFiles.push(files[i]);  // 업로드된 파일을 배열에 저장
            var fileButton = $('<button type="button" class="del">' + fileName + '</button>');
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
</script>
@endpush
@endsection
