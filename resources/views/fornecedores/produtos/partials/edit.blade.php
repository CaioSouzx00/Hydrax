<div class="bg-gray-900/80 border border-indigo-800 rounded-xl shadow p-8 max-w-4xl mx-auto text-white">
  <h2 class="text-2xl font-semibold mb-6 text-indigo-400">Editar Produto</h2>

  <form action="{{ route('fornecedores.produtos.update', $produto->id_produtos) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Nome -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-indigo-300">Nome</label>
      <input name="nome" value="{{ old('nome', $produto->nome) }}" class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">
    </div>

    <!-- Descrição -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-indigo-300">Descrição</label>
      <textarea name="descricao" class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">{{ old('descricao', $produto->descricao) }}</textarea>
    </div>

    <!-- Preço -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-indigo-300">Preço</label>
      <input type="number" step="0.01" name="preco" value="{{ old('preco', $produto->preco) }}" class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">
    </div>

    <!-- Características -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-indigo-300">Características</label>
      <textarea name="caracteristicas" class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">{{ old('caracteristicas', $produto->caracteristicas) }}</textarea>
    </div>

    <!-- Histórico de Modelos -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-indigo-300">Histórico de Modelos</label>
      <textarea name="historico_modelos" class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">{{ old('historico_modelos', $produto->historico_modelos) }}</textarea>
    </div>

    <!-- Tamanhos Disponíveis -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-indigo-300">Tamanhos Disponíveis</label>
      <input name="tamanhos_disponiveis" value="{{ old('tamanhos_disponiveis', is_array($produto->tamanhos_disponiveis) ? implode(',', $produto->tamanhos_disponiveis) : '') }}" class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">
    </div>

    <!-- Gênero -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-indigo-300">Gênero</label>
      <select name="genero" class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">
        <option value="MASCULINO" @selected($produto->genero === 'MASCULINO')>Masculino</option>
        <option value="FEMININO" @selected($produto->genero === 'FEMININO')>Feminino</option>
        <option value="UNISSEX" @selected($produto->genero === 'UNISSEX')>Unissex</option>
      </select>
    </div>

    <!-- Categoria -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-indigo-300">Categoria</label>
      <input name="categoria" value="{{ old('categoria', $produto->categoria) }}" class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">
    </div>

    <!-- Fotos -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-indigo-300">Fotos do Produto</label>
      <input type="file" name="fotos[]" multiple class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">
      @if (is_array($produto->fotos))
        <div class="text-sm mt-2 text-indigo-400">
          Fotos atuais:
          <ul class="list-disc ml-4">
            @foreach ($produto->fotos as $foto)
              <li><a href="{{ asset('storage/' . $foto) }}" target="_blank" class="underline">{{ $foto }}</a></li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
        <!-- Estoque de Imagem -->


    <div class="mb-4">


      <label class="block text-sm font-medium text-indigo-300">Estoque Imagem (upload múltiplo)</label>


      <input type="file" name="estoque_imagem[]" multiple class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">


      @if (is_array($produto->estoque_imagem))


        <div class="text-sm mt-2 text-indigo-400">


          Imagens atuais de estoque:


          <ul class="list-disc ml-4">


            @foreach ($produto->estoque_imagem as $img)


              <li><a href="{{ asset('storage/' . $img) }}" target="_blank" class="underline">{{ $img }}</a></li>

     @endforeach
          </ul>
        </div>
      @endif
    </div>



    <!-- Slug -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-indigo-300">Slug</label>
      <input name="slug" value="{{ old('slug', $produto->slug) }}" class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white" readonly>
    </div>

    <!-- Ativo -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-indigo-300">Ativo?</label>
      <select name="ativo" class="w-full bg-gray-800 border border-indigo-600 rounded p-2 text-white">
        <option value="1" @selected($produto->ativo)>Sim</option>
        <option value="0" @selected(!$produto->ativo)>Não</option>
      </select>
    </div>

    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
      Salvar Alterações
    </button>
  </form>
</div>
