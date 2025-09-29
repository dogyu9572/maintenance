@extends('layouts.app')

@section('title', '보고서 작성')

@section('content')
<div id="mainContent" class="container sub_wrap maintenance_requests_wrap">
    <div class="inner">
        <a href="javascript:history.back();" class="goback">뒤로</a>
        <div class="title">보고서 작성</div>

        <form method="POST" action="{{ route('admin.monthly-reports.store') }}" id="monthlyReportForm">
            @csrf
            
            {{-- 오류 메시지 표시 --}}
            @if ($errors->any())
                <div class="alert alert-danger" style="background: #fee; border: 1px solid #fcc; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                    <h4 style="color: #c33; margin: 0 0 10px 0;">오류가 발생했습니다:</h4>
                    <ul style="margin: 0; padding-left: 20px; color: #c33;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="stit s">보고서 작성 <button type="submit" class="btn btn_l">저장하기</button></div>
            <div class="tbl">
                <table>
                    <tbody>


                        <tr>
                            <th>고객사명</th>
                            <td>
                                <select name="user_id" class="text w50" required>
                                    <option value="">선택</option>
                                    @foreach($clients as $client)
                                    <option value="{{ $client->idx }}" {{ old('user_id') == $client->idx ? 'selected' : '' }}>
                                        {{ $client->name ?? '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>제목</th>
                            <td>
                                <input type="text" name="title" class="text w50" value="{{ old('title') }}" required>
                            </td>
                        </tr>
                        <tr>
                            <th>업무기간</th>
                            <td>
                                <div class="inputs flex">
                                    <div class="datepicker_area">
                                        <input type="text" name="work_start_date" class="text datepicker datepicker_start" value="{{ old('work_start_date') }}">
                                    </div>
                                    <span class="bar"></span>
                                    <div class="datepicker_area">
                                        <input type="text" name="work_end_date" class="text datepicker datepicker_end" value="{{ old('work_end_date') }}">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>사업명</th>
                            <td>
                                <input type="text" name="project_name" class="text w50" value="{{ old('project_name') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>용역책임자</th>
                            <td>
                                <input type="text" name="manager_name" class="text w50" value="{{ old('manager_name') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>사업책임자</th>
                            <td>
                                <input type="text" name="company_name" class="text w50" value="{{ old('company_name') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>보고일(등록일)</th>
                            <td>
                                <div class="datepicker_area">
                                    <input type="text" name="report_date" class="text datepicker" value="{{ old('report_date') }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>작성자</th>
                            <td>{{ auth()->user()->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>노출여부</th>
                            <td>
                                <div class="flex radios">
                                    <label class="radio">
                                        <input type="radio" name="is_visible" value="1" {{ old('is_visible', 1) == 1 ? 'checked' : '' }}>
                                        <i></i>Y
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="is_visible" value="0" {{ old('is_visible') == 0 ? 'checked' : '' }}>
                                        <i></i>N
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="stit s mt">업무현황 <button type="button" class="btn btn_l btn_addfield">필드추가</button></div>
            <div class="board_list over_v tbl_addfield">
                <table>
                    <colgroup>
                        <col class="w6">
                        <col width="*">
                        <col class="w16">
                        <col class="w16">
                        <col class="w16">
                        <col class="w16">
                        <col class="w16">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>내용</th>
                            <th>진행율(%)</th>
                            <th>처리상태</th>
                            <th>담당자</th>
                            <th>접수일</th>
                            <th>완료일</th>
                        </tr>
                    </thead>
                    <tbody id="workItems">
                        <tr>
                            <td class="num">1</td>
                            <td class="report1">
                                    <input type="text" name="work_items[1][title]" class="text w100p" value="{{ old('work_items.1.title') }}">
                            </td>
                            <td class="report2">
                                    <input type="text" name="work_items[1][progress_rate]" class="text w100p" value="{{ old('work_items.1.progress_rate') }}">
                            </td>
                            <td class="report3">
                                <select name="work_items[1][status]" class="text w100p">
                                    <option value="">진행중/완료</option>
                                    <option value="진행중" {{ old('work_items.1.status') == '진행중' ? 'selected' : '' }}>진행중</option>
                                    <option value="완료" {{ old('work_items.1.status') == '완료' ? 'selected' : '' }}>완료</option>
                                </select>
                            </td>
                            <td class="report4">
                                <select name="work_items[1][assignee]" class="text w100p">
                                    <option value="">담당자 선택</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->idx }}" {{ old('work_items.1.assignee') == $user->idx ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="report5">
                                <div class="datepicker_area w100p">
                                    <input type="text" name="work_items[1][start_date]" class="text datepicker w100p" value="{{ old('work_items.1.start_date') }}">
                                </div>
                            </td>
                            <td class="report6">
                                <div class="datepicker_area w100p">
                                    <input type="text" name="work_items[1][end_date]" class="text datepicker w100p" value="{{ old('work_items.1.end_date') }}">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="stit s mt">특이사항</div>
            <div class="glbox outgray">
                <textarea name="special_notes" cols="30" rows="10" class="text w100p">{{ old('special_notes') }}</textarea>
            </div>

            <div class="board_bottom">
                <div class="btns_tac">
                    <button type="submit" class="btn btn_g">저장</button>
                    <a href="{{ route('admin.monthly-reports.index') }}" class="btn btn_l">목록</a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/admin/monthly-reports-create.js') }}"></script>
@endpush
@endsection
