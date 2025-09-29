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
                        <input type="text" class="text w100p" value="{{ auth()->user()->name ?? '' }}" readonly disabled>
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
<script src="{{ asset('js/admin/notices-create.js') }}"></script>
@endpush
@endsection
