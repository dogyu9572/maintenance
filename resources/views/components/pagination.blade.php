@props(['paginator'])

@if($paginator->count() > 0)
<div class="paging mt1">
    {{-- 맨끝 이전 버튼 --}}
    @if($paginator->onFirstPage())
        <span class="arrow one first">맨끝</span>
        <span class="arrow two prev">이전</span>
    @else
        <a href="{{ $paginator->url(1) }}" class="arrow one first">맨끝</a>
        <a href="{{ $paginator->previousPageUrl() }}" class="arrow two prev">이전</a>
    @endif

    {{-- 페이지 번호들 --}}
    @php
        $start = max(1, $paginator->currentPage() - 2);
        $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
        
        // 페이지가 5개 미만일 때 전체 표시
        if ($end - $start < 4) {
            $start = max(1, $end - 4);
        }
    @endphp

    @for($page = $start; $page <= $end; $page++)
        @if($page == $paginator->currentPage())
            <span class="on">{{ $page }}</span>
        @else
            <a href="{{ $paginator->url($page) }}">{{ $page }}</a>
        @endif
    @endfor

    {{-- 다음 맨끝 버튼 --}}
    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="arrow two next">다음</a>
        <a href="{{ $paginator->url($paginator->lastPage()) }}" class="arrow one last">맨끝</a>
    @else
        <span class="arrow two next">다음</span>
        <span class="arrow one last">맨끝</span>
    @endif
</div>
@endif 