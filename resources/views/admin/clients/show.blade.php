@extends('layouts.app')

@section('title', '클라이언트 상세')

@section('content')
<div id="mainContent" class="container sub_wrap clients_wrap">
    <div class="inner">
        <a href="{{ route('admin.clients.index') }}" class="goback">뒤로</a>
        <div class="title">클라이언트 상세</div>

        <!-- 기본정보 -->
        <div class="stit s mtb">기본정보</div>
        <div class="tbl">
            <table>
                <tbody>
                    <tr>
                        <th>클라이언트명</th>
                        <td>{{ $client->name }}</td>
                        <th>타입</th>
                        <td>
                            @switch($client->client_type)
                                @case('association')
                                    <span class="badge badge_blue">협회</span>
                                    @break
                                @case('company')
                                    <span class="badge badge_green">회사</span>
                                    @break
                                @case('individual')
                                    <span class="badge badge_gray">개인</span>
                                    @break
                                @default
                                    <span class="badge badge_gray">-</span>
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>공수 확인 고객사</th>
                        <td>
                            @if($client->is_manpower_check)
                                <span class="badge badge_green">Y</span>
                            @else
                                <span class="badge badge_gray">N</span>
                            @endif
                        </td>
                        <th>월간보고서 사용</th>
                        <td>
                            @if($client->monthly_report_enabled)
                                <span class="badge badge_green">Y</span>
                            @else
                                <span class="badge badge_gray">N</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>계약기간</th>
                        <td colspan="3">
                            {{ $client->contract_start ? $client->contract_start->format('Y.m.d') : '-' }} ~
                            {{ $client->contract_end ? $client->contract_end->format('Y.m.d') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>웹사이트 URL</th>
                        <td colspan="3">
                            @if($client->website_url)
                                <a href="{{ $client->website_url }}" target="_blank">{{ $client->website_url }}</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>상태</th>
                        <td colspan="3">
                            @if($client->is_active)
                                <span class="badge badge_green">활성</span>
                            @else
                                <span class="badge badge_red">비활성</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>생성일</th>
                        <td colspan="3">{{ $client->created_at->format('Y.m.d H:i') }}</td>
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
                        <th>이름</th>
                        <th>직위/직급</th>
                        <th>연락처</th>
                        <th>이메일</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($client->managers as $manager)
                    <tr>
                        <td class="mobe_tit manager order1">
                            @if($manager->role == 'primary')
                                대표 담당자
                            @else
                                담당자{{ $manager->manager_order }}
                            @endif
                        </td>
                        <td class="mobe_tit name order2">{{ $manager->name }}</td>
                        <td class="mobe_tit position order3">{{ $manager->position ?: '-' }}</td>
                        <td class="mobe_tit phone order4">{{ $manager->phone ?: '-' }}</td>
                        <td class="mobe_tit mail order5">
                            @if($manager->email)
                                <a href="mailto:{{ $manager->email }}">{{ $manager->email }}</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty">등록된 담당자가 없습니다.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 유지보수 정보 -->
        <div class="stit s mtb">유지보수 정보</div>
        <div class="board_list maintenance_info_list">
            <table>
                <colgroup>
                    <col class="w4">
                    <col class="w31">
                    <col width="*">
                    <col class="w19">
                </colgroup>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>계약기간</th>
                        <th>계약공수</th>
                        <th>계약서</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($client->contracts as $contract)
                    <tr>
                        <td class="num">{{ $contract->contract_order }}</td>
                        <td class="order1">
                            <div class="flex datepicker_wrap">
                                <div class="datepicker_area">{{ $contract->contract_start->format('Y.m.d') }}</div>
                                <span>~</span>
                                <div class="datepicker_area">{{ $contract->contract_end->format('Y.m.d') }}</div>
                            </div>
                        </td>
                        <td class="order2">
                            <div class="flex">
                                <dl>
                                    <dt>PM,기획</dt>
                                    <dd>{{ $contract->pm_hours }}h</dd>
                                </dl>
                                <dl>
                                    <dt>디자인</dt>
                                    <dd>{{ $contract->design_hours }}h</dd>
                                </dl>
                                <dl>
                                    <dt>퍼블리싱</dt>
                                    <dd>{{ $contract->publishing_hours }}h</dd>
                                </dl>
                                <dl>
                                    <dt>개발</dt>
                                    <dd>{{ $contract->development_hours }}h</dd>
                                </dl>
                            </div>
                            <div class="total_hours">
                                <strong>총 공수: {{ $contract->total_hours }}h</strong>
                            </div>
                        </td>
                        <td class="order3 file_wrap">
                            @if($contract->contract_file_path)
                                <a href="{{ route('admin.clients.contracts.download', $contract->idx) }}" download>
                                    {{ $contract->contract_file_name ?: '계약서 다운로드' }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty">등록된 계약 정보가 없습니다.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 서버, 기타정보 -->
        @if($client->serverInfo)
        <div class="stit s mtb">서버, 기타정보</div>
        <div class="tbl bdrs_l">
            <table>
                <tbody>
                    <tr>
                        <th>도메인</th>
                        <td colspan="3">{{ $client->serverInfo->domain ?: '-' }}</td>
                        <th>서브 도메인</th>
                        <td colspan="3">{{ $client->serverInfo->sub_domain ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>관리자 주소</th>
                        <td colspan="3">
                            @if($client->serverInfo->admin_url)
                                <a href="{{ $client->serverInfo->admin_url }}" target="_blank">{{ $client->serverInfo->admin_url }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <th>관리자 계정<br class="pc_vw">(ID/PW)</th>
                        <td colspan="3">{{ $client->serverInfo->admin_account ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>개발언어(버전)</th>
                        <td colspan="3">{{ $client->serverInfo->development_language ?: '-' }}</td>
                        <th>DB 종류</th>
                        <td colspan="3">{{ $client->serverInfo->database_type ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>도메인 기관</th>
                        <td colspan="3">{{ $client->serverInfo->domain_provider ?: '-' }}</td>
                        <th>서버 기관</th>
                        <td colspan="3">{{ $client->serverInfo->server_provider ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>SSL 기관</th>
                        <td colspan="3">{{ $client->serverInfo->ssl_provider ?: '-' }}</td>
                        <th>SSL 만료일</th>
                        <td colspan="3">
                            @if($client->serverInfo->ssl_expiry_date)
                                {{ $client->serverInfo->ssl_expiry_date->format('Y.m.d') }}
                                @if($client->serverInfo->isSslExpiringSoon())
                                    <span class="badge badge_red">만료 임박</span>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>FTP 주소</th>
                        <td>{{ $client->serverInfo->ftp_host ?: '-' }}</td>
                        <th>FTP ID</th>
                        <td>{{ $client->serverInfo->ftp_id ?: '-' }}</td>
                        <th>FTP PW</th>
                        <td>******</td>
                        <th>FTP ID</th>
                        <td>{{ $client->serverInfo->ftp_id ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>DB 호스트</th>
                        <td>{{ $client->serverInfo->db_host ?: '-' }}</td>
                        <th>DB ID</th>
                        <td>{{ $client->serverInfo->db_id ?: '-' }}</td>
                        <th>DB PW</th>
                        <td>******</td>
                        <th>DB ID</th>
                        <td>{{ $client->serverInfo->db_id ?: '-' }}</td>
                    </tr>
                    @if($client->serverInfo->notes)
                    <tr>
                        <th>비고</th>
                        <td colspan="7" class="pd16">{{ $client->serverInfo->notes }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @endif

        <!-- 계정 정보 -->
        @if($client->users->isNotEmpty())
        <div class="stit s mtb">계정 정보</div>
        <div class="board_list">
            <table>
                <colgroup>
                    <col class="w15">
                    <col class="w15">
                    <col class="w20">
                    <col class="w15">
                    <col class="w15">
                    <col class="w10">
                </colgroup>
                <thead>
                    <tr>
                        <th>로그인 ID</th>
                        <th>이름</th>
                        <th>이메일</th>
                        <th>연락처</th>
                        <th>직위</th>
                        <th>상태</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->users as $user)
                    <tr>
                        <td>{{ $user->login_id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if($user->email)
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $user->phone ?: '-' }}</td>
                        <td>{{ $user->position ?: '-' }}</td>
                        <td>
                            @if($user->is_active)
                                <span class="badge badge_green">활성</span>
                            @else
                                <span class="badge badge_red">비활성</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="board_bottom">
            <div class="btns_tac">
                <a href="{{ route('admin.clients.edit', $client->idx) }}" class="btn btn_g">수정</a>
                <a href="{{ route('admin.clients.index') }}" class="btn">목록</a>
            </div>
        </div>
    </div>
</div>
@endsection
