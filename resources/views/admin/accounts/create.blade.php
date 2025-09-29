@extends('layouts.app')

@section('title', '계정 생성')

@section('content')
@php
    // 옵션 값들을 변수로 분리
    $memberTypes = [
        'general' => '일반',
        'admin' => '관리자'
    ];
    
    $newTypes = [
        'new' => '신규',
        'renewal' => '갱신'
    ];
    
    $clientTypes = [
        'association' => '협회',
        'company' => '기업',
        'government' => '정부기관'
    ];
    
    $monthlyReportOptions = [
        'Y' => 'Y',
        'N' => 'N'
    ];
    
    $contractUnits = [
        '' => '일(d)/시(h)/분(m)',
        'd' => '일(d)',
        'h' => '시(h)',
        'm' => '분(m)'
    ];
    
    // 담당자 정보 설정
    $contactPersons = [
        ['title' => '대표 담당자', 'prefix' => 'manager', 'required' => true],
        ['title' => '담당자1', 'prefix' => 'contact1', 'required' => false],
        ['title' => '담당자2', 'prefix' => 'contact2', 'required' => false],
        ['title' => '담당자3', 'prefix' => 'contact3', 'required' => false]
    ];
@endphp

<div id="mainContent" class="container sub_wrap notices_wrap">
    <div class="inner">
        <a href="javascript:history.back();" class="goback">뒤로</a>
        <div class="title">계정 생성</div>

        <form method="POST" action="{{ route('admin.accounts.store') }}" class="account-form" id="accountForm" enctype="multipart/form-data">
            @csrf
            
            <div class="stit s mtb">기본정보</div>
            <div class="tbl">
                <table>
                    <tbody>
                        <tr>
                            <th>회원구분*</th>
                            <td>
                                <div class="flex radios">
                                    @foreach($memberTypes as $value => $label)
                                        <label class="radio">
                                            <input type="radio" name="member_type" value="{{ $value }}" 
                                                {{ old('member_type', 'general') == $value ? 'checked' : '' }} required>
                                            <i></i>{{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('member_type')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>유형</th>
                            <td>
                                <div class="flex radios">
                                    @foreach($newTypes as $value => $label)
                                        <label class="radio">
                                            <input type="radio" name="new_type" value="{{ $value }}" 
                                                {{ old('new_type') == $value ? 'checked' : '' }}>
                                            <i></i>{{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('new_type')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>이름(고객사명)*</th>
                            <td>
                                <div class="flex inchk">
                                    <input type="text" name="name" class="text w45" value="{{ old('name') }}" required>
                                    <label class="check">
                                        <input type="checkbox" name="is_confirmed_client" value="1" {{ old('is_confirmed_client') ? 'checked' : '' }}>
                                        <i></i>공수 확인 고객사
                                    </label>
                                </div>
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>타입</th>
                            <td>
                                <select name="client_type" class="text w45">
                                    @foreach($clientTypes as $value => $label)
                                        <option value="{{ $value }}" {{ old('client_type') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_type')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <td>
                                <div class="flex inbtn">
                                    <input type="text" name="login_id" class="text" value="{{ old('login_id') }}" required>
                                    <button type="button" class="btn" id="checkDuplicate">중복확인</button>
                                </div>
                                @error('login_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>PW</th>
                            <td>
                                <input type="password" name="password" class="text w45" required>
                                @error('password')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>PW 확인*</th>
                            <td>
                                <input type="password" name="password_confirmation" class="text w45" required>
                                @error('password_confirmation')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>월간보고서 사용</th>
                            <td>
                                <div class="flex radios">
                                    @foreach($monthlyReportOptions as $value => $label)
                                        <label class="radio">
                                            <input type="radio" name="monthly_report" value="{{ $value }}" 
                                                {{ old('monthly_report') == $value ? 'checked' : '' }}>
                                            <i></i>{{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('monthly_report')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>생성일</th>
                            <td>
                                <input type="text" class="text w45" value="{{ date('Y.m.d') }}" disabled>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="stit s mtb">담당자 정보</div>
            <div class="board_list manager_info_list">
                <table>
                    <colgroup>
                        <col class="w10">
                        <col width="*">
                        <col width="*">
                        <col width="*">
                        <col width="*">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>담당자</th>
                            <th>이름</th>
                            <th>직위/직급</th>
                            <th>연락처</th>
                            <th>이메일</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contactPersons as $person)
                        <tr>
                            <td class="mobe_tit manager order1">{{ $person['title'] }}{{ $person['required'] ? '*' : '' }}</td>
                            <td class="mobe_tit name order2">
                                <input type="text" name="{{ $person['prefix'] }}_name" class="text w100p" 
                                    value="{{ old($person['prefix'] . '_name') }}" 
                                    placeholder="이름"
                                    @if($person['required']) required @endif>
                                @error($person['prefix'] . '_name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <td class="mobe_tit position order3">
                                <input type="text" name="{{ $person['prefix'] }}_position" class="text w100p" 
                                    value="{{ old($person['prefix'] . '_position') }}" 
                                    placeholder="직위/직급">
                                @error($person['prefix'] . '_position')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <td class="mobe_tit phone order4">
                                <input type="text" name="{{ $person['prefix'] }}_phone" class="text w100p" 
                                    value="{{ old($person['prefix'] . '_phone') }}" 
                                    placeholder="연락처">
                                @error($person['prefix'] . '_phone')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <td class="mobe_tit mail order5">
                                <input type="text" name="{{ $person['prefix'] }}_email" class="text w100p" 
                                    value="{{ old($person['prefix'] . '_email') }}" 
                                    placeholder="이메일">
                                @error($person['prefix'] . '_email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="stit s mtb">유지보수 정보 <button type="button" class="btn btn_long" id="addMaintenanceField">필드추가</button></div>
            <div class="board_list maintenance_info_list">
                <table>
                    <colgroup>
                        <col class="w4">
                        <col class="w31">
                        <col width="*">
                        <col class="w19">
                        <col class="w8">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>계약기간</th>
                            <th>
                                <div class="flex">
                                    계약공수
                                    <select name="contract_unit" class="text">
                                        @foreach($contractUnits as $value => $label)
                                            <option value="{{ $value }}" {{ old('contract_unit') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </th>
                            <th>계약서</th>
                            <th>삭제</th>
                        </tr>
                    </thead>
                    <tbody id="maintenanceTableBody">
                        <tr>
                            <td class="num">1</td>
                            <td class="order1">
                                <div class="flex datepicker_wrap">
                                    <div class="datepicker_area">
                                        <input type="text" name="contract_start[]" class="text datepicker w100p">
                                    </div>
                                    <span></span>
                                    <div class="datepicker_area">
                                        <input type="text" name="contract_end[]" class="text datepicker w100p">
                                    </div>
                                </div>
                            </td>
                            <td class="order2">
                                <div class="flex">
                                    <dl>
                                        <dt>PM,기획</dt>
                                        <dd><input type="text" name="pm_hours[]" class="text bgw"></dd>
                                    </dl>
                                    <dl>
                                        <dt>디자인</dt>
                                        <dd><input type="text" name="design_hours[]" class="text bgw"></dd>
                                    </dl>
                                    <dl>
                                        <dt>퍼블리싱</dt>
                                        <dd><input type="text" name="publish_hours[]" class="text bgw"></dd>
                                    </dl>
                                    <dl>
                                        <dt>개발</dt>
                                        <dd><input type="text" name="dev_hours[]" class="text bgw"></dd>
                                    </dl>
                                </div>
                            </td>
                            <td class="order3 file_wrap">
                                <div class="file_input">
                                    <label class="filebutton">
                                        <span>파일찾기</span>
                                        <input type="file" name="contract_files[]" class="searchfile" title="파일 찾기">
                                    </label>
                                    <div class="filebox"></div>
                                </div>
                            </td>
                            <td class="order4 del_wrap">
                                <button type="button" class="btn_del">삭제</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="stit s mtb">서버, 기타정보</div>
            <div class="tbl bdrs_l">
                <table>
                    <tbody>
                        <tr>
                            <th>도메인</th>
                            <td colspan="3">
                                <input type="text" name="domain" class="text w100p" value="{{ old('domain') }}">
                                @error('domain')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>서브 도메인</th>
                            <td colspan="3">
                                <input type="text" name="sub_domain" class="text w100p" value="{{ old('sub_domain') }}">
                                @error('sub_domain')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>관리자 주소</th>
                            <td colspan="3">
                                <input type="text" name="admin_url" class="text w100p" value="{{ old('admin_url') }}">
                                @error('admin_url')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>관리자 계정 <br class="pc_vw">(ID/PW)</th>
                            <td colspan="3">
                                <input type="text" name="admin_account" class="text w100p" value="{{ old('admin_account') }}">
                                @error('admin_account')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>개발언어(버전)</th>
                            <td colspan="3">
                                <input type="text" name="dev_language" class="text w100p" value="{{ old('dev_language') }}">
                                @error('dev_language')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>DB 종류</th>
                            <td colspan="3">
                                <input type="text" name="db_type" class="text w100p" value="{{ old('db_type') }}">
                                @error('db_type')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>도메인 기관</th>
                            <td colspan="3">
                                <input type="text" name="domain_agency" class="text w100p" value="{{ old('domain_agency') }}">
                                @error('domain_agency')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>서버 기관</th>
                            <td colspan="3">
                                <input type="text" name="server_agency" class="text w100p" value="{{ old('server_agency') }}">
                                @error('server_agency')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>SSL 기관</th>
                            <td colspan="3">
                                <input type="text" name="ssl_agency" class="text w100p" value="{{ old('ssl_agency') }}">
                                @error('ssl_agency')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>SSL 만료일</th>
                            <td colspan="3">
                                <input type="text" name="ssl_expiry" class="text w100p" value="{{ old('ssl_expiry') }}">
                                @error('ssl_expiry')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>FTP 주소</th>
                            <td>
                                <input type="text" name="ftp_host" class="text w100p" value="{{ old('ftp_host') }}">
                                @error('ftp_host')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>FTP ID</th>
                            <td>
                                <input type="text" name="ftp_id" class="text w100p" value="{{ old('ftp_id') }}">
                                @error('ftp_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>FTP PW</th>
                            <td>
                                <input type="password" name="ftp_password" class="text w100p" value="{{ old('ftp_password') }}">
                                @error('ftp_password')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>FTP ID</th>
                            <td>
                                <input type="text" name="ftp_id2" class="text w100p" value="{{ old('ftp_id2') }}">
                                @error('ftp_id2')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>DB 호스트</th>
                            <td>
                                <input type="text" name="db_host" class="text w100p" value="{{ old('db_host') }}">
                                @error('db_host')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>DB ID</th>
                            <td>
                                <input type="text" name="db_id" class="text w100p" value="{{ old('db_id') }}">
                                @error('db_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>DB 호스트</th>
                            <td>
                                <input type="text" name="db_host2" class="text w100p" value="{{ old('db_host2') }}">
                                @error('db_host2')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <th>DB ID</th>
                            <td>
                                <input type="text" name="db_id2" class="text w100p" value="{{ old('db_id2') }}">
                                @error('db_id2')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>비고</th>
                            <td colspan="7" class="pd16">
                                <textarea name="notes" cols="30" rows="10" class="text w100p">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="board_bottom">
                <div class="btns_tac">
                    <button type="submit" class="btn btn_g">저장</button>
                    <a href="{{ route('admin.accounts.index') }}" class="btn btn_gray">취소</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/admin/accounts-create.js') }}"></script>
@endsection
