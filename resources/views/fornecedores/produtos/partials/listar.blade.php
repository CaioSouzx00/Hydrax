<div class="bg-gray-900/80 border border-indigo-800 rounded-xl shadow p-8 max-w-7xl mx-auto text-white">

  <h3 class="text-white text-2xl mb-6 font-semibold">Lista de Produtos</h3>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-600 rounded text-white">
      {{ session('success') }}
    </div>
  @endif

  @if($produtos->isEmpty())
    <p class="text-gray-400">Nenhum produto cadastrado.</p>
  @else
    <div class="overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="bg-indigo-800 text-white">
          <tr>
            <th class="px-6 py-3">Nome</th>
            <th class="px-6 py-3">Preço</th>
            <th class="px-6 py-3">Categoria</th>
            <th class="px-6 py-3">Tamanhos</th>
            <th class="px-6 py-3">Fotos</th>
            <th class="px-6 py-3">Estoque (Imagens)</th>
            <th class="px-6 py-3">Ações</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
          @foreach($produtos as $produto)
            <tr class="hover:bg-gray-800/60 transition">
              <td class="px-6 py-4">{{ $produto->nome }}</td>
              <td class="px-6 py-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
              <td class="px-6 py-4">{{ ucfirst($produto->categoria) }}</td>

              <td class="px-6 py-4">
                @if(!empty($produto->tamanhos_disponiveis))
                  <div class="flex flex-wrap gap-1">
                    @foreach($produto->tamanhos_disponiveis as $tamanho)
                      <span class="bg-indigo-600 px-2 py-1 text-xs rounded">{{ $tamanho }}</span>
                    @endforeach
                  </div>
                @else
                  <span class="text-gray-400">-</span>
                @endif
              </td>

              <td class="px-6 py-4">
                @if(!empty($produto->fotos))
                  <div class="flex gap-2">
                    @foreach($produto->fotos as $foto)
                      <img src="{{ asset('storage/' . $foto) }}" class="w-10 h-10 rounded shadow" alt="Foto Produto">
                    @endforeach
                  </div>
                @else
                  <span class="text-gray-400">-</span>
                @endif
              </td>

              <td class="px-6 py-4">
                @php
                  $estoqueImgs = is_array($produto->estoque_imagem) ? $produto->estoque_imagem : json_decode($produto->estoque_imagem, true);
                @endphp
                @if(!empty($estoqueImgs))
                  <div class="flex gap-2">
                    @foreach($estoqueImgs as $img)
                      <img src="{{ asset('storage/' . $img) }}" class="w-10 h-10 rounded shadow" alt="Imagem Estoque">
                    @endforeach
                  </div>
                @else
                  <span class="text-gray-400">-</span>
                @endif
              </td>

              <td class="px-6 py-4 flex flex-col gap-1">
                <a href="#" 
                   data-url="{{ route('fornecedores.produtos.edit', $produto->id_produtos) }}" 
                   class="link-ajax text-indigo-400 hover:underline text-sm">
                  Editar
                </a>

                <!-- Botão para abrir modal -->
                <button
                  class="btn-excluir-produto text-red-400 hover:underline text-sm text-left p-0 bg-transparent border-0 cursor-pointer"
                  data-id="{{ $produto->id_produtos }}"
                >
                  Excluir
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
