@extends('layouts.app')

@section('title', '계정 수정')

@section('content')
<div id="mainContent" class="container sub_wrap account_wrap">
    <div class="inner">
        <div class="title">계정 수정</div>

        <div class="board_write">
            <form method="POST" action="{{ route('admin.accounts.update', $account->idx) }}" class="account-form">
                @csrf
                @method('PUT')
                <table>
                    <colgroup>
                        <col class="w20">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>아이디 <span class="required">*</span></th>
                            <td>
                                <input type="text" name="username" class="text w300" value="{{ old('username', $account->username) }}" required>
                                @error('username')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>비밀번호</th>
                            <td>
                                <input type="password" name="password" class="text w300" placeholder="변경하지 않으려면 비워두세요">
                                @error('password')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>이름 <span class="required">*</span></th>
                            <td>
                                <input type="text" name="name" class="text w300" value="{{ old('name', $account->name) }}" required>
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>이메일 <span class="required">*</span></th>
                            <td>
                                <input type="email" name="email" class="text w300" value="{{ old('email', $account->email) }}" required>
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>휴대폰</th>
                            <td>
                                <input type="tel" name="phone" class="text w300" value="{{ old('phone', $account->phone) }}">
                                @error('phone')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>고객사 <span class="required">*</span></th>
                            <td>
                                <select name="client_id" class="text w300" required>
                                    <option value="">고객사를 선택하세요</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->idx }}" {{ old('client_id', $account->client_id) == $client->idx ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>직위/직급</th>
                            <td>
                                <input type="text" name="position" class="text w300" value="{{ old('position', $account->position) }}">
                                @error('position')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>계약 시작일</th>
                            <td>
                                <input type="date" name="contract_start" class="text w300" value="{{ old('contract_start', $account->contract_start) }}">
                                @error('contract_start')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>계약 종료일</th>
                            <td>
                                <input type="date" name="contract_end" class="text w300" value="{{ old('contract_end', $account->contract_end) }}">
                                @error('contract_end')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>관리자 여부</th>
                            <td>
                                <label class="check">
                                    <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $account->is_admin) ? 'checked' : '' }}>
                                    <i></i>관리자 권한 부여
                                </label>
                                @error('is_admin')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>사용 여부</th>
                            <td>
                                <label class="check">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $account->is_active) ? 'checked' : '' }}>
                                    <i></i>활성 계정
                                </label>
                                @error('is_active')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="btns_tal">
                    <button type="submit" class="btn">수정</button>
                    <a href="{{ route('admin.accounts.index') }}" class="btn btn_gray">취소</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.required {
    color: #ff0000;
}
.error {
    color: #ff0000;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}
.board_write table {
    margin-bottom: 30px;
}
.board_write th {
    background: #f8f9fa;
    padding: 15px;
    border: 1px solid #dee2e6;
    text-align: left;
    font-weight: 500;
}
.board_write td {
    padding: 15px;
    border: 1px solid #dee2e6;
}
.board_write input[type="text"],
.board_write input[type="email"],
.board_write input[type="password"],
.board_write input[type="tel"],
.board_write input[type="date"],
.board_write select {
    border: 1px solid #ced4da;
    padding: 8px 12px;
    border-radius: 4px;
}
.board_write input[type="text"]:focus,
.board_write input[type="email"]:focus,
.board_write input[type="password"]:focus,
.board_write input[type="tel"]:focus,
.board_write input[type="date"]:focus,
.board_write select:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
.btns_tal {
    text-align: center;
    margin-top: 30px;
}
.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 0 5px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    font-size: 14px;
}
.btn_gray {
    background: #6c757d;
    color: white;
}
</style>
@endsection
