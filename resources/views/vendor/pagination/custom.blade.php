<div class="flex justify-center space-x-2 mt-6">
    @if ($paginator->onFirstPage())
        <span class="px-4 py-2 bg-gray-300 rounded cursor-not-allowed">Anterior</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Anterior</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-3 py-2">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-3 py-2 bg-blue-600 text-white rounded">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Próximo</a>
    @else
        <span class="px-4 py-2 bg-gray-300 rounded cursor-not-allowed">Próximo</span>
    @endif
</div>
