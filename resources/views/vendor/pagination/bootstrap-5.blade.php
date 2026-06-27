@if ($paginator->total() > 0)
    <div class="pagination-wrapper">
        <p class="small text-muted mb-0">
            Showing
            <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            to
            <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            of
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            entries
        </p>

        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();

            $stepPC = 2;
            $startPC = floor(($currentPage - 1) / $stepPC) * $stepPC + 1;
            $endPC = min($startPC + $stepPC, $lastPage);

            $stepHP = 1;
            $startHP = floor(($currentPage - 1) / $stepHP) * $stepHP + 1;
            $endHP = min($startHP + $stepHP, $lastPage);
        @endphp

        <div class="d-none d-sm-flex">
            <ul class="pagination pagination-sm mb-0">

                @if ($paginator->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                            rel="prev">&lsaquo;</a></li>
                @endif

                @if ($startPC > 1)
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                    @if ($startPC > 2)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                @endif

                @for ($i = $startPC; $i <= $endPC; $i++)
                    @if ($i == $currentPage)
                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link"
                                href="{{ $paginator->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                @if ($endPC < $lastPage)
                    @if ($endPC < $lastPage - 1)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                    <li class="page-item"><a class="page-link"
                            href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a></li>
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"
                            rel="next">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
        </div>

        <div class="d-flex d-sm-none justify-content-center w-100">
            <ul class="pagination pagination-sm mb-0">

                @if ($paginator->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                            rel="prev">&lsaquo;</a></li>
                @endif

                @if ($startHP > 1)
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                    @if ($startHP > 2)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                @endif

                @for ($i = $startHP; $i <= $endHP; $i++)
                    @if ($i == $currentPage)
                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link"
                                href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if ($endHP < $lastPage)
                    @if ($endHP < $lastPage - 1)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                    <li class="page-item"><a class="page-link"
                            href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a></li>
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"
                            rel="next">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
        </div>
    </div>
@endif
