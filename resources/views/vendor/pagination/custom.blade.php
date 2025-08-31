<div class="flex justify-center mt-6 space-x-2 p-1 bg-[#211828] rounded border border-[#564d5d]">
    {{-- Botão anterior --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-1 rounded bg-gray-700 text-gray-400 cursor-not-allowed">&laquo;</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded bg-black/70 text-white hover:bg-[#14BA88]/50 transition-colors">&laquo;</a>
    @endif

    {{-- Páginas --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-3 py-1 text-gray-400">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-3 py-1 bg-[#14BA88] text-black font-semibold rounded">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1 rounded bg-black/70 text-white hover:bg-[#14BA88]/40 transition-colors">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Botão próximo --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded bg-black/70 text-white hover:bg-[#14BA88]/50 transition-colors">&raquo;</a>
    @else
        <span class="px-3 py-1 rounded bg-gray-700 text-gray-400 cursor-not-allowed">&raquo;</span>
    @endif
</div>
