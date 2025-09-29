@extends('layouts.app')

@section('title', '환경설정(유지보수 종류)')

@section('content')
<div id="mainContent" class="container sub_wrap">

    <div class="inner">
        <a href="javascript:history.back();" class="goback">뒤로</a>
        <div class="title">환경설정(유지보수 종류)</div>

        <div class="preferences">
            <div class="folderbox">
                <div class="addbox">
                    <form method="POST" action="{{ route('admin.preferences.store') }}" id="addForm">
                        @csrf
                        <input type="text" class="text" name="name" value="{{ old('name') }}" placeholder="유지보수 종류명">
                        <button type="submit" class="btn">추가</button>
                    </form>
                </div>
                <div class="list">
                    @forelse($maintenanceTypes ?? [] as $type)
                    <button type="button" class="btn {{ $selectedType && $selectedType->idx == $type->idx ? 'on' : '' }}"
                            onclick="selectType({{ $type->idx }})">
                        {{ $type->name }}
                    </button>
                    @empty
                    <button type="button" class="btn on">SSL(보안인증서)</button>
                    <button type="button" class="btn">콘텐츠 수정</button>
                    <button type="button" class="btn">메일, 뉴스레터 발송</button>
                    <button type="button" class="btn">홈페이지 수정</button>
                    <button type="button" class="btn">기타</button>
                    @endforelse
                </div>
            </div>
            <div class="inputs">
                <form method="POST" action="{{ route('admin.preferences.update', $selectedType->idx ?? 1) }}" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="stit ss mt0">이름</div>
                    <input type="text" class="text w100p" name="name" value="{{ $selectedType->name ?? 'SSL(보안인증서)' }}" required>
                    <div class="stit ss">순서</div>
                    <input type="text" class="text w100p" name="sort_order" value="{{ $selectedType->sort_order ?? 1 }}" required>
                    <div class="stit ss">사용여부</div>
                    <div class="flex radios">
                        <label class="radio">
                            <input type="radio" name="is_active" value="1" {{ ($selectedType->is_active ?? true) ? 'checked' : '' }}>
                            <i></i>Y
                        </label>
                        <label class="radio">
                            <input type="radio" name="is_active" value="0" {{ ($selectedType->is_active ?? true) ? '' : 'checked' }}>
                            <i></i>N
                        </label>
                    </div>
                    <div class="stit ss">내용</div>
                    <textarea name="description" cols="30" rows="10" class="text w100p"
                              placeholder="placeholder에 들어갈 내용 입력">{{ $selectedType->description ?? '' }}</textarea>
                    <div class="board_bottom">
                        <div class="btns_tac">
                            <button type="submit" class="btn btn_g">저장</button>
                            <button type="button" class="btn btn_bl" onclick="deleteType()">삭제</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

<script>
function selectType(typeId) {
    window.location.href = '{{ route("admin.preferences.index") }}?type=' + typeId;
}

function deleteType() {
    if (confirm('정말 삭제하시겠습니까?')) {
        var form = document.getElementById('editForm');
        form.action = '{{ route("admin.preferences.destroy", $selectedType->idx ?? 1) }}';
        form.method = 'POST';

        var methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        form.submit();
    }
}
</script>
@endsection
