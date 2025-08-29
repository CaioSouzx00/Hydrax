<a href="{{ route('produtos.detalhes', $produto->id_produtos) }}" class="block w-72 mx-auto">
  <div
    class="bg-[#111]/50 border border-[#222] rounded-xl shadow-lg p-5 min-h-[420px] cursor-pointer hover:border-[#D5891B]/20 transition-all duration-200"
    role="button"
    tabindex="0"
  >
    @php
      $fotos = json_decode($produto->fotos, true);
      $foto = is_array($fotos) && count($fotos) > 0 ? $fotos[0] : null;
    @endphp

    <div class="w-full mb-3">
      <img
        src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/400x400?text=Produto' }}"
        alt="Imagem do Produto"
        class="w-full h-56 object-cover rounded-lg border border-[#D5891B]/20 shadow-sm"
      />
    </div>

    <div class="flex flex-col space-y-2">
      <h3 class="text-base font-semibold text-white truncate" title="{{ $produto->nome }}">
        {{ $produto->nome }}
      </h3>

      <p class="text-xs text-gray-400 line-clamp-3" title="{{ $produto->caracteristica_produto }}">
        {{ $produto->caracteristica_produto }}
      </p>

      <p class="text-white font-bold text-lg mt-1">
        R$ {{ number_format($produto->preco, 2, ',', '.') }}
      </p>

      <p class="text-xs text-gray-400">
        {{ $produto->categoria }}
      </p>


      {{-- estrelas fixas de exemplo --}}
      <div class="flex items-center space-x-2 mt-1" aria-label="Avaliação: 4.5 de 5 estrelas" role="img">
        <div class="flex items-center space-x-[1px]">
          @for ($i = 0; $i < 4; $i++)
            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.97c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.176 0l-3.38 2.454c-.784.57-1.838-.196-1.539-1.118l1.287-3.97a1 1 0 00-.364-1.118L2.047 9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z"/>
            </svg>
          @endfor
          <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <defs>
              <linearGradient id="half-grad" x1="0" x2="100%" y1="0" y2="0">
                <stop offset="50%" stop-color="currentColor" />
                <stop offset="50%" stop-color="transparent" />
              </linearGradient>
            </defs>
            <path fill="url(#half-grad)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.97c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.176 0l-3.38 2.454c-.784.57-1.838-.196-1.539-1.118l1.287-3.97a1 1 0 00-.364-1.118L2.047 9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z"/>
          </svg>
        </div>

        <div class="text-yellow-400 font-semibold bg-[#3c2a0d] rounded px-1.5 py-[1px] text-[11px] leading-none select-none">
          4.5
        </div>
      </div>
    </div>
  </div>
</a>
