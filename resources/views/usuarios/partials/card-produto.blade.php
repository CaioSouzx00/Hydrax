<div class="relative w-96 mx-auto group">
    <a href="{{ route('produtos.detalhes', $produto->id_produtos) }}">
        <div
            class="bg-[#111]/50 border border-[#222] rounded-xl shadow-lg p-8 min-h-[580px] cursor-pointer
                   hover:border-[#D5891B]/40 transition-all duration-300 
                   hover:shadow-2xl hover:shadow-[#d5891b]/20 hover:-translate-y-2 hover:scale-[1.02]">
            
            @php
                $fotos = is_array($produto->fotos) ? $produto->fotos : json_decode($produto->fotos, true);
                $foto = is_array($fotos) && count($fotos) > 0 ? $fotos[0] : null;
            @endphp

            <!-- Imagem principal -->
            <div class="w-full mb-4 overflow-hidden rounded-lg relative">
                <img
                    id="main-image-{{ $produto->id_produtos }}"
                    src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/400x400?text=Produto' }}"
                    alt="Imagem do Produto"
                    class="w-full h-72 object-cover rounded-lg border border-[#D5891B]/20 shadow-sm transition-transform duration-500 group-hover:scale-105"
                />

                <!-- Miniaturas escondidas -->
                @if($fotos && count($fotos) > 1)
                    <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-2
                                opacity-0 group-hover:opacity-100
                                pointer-events-none group-hover:pointer-events-auto
                                transition-all duration-300 z-50">
                        @foreach($fotos as $miniatura)
                            <img 
                                src="{{ asset('storage/' . $miniatura) }}"
                                class="w-12 h-12 object-cover rounded-md border border-[#d5891b]/30 
                                       cursor-pointer hover:scale-110 transition"
                                onclick="document.getElementById('main-image-{{ $produto->id_produtos }}').src=this.src"
                            >
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Conteúdo -->
            <div class="flex flex-col space-y-3 transition-all duration-300 group-hover:translate-y-1">
                <h3 class="text-base font-semibold text-white truncate" title="{{ $produto->nome }}">
                    {{ $produto->nome }}
                </h3>

                <p class="text-xs text-gray-400">{{ $produto->categoria }}</p>

                <p class="text-white font-bold text-lg mt-1">
                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                </p>

                <div class="flex items-center space-x-2 mt-2">
                    <img 
                        src="{{ $produto->fornecedor->foto ? asset('storage/' . $produto->fornecedor->foto) : 'https://via.placeholder.com/40x40?text=F' }}" 
                        alt="Foto do fornecedor"
                        class="w-8 h-8 rounded-full object-cover border border-[#D5891B]/20"
                    >
                    <span class="text-xs text-gray-400">
                        {{ $produto->fornecedor->nome_empresa ?? 'Fornecedor não informado' }}
                    </span>
                </div>

                {{-- estrelas --}}
                <div class="flex items-center space-x-2 mt-1">
                    <div class="flex items-center space-x-[1px]">
                        @php
                            $notaMediaCard = $produto->avaliacoes_avg_nota ?? 0;
                            $avaliacoesContador = $produto->avaliacoes->count() ?? 0;
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($notaMediaCard))
                                <span class="text-[#14ba88]">&#9733;</span>
                            @elseif ($i - 0.5 <= $notaMediaCard)
                                <span class="text-[#14ba88] opacity-50">&#9733;</span>
                            @else
                                <span class="text-gray-600">&#9733;</span>
                            @endif
                        @endfor
                    </div>
                    @if($avaliacoesContador > 0)
                        <span class="text-xs text-gray-400">({{ $avaliacoesContador }} avaliações)</span>
                    @endif
                </div>
            </div>
        </div>
    </a>

    {{-- Botão wishlist --}}
    <form action="{{ route('lista-desejos.store', $produto->id_produtos) }}" method="POST" 
          class="wishlist-form absolute top-3 right-3 z-20">
        @csrf

        @php
            $isDesejado = in_array($produto->id_produtos, $idsDesejados);
        @endphp
        
        <button type="submit" 
                class="w-8 h-8 flex items-center justify-center bg-[#071a1c] border border-[#d5891b]/30 
                       rounded-lg hover:bg-[#222] transition transform hover:scale-110 active:scale-95">
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                class="w-5 h-5 text-[#d5891b]/70 transition-colors duration-300"
                fill="{{ $isDesejado ? '#d5891b' : 'none' }}" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 
                        4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 
                        4.5 0 00-6.364 0z" />
            </svg>
        </button>
    </form>
</div>
