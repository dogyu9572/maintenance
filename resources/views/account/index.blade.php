@extends('layouts.app')

@section('title', '계정정보')

@section('content')
<div id="mainContent" class="container sub_wrap">
    <div class="inner">
        <div class="title">계정정보</div>

        <!-- 기본정보 -->
        <div class="stit s mtb">기본정보</div>
        <div class="tbl">
            <table>
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $user->email ?? 'kse0701' }}</td>
                    </tr>
                    <tr>
                        <th>PW</th>
                        <td><button class="copy">복사</button></td>
                    </tr>
                    <tr>
                        <th>이름(고객사명)</th>
                        <td>{{ $client->name ?? '한국심초음파학회' }}</td>
                    </tr>
                    <tr>
                        <th>생성일</th>
                        <td>{{ $user->created_at ? $user->created_at->format('Y.m.d') : '2024.07.01' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 담당자 정보 -->
        <div class="stit s mtb">담당자 정보 <a href="{{ route('account.edit') }}" class="btn btn_setting">정보수정</a></div>
        <div class="tbl">
            <table>
                <tbody>
                    @foreach($managers as $index => $manager)
                    <tr>
                        <th>{{ $index === 0 ? '대표 담당자' : '담당자' . $index }}</th>
                        <td>{{ $manager['name'] }} / {{ $manager['position'] }} / {{ $manager['phone'] }} / {{ $manager['email'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 유지보수 정보 -->
        <div class="stit s mtb">유지보수 정보</div>
        <div class="board_list">
            <table>
                <colgroup>
                    <col class="w4">
                    <col class="w19">
                    <col class="w12">
                    <col class="w27">
                    <col width="*">
                </colgroup>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>계약기간</th>
                        <th>계약금액</th>
                        <th>계약서</th>
                        <th>계약공수(h)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contracts as $contract)
                    <tr>
                        <td class="num">{{ $contract['id'] }}</td>
                        <td class="mobe_tit dates">{{ $contract['period'] }}</td>
                        <td class="mobe_tit money">{{ $contract['amount'] }}</td>
                        <td class="mobe_tit down"><a href="#this" download>{{ $contract['contract_file'] }}</a></td>
                        <td class="mobe_tit flex_area">
                            <div class="flex">
                                <dl>
                                    <dt>PM,기획</dt>
                                    <dd><input type="text" class="text" value="{{ $contract['hours']['pm_planning'] }}"></dd>
                                </dl>
                                <dl>
                                    <dt>디자인</dt>
                                    <dd><input type="text" class="text" value="{{ $contract['hours']['design'] }}"></dd>
                                </dl>
                                <dl>
                                    <dt>퍼블리싱</dt>
                                    <dd><input type="text" class="text" value="{{ $contract['hours']['publishing'] }}"></dd>
                                </dl>
                                <dl>
                                    <dt>개발</dt>
                                    <dd><input type="text" class="text" value="{{ $contract['hours']['development'] }}"></dd>
                                </dl>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 서버, 기타정보 -->
        <div class="stit s mtb">서버, 기타정보</div>
        <div class="tbl">
            <table>
                <tbody>
                    <tr>
                        <th>도메인</th>
                        <td colspan="3">{{ $serverInfo['domain'] }}</td>
                        <th>서브 도메인</th>
                        <td colspan="3">{{ $serverInfo['sub_domain'] }}</td>
                    </tr>
                    <tr>
                        <th>관리자 주소</th>
                        <td colspan="3">{{ $serverInfo['admin_url'] }}</td>
                        <th>관리자 계정 <br class="pc_vw">(ID/PW)</th>
                        <td colspan="3">{{ $serverInfo['admin_account'] }}</td>
                    </tr>
                    <tr>
                        <th>개발언어(버전)</th>
                        <td colspan="3">{{ $serverInfo['language'] }}</td>
                        <th>DB 종류</th>
                        <td colspan="3">{{ $serverInfo['database'] }}</td>
                    </tr>
                    <tr>
                        <th>도메인 기관</th>
                        <td colspan="3">{{ $serverInfo['domain_provider'] }}</td>
                        <th>서버 기관</th>
                        <td colspan="3">{{ $serverInfo['server_provider'] }}</td>
                    </tr>
                    <tr>
                        <th>SSL 기관</th>
                        <td colspan="3">{{ $serverInfo['ssl_provider'] }}</td>
                        <th>SSL 만료일</th>
                        <td colspan="3">{{ $serverInfo['ssl_expiry'] }}</td>
                    </tr>
                    <tr>
                        <th>FTP 주소</th>
                        <td>{{ $serverInfo['ftp_address'] }}</td>
                        <th>FTP ID</th>
                        <td>{{ $serverInfo['ftp_id'] }}</td>
                        <th>FTP PW</th>
                        <td>{{ $serverInfo['ftp_password'] }}</td>
                        <th>FTP ID</th>
                        <td>{{ $serverInfo['ftp_id'] }}</td>
                    </tr>
                    <tr>
                        <th>DB 호스트</th>
                        <td>{{ $serverInfo['db_host'] }}</td>
                        <th>DB ID</th>
                        <td>{{ $serverInfo['db_id'] }}</td>
                        <th>DB 호스트</th>
                        <td>{{ $serverInfo['db_host'] }}</td>
                        <th>DB ID</th>
                        <td>{{ $serverInfo['db_id'] }}</td>
                    </tr>
                    <tr>
                        <th>비고</th>
                        <td colspan="7">{{ $serverInfo['note'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
