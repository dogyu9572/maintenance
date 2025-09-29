@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush

@section('title', '유지보수 요청 생성')

@section('content')
<div class="container sub_wrap pb0">
    <div class="inner">
        <a href="{{ route('admin.maintenance-requests.index') }}" class="goback">목록으로</a>
        <div class="title">유지보수 요청 생성</div>

        <form method="POST" action="{{ route('admin.maintenance-requests.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="board_write">
                <table>
                    <colgroup>
                        <col class="w15">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>제목 <span class="required">*</span></th>
                            <td>
                                <input type="text" name="title" class="text w1" value="{{ old('title') }}" required>
                                @error('title')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>유지보수 종류 <span class="required">*</span></th>
                            <td>
                                <select name="maintenance_type_id" class="text w1" required>
                                    <option value="">유지보수 종류 선택</option>
                                    @foreach($types ?? [] as $type)
                                        <option value="{{ $type->idx }}" {{ old('maintenance_type_id') == $type->idx ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('maintenance_type_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>상태 <span class="required">*</span></th>
                            <td>
                                <select name="status_id" class="text w1" required>
                                    <option value="">상태 선택</option>
                                    @foreach($statuses ?? [] as $status)
                                        <option value="{{ $status->idx }}" {{ old('status_id') == $status->idx ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>담당자</th>
                            <td>
                                <select name="assigned_user_id" class="text w1">
                                    <option value="">담당자 선택</option>
                                    @foreach($users ?? [] as $user)
                                        <option value="{{ $user->idx }}" {{ old('assigned_user_id') == $user->idx ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('assigned_user_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>우선순위 <span class="required">*</span></th>
                            <td>
                                <select name="priority" class="text w1" required>
                                    <option value="">우선순위 선택</option>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>낮음</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>보통</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>높음</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>긴급</option>
                                </select>
                                @error('priority')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>예상 공수 (PM/기획)</th>
                            <td>
                                <input type="number" name="estimated_pm_hours" class="text w1" value="{{ old('estimated_pm_hours', 0) }}" min="0">
                                @error('estimated_pm_hours')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>예상 공수 (디자인)</th>
                            <td>
                                <input type="number" name="estimated_design_hours" class="text w1" value="{{ old('estimated_design_hours', 0) }}" min="0">
                                @error('estimated_design_hours')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>예상 공수 (퍼블리싱)</th>
                            <td>
                                <input type="number" name="estimated_publishing_hours" class="text w1" value="{{ old('estimated_publishing_hours', 0) }}" min="0">
                                @error('estimated_publishing_hours')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>예상 공수 (개발)</th>
                            <td>
                                <input type="number" name="estimated_development_hours" class="text w1" value="{{ old('estimated_development_hours', 0) }}" min="0">
                                @error('estimated_development_hours')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>내용 <span class="required">*</span></th>
                            <td>
                                <textarea name="content" class="textarea w1" rows="10" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="btn_area">
                <button type="submit" class="btn btn_l">등록하기</button>
                <a href="{{ route('admin.maintenance-requests.index') }}" class="btn btn_gray">취소</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/maintenance-requests-create.js') }}"></script>
@endpush
