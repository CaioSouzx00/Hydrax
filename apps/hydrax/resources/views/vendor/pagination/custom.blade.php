@if ($paginator->hasPages())
<div class="flex justify-center mt-6 space-x-2 p-1 bg-[#211828] rounded border border-[#564d5d]">

    {{-- Botão Anterior --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-1 rounded bg-gray-700 text-gray-400 cursor-not-allowed">&laquo;</span>
    @else
        
        <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded bg-black/70 text-white hover:bg-[#14BA88]/50 transition-colors">&laquo;</a>
    @endif

    {{-- Páginas --}}
    @for ($page = 1; $page <= $paginator->lastPage(); $page++)
        @if ($page == $paginator->currentPage())
            <span class="px-3 py-1 bg-[#14BA88] text-black font-semibold rounded">{{ $page }}</span>
        @else
            <a href="{{ $paginator->url($page) }}" class="px-3 py-1 rounded bg-black/70 text-white hover:bg-[#14BA88]/40 transition-colors">{{ $page }}</a>
        @endif
    @endfor

    {{-- Botão Próximo --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded bg-black/70 text-white hover:bg-[#14BA88]/50 transition-colors">&raquo;</a>
    @else
        <span class="px-3 py-1 rounded bg-gray-700 text-gray-400 cursor-not-allowed">&raquo;</span>
    @endif

</div>
@endif
