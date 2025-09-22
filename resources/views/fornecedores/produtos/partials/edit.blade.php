<div class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] border border-[#d5891b]/50 rounded-xl shadow-lg p-8 max-w-6xl mx-auto mb-12 text-white">
  <style>
    /* Scrollbar WebKit */
    .custom-scrollbar::-webkit-scrollbar {
      width: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
      background: #0b282a;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
      background-color: #d5891b;
      border-radius: 10px;
      border: 2px solid #0b282a;
    }

    /* Scrollbar Firefox */
    .custom-scrollbar {
      scrollbar-width: thin;
      scrollbar-color: #d5891b #0b282a;
    }
  </style>

  <h2 class="text-2xl font-semibold mb-6 text-[#e29b37]">Editar Produto</h2>

  <form action="{{ route('fornecedores.produtos.update', $produto->id_produtos) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @csrf
    @method('PUT')

    <!-- Nome -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Nome</label>
      <input name="nome" value="{{ old('nome', $produto->nome) }}" class="w-full h-10 bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-white/70 hover:text-white">
    </div>

    <!-- Preço -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Preço</label>
      <input type="number" step="0.01" name="preco" value="{{ old('preco', $produto->preco) }}" class="w-full h-10 bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-white/70 hover:text-white">
    </div>

    <!-- Categoria -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Categoria</label>
      <input name="categoria" value="{{ old('categoria', $produto->categoria) }}" class="w-full h-10 bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-white/70 hover:text-white">
    </div>

    <!-- Gênero -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Gênero</label>
      <select name="genero" class="w-full h-10 bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-white/70 hover:text-white">
        <option value="MASCULINO" @selected($produto->genero === 'MASCULINO')>Masculino</option>
        <option value="FEMININO" @selected($produto->genero === 'FEMININO')>Feminino</option>
        <option value="UNISSEX" @selected($produto->genero === 'UNISSEX')>Unissex</option>
      </select>
    </div>

    <!-- Tamanhos -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Tamanhos Disponíveis</label>
      <input name="tamanhos_disponiveis" value="{{ old('tamanhos_disponiveis', is_array($produto->tamanhos_disponiveis) ? implode(',', $produto->tamanhos_disponiveis) : '') }}" class="w-full h-10 bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-white/70 hover:text-white">
    </div>

    <!-- Slug -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Slug</label>
      <input name="slug" value="{{ old('slug', $produto->slug) }}" readonly class="w-full h-10 bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-gray-400 cursor-not-allowed">
    </div>

    <!-- Ativo -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Ativo?</label>
      <select name="ativo" class="w-full h-10 bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-white/70 hover:text-white">
        <option value="1" @selected($produto->ativo)>Sim</option>
        <option value="0" @selected(!$produto->ativo)>Não</option>
      </select>
    </div>

    <!-- Descrição -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Descrição</label>
      <textarea name="descricao" class="custom-scrollbar w-full h-10 resize-none bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-white/70 hover:text-white">{{ old('descricao', $produto->descricao) }}</textarea>
    </div>

    <!-- Características -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Características</label>
      <textarea name="caracteristicas" class="custom-scrollbar w-full h-10 resize-none bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-white/70 hover:text-white">{{ old('caracteristicas', $produto->caracteristicas) }}</textarea>
    </div>

    <!-- Histórico -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Código Modelo</label>
      <textarea name="historico_modelos" class="custom-scrollbar w-full h-10 resize-none bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-white/70 hover:text-white">{{ old('historico_modelos', $produto->historico_modelos) }}</textarea>
    </div>

    <!-- Fotos -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Fotos do Produto</label>
      <input type="file" name="fotos[]" multiple class="w-full h-10 bg-[#17110d] border border-[#d5891b]/40 file:bg-[#e29b37] file:hover:bg-[#b97e2c] file:text-[#542409] file:border-[#542409] file:rounded file:mt-1 file:hover:cursor-pointer rounded px-2 text-white/70 hover:text-white">
      @if (is_array($produto->fotos))
        <div class="text-sm mt-2 text-[#e29b37]">
          Fotos atuais:
          <ul class="list-disc ml-4">
            @foreach ($produto->fotos as $foto)
              <li><a href="{{ asset('storage/' . $foto) }}" target="_blank" class="underline">{{ $foto }}</a></li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    <!-- Estoque -->
    <div>
      <label class="block text-sm font-medium text-[#d5891b]">Estoque Imagem (upload múltiplo)</label>
      <input type="file" name="estoque_imagem[]" multiple class="w-full h-10 bg-[#17110d] border border-[#d5891b]/40 file:bg-[#e29b37] file:hover:bg-[#b97e2c] file:text-[#542409] file:border-[#542409] file:rounded file:mt-1 file:hover:cursor-pointer rounded px-2 text-white/70 hover:text-white">
      @if (is_array($produto->estoque_imagem))
        <div class="text-sm mt-2 text-[#e29b37]">
          Imagens atuais de estoque:
          <ul class="list-disc ml-4">
            @foreach ($produto->estoque_imagem as $img)
              <li><a href="{{ asset('storage/' . $img) }}" target="_blank" class="underline">{{ $img }}</a></li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    <!-- Botão -->
    <div class="col-span-2 text-left">
      <button type="submit" class="bg-[#d5891b] hover:bg-[#e29b37] text-black/80 font-semibold py-2 px-6 rounded transition">
        Salvar Alterações
      </button>
    </div>

  </form>
</div>

<script>
  const inputs = document.querySelectorAll('form input, form select, form textarea');

  inputs.forEach(el => {
    el.addEventListener('focus', () => {
      document.body.style.overflow = 'hidden';
    });
    el.addEventListener('blur', () => {
      document.body.style.overflow = 'auto';
    });
  });
</script>
