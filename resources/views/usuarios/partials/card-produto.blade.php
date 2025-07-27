<div class="bg-gray-900 border border-gray-700 rounded-2xl shadow-lg p-3 w-60 flex flex-col transition hover:scale-105 hover:shadow-indigo-500/20 duration-300">
@php
  $fotos = json_decode($produto->fotos, true);
  $foto = $fotos[0] ?? null;
@endphp

<img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/300x200?text=Produto' }}"
     class="w-full h-32 object-cover rounded-lg mb-3"
     alt="Imagem do Produto" />

  <h3 class="text-sm font-semibold text-indigo-400 truncate" title="{{ $produto->nome }}">
    {{ $produto->nome }}
  </h3>
  <p class="text-xs text-gray-400 mt-1 line-clamp-2" title="{{ $produto->caracteristica_produto }}">
    {{ $produto->caracteristica_produto }}
  </p>
  <p class="text-indigo-300 font-bold text-lg mt-2">
    R$ {{ number_format($produto->preco, 2, ',', '.') }}
  </p>
  <div class="mt-auto">
    <a href="#" data-url="{{ route('produtos.detalhes', $produto->id_produtos) }}"
   onclick="abrirDetalhesProduto(this)">
  Ver Detalhes
</a>


  </div>
</div>

<script>
  function abrirDetalhesProduto(elemento) {
  const url = elemento.getAttribute('data-url');
  const container = document.getElementById('detalhes-produto-container');
  const conteudo = document.getElementById('detalhes-produto-conteudo');

  fetch(url)
    .then(res => {
      if (!res.ok) throw new Error('Erro');
      return res.text();
    })
    .then(html => {
      conteudo.innerHTML = html;
      container.classList.remove('hidden');
    })
    .catch(() => {
      alert('Erro ao carregar detalhes do produto.');
    });
}

</script>
