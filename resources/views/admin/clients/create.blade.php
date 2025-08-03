@extends('layouts.app')

@section('title', '클라이언트 생성')

@section('content')
<div id="mainContent" class="container sub_wrap clients_wrap">
    <div class="inner">
        <a href="{{ route('admin.clients.index') }}" class="goback">뒤로</a>
        <div class="title">클라이언트 생성</div>

        <form method="POST" action="{{ route('admin.clients.store') }}" enctype="multipart/form-data" class="client-form">
            @csrf

            <!-- 기본정보 -->
            <div class="stit s mtb">기본정보</div>
            <div class="tbl">
                <table>
                    <tbody>
                        <tr>
                            <th>회원구분*</th>
                            <td>
                                <div class="flex radios">
                                    <label class="radio">
                                        <input type="radio" name="member_type" value="client" checked>
                                        <i></i>일반
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="member_type" value="admin">
                                        <i></i>관리자
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>유형</th>
                            <td>
                                <div class="flex radios">
                                    <label class="radio">
                                        <input type="radio" name="new_type" value="new" checked>
                                        <i></i>신규
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="new_type" value="renewal">
                                        <i></i>갱신
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>이름(고객사명)*</th>
                            <td>
                                <div class="flex inchk">
                                    <input type="text" name="name" class="text w45" value="{{ old('name') }}" required>
                                    <label class="check">
                                        <input type="checkbox" name="is_manpower_check" value="1" {{ old('is_manpower_check') ? 'checked' : '' }}>
                                        <i></i>공수 확인 고객사
                                    </label>
                                </div>
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>타입*</th>
                            <td>
                                <select name="client_type" class="text w45" required>
                                    <option value="">타입을 선택하세요</option>
                                    <option value="association" {{ old('client_type') == 'association' ? 'selected' : '' }}>협회</option>
                                    <option value="company" {{ old('client_type') == 'company' ? 'selected' : '' }}>회사</option>
                                    <option value="individual" {{ old('client_type') == 'individual' ? 'selected' : '' }}>개인</option>
                                </select>
                                @error('client_type')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>ID*</th>
                            <td>
                                <div class="flex inbtn">
                                    <input type="text" name="login_id" class="text" value="{{ old('login_id') }}" required>
                                    <button type="button" class="btn" onclick="checkDuplicateId()">중복확인</button>
                                </div>
                                @error('login_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>PW*</th>
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
                                    <label class="radio">
                                        <input type="radio" name="monthly_report_enabled" value="1" {{ old('monthly_report_enabled', '1') == '1' ? 'checked' : '' }}>
                                        <i></i>Y
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="monthly_report_enabled" value="0" {{ old('monthly_report_enabled') == '0' ? 'checked' : '' }}>
                                        <i></i>N
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>계약 시작일*</th>
                            <td>
                                <input type="date" name="contract_start" class="text w45" value="{{ old('contract_start') }}" required>
                                @error('contract_start')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>계약 종료일*</th>
                            <td>
                                <input type="date" name="contract_end" class="text w45" value="{{ old('contract_end') }}" required>
                                @error('contract_end')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>웹사이트 URL</th>
                            <td>
                                <input type="url" name="website_url" class="text w45" value="{{ old('website_url') }}">
                                @error('website_url')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 담당자 정보 -->
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
                            <th>이름*</th>
                            <th>직위/직급</th>
                            <th>연락처</th>
                            <th>이메일</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < 4; $i++)
                        <tr>
                            <td class="mobe_tit manager order1">
                                @if($i == 0)
                                    대표 담당자*
                                @else
                                    담당자{{ $i }}
                                @endif
                            </td>
                            <td class="mobe_tit name order2">
                                <input type="text" name="managers[{{ $i }}][name]" class="text w100p"
                                       value="{{ old("managers.{$i}.name") }}" {{ $i == 0 ? 'required' : '' }}>
                                @error("managers.{$i}.name")
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                            <td class="mobe_tit position order3">
                                <input type="text" name="managers[{{ $i }}][position]" class="text w100p"
                                       value="{{ old("managers.{$i}.position") }}">
                            </td>
                            <td class="mobe_tit phone order4">
                                <input type="text" name="managers[{{ $i }}][phone]" class="text w100p"
                                       value="{{ old("managers.{$i}.phone") }}">
                            </td>
                            <td class="mobe_tit mail order5">
                                <input type="email" name="managers[{{ $i }}][email]" class="text w100p"
                                       value="{{ old("managers.{$i}.email") }}">
                            </td>
                        </tr>
                        <input type="hidden" name="managers[{{ $i }}][role]" value="{{ $i == 0 ? 'primary' : 'secondary' }}">
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- 유지보수 정보 -->
            <div class="stit s mtb">유지보수 정보 <button type="button" class="btn btn_long" onclick="addContractRow()">필드추가</button></div>
            <div class="board_list maintenance_info_list">
                <table id="contracts-table">
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
                            <th>계약공수</th>
                            <th>계약서</th>
                            <th>삭제</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="contract-row" data-row="0">
                            <td class="num">1</td>
                            <td class="order1">
                                <div class="flex datepicker_wrap">
                                    <div class="datepicker_area">
                                        <input type="date" name="contracts[0][contract_start]" class="text w100p" required>
                                    </div>
                                    <span>~</span>
                                    <div class="datepicker_area">
                                        <input type="date" name="contracts[0][contract_end]" class="text w100p" required>
                                    </div>
                                </div>
                            </td>
                            <td class="order2">
                                <div class="flex">
                                    <dl>
                                        <dt>PM,기획</dt>
                                        <dd><input type="number" name="contracts[0][pm_hours]" class="text bgw" value="0" min="0" step="0.5" required></dd>
                                    </dl>
                                    <dl>
                                        <dt>디자인</dt>
                                        <dd><input type="number" name="contracts[0][design_hours]" class="text bgw" value="0" min="0" step="0.5" required></dd>
                                    </dl>
                                    <dl>
                                        <dt>퍼블리싱</dt>
                                        <dd><input type="number" name="contracts[0][publishing_hours]" class="text bgw" value="0" min="0" step="0.5" required></dd>
                                    </dl>
                                    <dl>
                                        <dt>개발</dt>
                                        <dd><input type="number" name="contracts[0][development_hours]" class="text bgw" value="0" min="0" step="0.5" required></dd>
                                    </dl>
                                </div>
                            </td>
                            <td class="order3 file_wrap">
                                <div class="file_input">
                                    <label class="filebutton">
                                        <span>파일찾기</span>
                                        <input type="file" name="contracts[0][contract_file]" class="searchfile" accept=".pdf,.doc,.docx,.hwp">
                                    </label>
                                    <div class="filebox"></div>
                                </div>
                            </td>
                            <td class="order4 del_wrap">
                                <button type="button" class="btn_del" onclick="removeContractRow(this)">삭제</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 서버, 기타정보 -->
            <div class="stit s mtb">서버, 기타정보</div>
            <div class="tbl bdrs_l">
                <table>
                    <tbody>
                        <tr>
                            <th>도메인</th>
                            <td colspan="3">
                                <input type="text" name="server_info[domain]" class="text w100p" value="{{ old('server_info.domain') }}">
                            </td>
                            <th>서브 도메인</th>
                            <td colspan="3">
                                <input type="text" name="server_info[sub_domain]" class="text w100p" value="{{ old('server_info.sub_domain') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>관리자 주소</th>
                            <td colspan="3">
                                <input type="url" name="server_info[admin_url]" class="text w100p" value="{{ old('server_info.admin_url') }}">
                            </td>
                            <th>관리자 계정<br class="pc_vw">(ID/PW)</th>
                            <td colspan="3">
                                <input type="text" name="server_info[admin_account]" class="text w100p" value="{{ old('server_info.admin_account') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>개발언어(버전)</th>
                            <td colspan="3">
                                <input type="text" name="server_info[development_language]" class="text w100p" value="{{ old('server_info.development_language') }}">
                            </td>
                            <th>DB 종류</th>
                            <td colspan="3">
                                <input type="text" name="server_info[database_type]" class="text w100p" value="{{ old('server_info.database_type') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>도메인 기관</th>
                            <td colspan="3">
                                <input type="text" name="server_info[domain_provider]" class="text w100p" value="{{ old('server_info.domain_provider') }}">
                            </td>
                            <th>서버 기관</th>
                            <td colspan="3">
                                <input type="text" name="server_info[server_provider]" class="text w100p" value="{{ old('server_info.server_provider') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>SSL 기관</th>
                            <td colspan="3">
                                <input type="text" name="server_info[ssl_provider]" class="text w100p" value="{{ old('server_info.ssl_provider') }}">
                            </td>
                            <th>SSL 만료일</th>
                            <td colspan="3">
                                <input type="date" name="server_info[ssl_expiry_date]" class="text w100p" value="{{ old('server_info.ssl_expiry_date') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>FTP 주소</th>
                            <td><input type="text" name="server_info[ftp_host]" class="text w100p" value="{{ old('server_info.ftp_host') }}"></td>
                            <th>FTP ID</th>
                            <td><input type="text" name="server_info[ftp_id]" class="text w100p" value="{{ old('server_info.ftp_id') }}"></td>
                            <th>FTP PW</th>
                            <td><input type="password" name="server_info[ftp_password]" class="text w100p" value="{{ old('server_info.ftp_password') }}"></td>
                            <th>FTP ID</th>
                            <td><input type="text" name="server_info[ftp_id]" class="text w100p" value="{{ old('server_info.ftp_id') }}"></td>
                        </tr>
                        <tr>
                            <th>DB 호스트</th>
                            <td><input type="text" name="server_info[db_host]" class="text w100p" value="{{ old('server_info.db_host') }}"></td>
                            <th>DB ID</th>
                            <td><input type="text" name="server_info[db_id]" class="text w100p" value="{{ old('server_info.db_id') }}"></td>
                            <th>DB PW</th>
                            <td><input type="password" name="server_info[db_password]" class="text w100p" value="{{ old('server_info.db_password') }}"></td>
                            <th>DB ID</th>
                            <td><input type="text" name="server_info[db_id]" class="text w100p" value="{{ old('server_info.db_id') }}"></td>
                        </tr>
                        <tr>
                            <th>비고</th>
                            <td colspan="7" class="pd16">
                                <textarea name="server_info[notes]" cols="30" rows="10" class="text w100p">{{ old('server_info.notes') }}</textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="board_bottom">
                <div class="btns_tac">
                    <button type="submit" class="btn btn_g">저장</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let contractRowCount = 1;

function addContractRow() {
    const tbody = document.querySelector('#contracts-table tbody');
    const newRow = document.createElement('tr');
    newRow.className = 'contract-row';
    newRow.setAttribute('data-row', contractRowCount);

    newRow.innerHTML = `
        <td class="num">${contractRowCount + 1}</td>
        <td class="order1">
            <div class="flex datepicker_wrap">
                <div class="datepicker_area">
                    <input type="date" name="contracts[${contractRowCount}][contract_start]" class="text w100p" required>
                </div>
                <span>~</span>
                <div class="datepicker_area">
                    <input type="date" name="contracts[${contractRowCount}][contract_end]" class="text w100p" required>
                </div>
            </div>
        </td>
        <td class="order2">
            <div class="flex">
                <dl>
                    <dt>PM,기획</dt>
                    <dd><input type="number" name="contracts[${contractRowCount}][pm_hours]" class="text bgw" value="0" min="0" step="0.5" required></dd>
                </dl>
                <dl>
                    <dt>디자인</dt>
                    <dd><input type="number" name="contracts[${contractRowCount}][design_hours]" class="text bgw" value="0" min="0" step="0.5" required></dd>
                </dl>
                <dl>
                    <dt>퍼블리싱</dt>
                    <dd><input type="number" name="contracts[${contractRowCount}][publishing_hours]" class="text bgw" value="0" min="0" step="0.5" required></dd>
                </dl>
                <dl>
                    <dt>개발</dt>
                    <dd><input type="number" name="contracts[${contractRowCount}][development_hours]" class="text bgw" value="0" min="0" step="0.5" required></dd>
                </dl>
            </div>
        </td>
        <td class="order3 file_wrap">
            <div class="file_input">
                <label class="filebutton">
                    <span>파일찾기</span>
                    <input type="file" name="contracts[${contractRowCount}][contract_file]" class="searchfile" accept=".pdf,.doc,.docx,.hwp">
                </label>
                <div class="filebox"></div>
            </div>
        </td>
        <td class="order4 del_wrap">
            <button type="button" class="btn_del" onclick="removeContractRow(this)">삭제</button>
        </td>
    `;

    tbody.appendChild(newRow);
    contractRowCount++;
    updateContractNumbers();
}

function removeContractRow(button) {
    const row = button.closest('tr');
    if (document.querySelectorAll('.contract-row').length > 1) {
        row.remove();
        updateContractNumbers();
    } else {
        alert('최소 하나의 계약 정보는 필요합니다.');
    }
}

function updateContractNumbers() {
    const rows = document.querySelectorAll('.contract-row');
    rows.forEach((row, index) => {
        row.querySelector('.num').textContent = index + 1;
    });
}

function checkDuplicateId() {
    const loginId = document.querySelector('input[name="login_id"]').value;
    if (!loginId) {
        alert('ID를 입력해주세요.');
        return;
    }

    // 실제 중복 확인 로직은 서버에서 처리
    alert('중복 확인 기능은 서버에서 구현됩니다.');
}

// 파일 업로드 처리
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('searchfile')) {
            const file = e.target.files[0];
            if (file) {
                const filebox = e.target.parentElement.nextElementSibling;
                filebox.textContent = file.name;
                e.target.parentElement.parentElement.classList.add('on');
            }
        }
    });
});
</script>
@endsection
