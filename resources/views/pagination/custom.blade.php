@if ($paginator->hasPages())
<nav>
    <div class="flex items-center border border-gray-300 rounded-sm">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <div class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium bg-white text-gray-500 cursor-default" aria-hidden="true">
                <i class="fas fa-chevron-left"></i>
            </span>
        </div>
        @else
        <div>
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium bg-white text-gray-700 hover:bg-gray-50 hover:text-red-500" aria-label="@lang('pagination.previous')">
                <i class="fas fa-chevron-left"></i>
            </a>
        </div>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <div class="disabled" aria-disabled="true">
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white cursor-default">{{ $element }}</span>
        </div>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <div class="active" aria-current="page">
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-500 border border-red-500 cursor-default">{{ $page }}</span>
        </div>
        @else
        <div>
            <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:text-red-500">{{ $page }}</a>
        </div>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <div>
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium bg-white text-gray-700 hover:bg-gray-50 hover:text-red-500" aria-label="@lang('pagination.next')">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
        @else
        <div class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium bg-white text-gray-500 cursor-default" aria-hidden="true">
                <i class="fas fa-chevron-right"></i>
            </span>
        </div>
        @endif
    </div>
</nav>
@endif