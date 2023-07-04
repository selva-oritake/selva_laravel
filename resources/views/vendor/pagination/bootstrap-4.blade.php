@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center pagination-lg">
            {{-- Previous Page Link --}}
            @cannot('update', Model::class)

            @endcannot
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link text-success" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&laquo;前へ</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $maxPages = 3; // 最大表示ページ数
                $middlePages = ceil($maxPages / 2);
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $startPage = max($currentPage - $middlePages, 1);
                $endPage = min($startPage + $maxPages - 1, $lastPage);
            @endphp

            @if ($startPage > 1)
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif

            {{-- Array Of Links --}}
            
            @php
                $middlePageOffset = floor(($maxPages - 1) / 2);
                $startPage = max($currentPage - $middlePageOffset, 1);
                $endPage = min($startPage + $maxPages - 1, $lastPage);
            @endphp

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link bg-success border-success">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link text-success" href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                @endif
            @endfor

            @if ($endPage < $lastPage)
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link text-success" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">次へ&raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif