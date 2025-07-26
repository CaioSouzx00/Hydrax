<h3 class="text-white text-2xl mb-6 font-semibold">Lista de Produtos</h3>

@if(session('success'))
  <div class="mb-4 p-4 bg-green-600 rounded text-white">
    {{ session('success') }}
  </div>
@endif

@if($produtos->isEmpty())
  <p class="text-gray-400">Nenhum produto cadastrado ainda.</p>
@else
  <div class="overflow-x-auto">
    <table class="min-w-full bg-gray-800 rounded-lg">
      <thead>
        <tr class="text-left border-b border-indigo-600">
          <th class="px-6 py-3">Imagens</th>
          <th class="px-6 py-3">Nome</th>
          <th class="px-6 py-3">Descrição</th>
          <th class="px-6 py-3">Preço</th>
          <th class="px-6 py-3">Gênero</th>
          <th class="px-6 py-3">Categoria</th>
          <th class="px-6 py-3">Ativo</th>
          <th class="px-6 py-3">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach($produtos as $produto)
        <tr class="border-b border-indigo-700 hover:bg-indigo-700/30 transition">
          <td class="px-6 py-4">
            @if($produto->fotos)
              @foreach(json_decode($produto->fotos) as $foto)
                <img src="{{ asset('storage/' . $foto) }}" alt="Imagem do produto" class="inline-block w-16 h-16 object-cover rounded mr-1" />
              @endforeach
            @else
              <span class="text-gray-400">Sem imagens</span>
            @endif
          </td>
          <td class="px-6 py-4">{{ $produto->nome }}</td>
          <td class="px-6 py-4 truncate max-w-xs" title="{{ $produto->descricao }}">{{ $produto->descricao }}</td>
          <td class="px-6 py-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
          <td class="px-6 py-4">{{ ucfirst(strtolower($produto->genero)) }}</td>
          <td class="px-6 py-4">{{ ucfirst($produto->categoria) }}</td>
          <td class="px-6 py-4">
            @if($produto->ativo)
              <span class="px-2 py-1 bg-green-600 rounded">Sim</span>
            @else
              <span class="px-2 py-1 bg-red-600 rounded">Não</span>
            @endif
          </td>
          <td class="px-6 py-4">
            <a href="#" class="text-indigo-400 hover:text-indigo-600">Editar</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endif
