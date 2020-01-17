@if ($paginator->hasPages())
    <nav class="pagination justify-content-center flex-wrap" role="navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">{{ __('Previous') }}</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ __('Previous') }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">{{ __('Next') }}</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">{{ __('Next') }}</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
