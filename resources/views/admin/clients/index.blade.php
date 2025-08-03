@extends('layouts.app')

@section('title', '클라이언트 관리')

@section('content')
<div id="mainContent" class="container sub_wrap clients_wrap">
    <div class="inner">
        <div class="title">클라이언트 관리</div>

        <!-- 검색 및 필터 -->
        <div class="board_search">
            <form method="GET" action="{{ route('admin.clients.index') }}" class="search-form">
                <div class="search_wrap">
                    <div class="search_box">
                        <input type="text" name="search" class="text" placeholder="클라이언트명 검색" value="{{ request('search') }}">
                        <button type="submit" class="btn_search">검색</button>
                    </div>
                    <div class="filter_wrap">
                        <select name="client_type" class="text">
                            <option value="">전체 타입</option>
                            <option value="association" {{ request('client_type') == 'association' ? 'selected' : '' }}>협회</option>
                            <option value="company" {{ request('client_type') == 'company' ? 'selected' : '' }}>회사</option>
                            <option value="individual" {{ request('client_type') == 'individual' ? 'selected' : '' }}>개인</option>
                        </select>
                        <select name="is_active" class="text">
                            <option value="">전체 상태</option>
                            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>활성</option>
                            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>비활성</option>
                        </select>
                        <button type="submit" class="btn">필터</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- 클라이언트 목록 -->
        <div class="board_list">
            <div class="board_top">
                <div class="board_info">
                    <span>총 {{ $clients->total() }}건</span>
                </div>
                <div class="board_btn">
                    <a href="{{ route('admin.clients.create') }}" class="btn btn_g">클라이언트 생성</a>
                </div>
            </div>

            <table>
                <colgroup>
                    <col class="w8">
                    <col class="w15">
                    <col class="w10">
                    <col class="w12">
                    <col class="w12">
                    <col class="w10">
                    <col class="w8">
                </colgroup>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>클라이언트명</th>
                        <th>타입</th>
                        <th>계약기간</th>
                        <th>담당자</th>
                        <th>상태</th>
                        <th>관리</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td class="num">{{ $clients->firstItem() + $loop->index }}</td>
                        <td class="name">
                            <a href="{{ route('admin.clients.show', $client->idx) }}" class="link">
                                {{ $client->name }}
                            </a>
                        </td>
                        <td class="type">
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
                        <td class="period">
                            {{ $client->contract_start ? $client->contract_start->format('Y.m.d') : '-' }} ~
                            {{ $client->contract_end ? $client->contract_end->format('Y.m.d') : '-' }}
                        </td>
                        <td class="manager">
                            @if($client->managers->isNotEmpty())
                                {{ $client->managers->first()->name }}
                                @if($client->managers->count() > 1)
                                    <span class="more">+{{ $client->managers->count() - 1 }}</span>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td class="status">
                            @if($client->is_active)
                                <span class="badge badge_green">활성</span>
                            @else
                                <span class="badge badge_red">비활성</span>
                            @endif
                        </td>
                        <td class="action">
                            <div class="btn_wrap">
                                <a href="{{ route('admin.clients.show', $client->idx) }}" class="btn btn_s">보기</a>
                                <a href="{{ route('admin.clients.edit', $client->idx) }}" class="btn btn_s">수정</a>
                                <button type="button" class="btn btn_s btn_del" onclick="deleteClient({{ $client->idx }})">삭제</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty">등록된 클라이언트가 없습니다.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 페이지네이션 -->
        @if($clients->hasPages())
        <div class="pagination_wrap">
            {{ $clients->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function deleteClient(clientId) {
    if (confirm('정말로 이 클라이언트를 삭제하시겠습니까?\n관련된 모든 데이터가 함께 삭제됩니다.')) {
        fetch(`/admin/clients/${clientId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('클라이언트가 삭제되었습니다.');
                location.reload();
            } else {
                alert('삭제 중 오류가 발생했습니다.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('삭제 중 오류가 발생했습니다.');
        });
    }
}
</script>
@endsection
