
@php
    function calculatePaginationRange($currentPage, $lastPage) {
        $maxPagesToShow = 10;
        $start = max(1, min($currentPage - 5, $lastPage - $maxPagesToShow + 1));
        $end = min($start + $maxPagesToShow - 1, $lastPage);

         return [$start, $end];
    }

    list($start, $end) = calculatePaginationRange($paginator->currentPage(), $paginator->lastPage());
@endphp

    <style>
        .pagination-container {
            display: flex;
            justify-content: end;
            align-items: center;
        }

        .pagination {
            display: inline-block;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            display: inline;
        }

        .pagination li a {
            color: #00812C;
            float: left;
            /* padding: 8px 16px; */
            width: 30px;
            height: 30px;
            text-decoration: none;
            border: 1px solid #00812C;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination li.disabled a {
            color: #00812C;
            cursor: not-allowed;
        }

        .pagination li.active a {
            background-color: #00812C;
            color: white;
        }
    </style>

@if ($paginator->lastPage() > 1)
<div class="pagination-container pt-3">
    <ul class="pagination">
        <li class="{{ $paginator->currentPage() == 1 ? 'disabled' : '' }}">
            @if($paginator->currentPage() != 1)
                <a class="rounded-lg mr-1" href="{{ $paginator->previousPageUrl() }}">
                    <span><i class="fa-solid fa-angles-left text-sm"></i></span>
                </a>
            @endif
        </li>
        @for ($i = $start; $i <= $end; $i++)
            <li class="{{ $paginator->currentPage() == $i ? 'active' : '' }}">
                <a class="font-jakarta rounded-lg mx-1 font-semibold" href="{{ url()->current().'?page='.$i }}" data-page="{{ $i }}">
                    <span class="text-sm">{{ $i }}</span>
                </a>
            </li>
        @endfor
        <li class="{{ $paginator->currentPage() === $paginator->lastPage() ? 'disabled' : '' }}">
            @if($paginator->currentPage() != $paginator->lastPage())
                <a class="rounded-lg ml-1" href="{{ $paginator->nextPageUrl() }}">
                    <span><i class="fa-solid fa-angles-right text-sm"></i></span>
                </a>
            @endif
        </li>
    </ul>
</div>
@endif
