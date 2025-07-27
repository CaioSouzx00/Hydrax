<div class="p-6 text-white bg-gray-900 rounded-2xl shadow-lg max-w-4xl mx-auto">
  <button onclick="fecharDetalhes()" class="text-sm text-red-400 hover:text-red-600 float-right">✕ Fechar</button>

  <h2 class="text-2xl font-semibold text-indigo-400 mb-4">{{ $produto->nome }}</h2>

  @php
    $fotos = json_decode($produto->fotos, true) ?: [];
    $tamanhos = json_decode($produto->tamanhos_disponiveis, true) ?: [];
    $estoqueImagens = json_decode($produto->estoque_imagem, true) ?: [];
  @endphp

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <img src="{{ $fotos[0] ? asset('storage/' . $fotos[0]) : 'https://via.placeholder.com/400x300?text=Produto' }}"
         class="w-full h-auto object-cover rounded-xl shadow" alt="Imagem principal">

    <div>
      <p class="mb-2"><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
      <p class="mb-2"><strong>Descrição:</strong> {{ $produto->descricao }}</p>
      <p class="mb-2"><strong>Características:</strong> {{ $produto->caracteristica_produto }}</p>
      <p class="mb-2"><strong>História:</strong> {{ $produto->historia }}</p>
      <p class="mb-2"><strong>Gênero:</strong> {{ $produto->genero }}</p>
      <p class="mb-2"><strong>Categoria:</strong> {{ $produto->categoria }}</p>

      <p class="mb-2"><strong>Tamanhos Disponíveis:</strong>
        @if(count($tamanhos) > 0)
          {{ implode(', ', $tamanhos) }}
        @else
          Nenhum tamanho disponível
        @endif
      </p>

      {{-- Carrossel para estoque_imagem --}}
      <div class="mt-6">
        <h3 class="text-indigo-400 font-semibold mb-2">Imagens do Estoque</h3>

        @if(count($estoqueImagens) > 0)
          <div class="relative w-full max-w-md mx-auto">
            <div id="carrosselEstoque" class="overflow-hidden rounded-xl shadow-lg">
              @foreach($estoqueImagens as $index => $img)
                <img
                  src="{{ asset('storage/' . $img) }}"
                  alt="Imagem estoque {{ $index + 1 }}"
                  class="w-full h-64 object-cover transition-opacity duration-500 {{ $index === 0 ? 'block' : 'hidden' }}"
                  data-index="{{ $index }}"
                >
              @endforeach
            </div>

            <button
              onclick="mudarImagem(-1)"
              class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-indigo-600 bg-opacity-75 hover:bg-indigo-700 text-white rounded-full p-2"
              aria-label="Imagem anterior"
            >
              ‹
            </button>
            <button
              onclick="mudarImagem(1)"
              class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-indigo-600 bg-opacity-75 hover:bg-indigo-700 text-white rounded-full p-2"
              aria-label="Próxima imagem"
            >
              ›
            </button>
          </div>
        @else
          <p class="text-gray-400">Nenhuma imagem de estoque disponível.</p>
        @endif
      </div>

      @if(count($fotos) > 1)
        <p class="mb-2 mt-6"><strong>Outras Fotos:</strong></p>
        <div class="flex gap-2 overflow-x-auto">
          @foreach($fotos as $index => $foto)
            @if($index != 0)
              <img src="{{ asset('storage/' . $foto) }}" alt="Foto {{ $index + 1 }}" class="w-24 h-24 object-cover rounded shadow cursor-pointer" onclick="document.querySelector('img.object-cover').src=this.src">
            @endif
          @endforeach
        </div>
      @endif

    </div>
  </div>
</div>

<script>
  let imgAtual = 0;
  const imagens = document.querySelectorAll('#carrosselEstoque img');

  function mudarImagem(direcao) {
    imagens[imgAtual].classList.add('hidden');
    imagens[imgAtual].classList.remove('block');

    imgAtual += direcao;
    if (imgAtual < 0) imgAtual = imagens.length - 1;
    if (imgAtual >= imagens.length) imgAtual = 0;

    imagens[imgAtual].classList.remove('hidden');
    imagens[imgAtual].classList.add('block');
  }
</script>
