<?php
/** @var $paginator \Illuminate\Pagination\LengthAwarePaginator */
?>

@if($paginator->hasPages())
<nav class="flex justify-center items-center gap-2 mt-12 mb-8">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-100 bg-gray-50 text-gray-300 cursor-not-allowed">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <span class="flex items-center justify-center w-10 h-10 text-gray-400">...</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary text-white font-bold shadow-lg shadow-primary/30 cursor-default">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-primary hover:border-primary-200 transition-all shadow-sm font-medium">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </a>
    @else
        <span class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-100 bg-gray-50 text-gray-300 cursor-not-allowed">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </span>
    @endif
</nav>
@endif
