<div class="bg-[#0b282a]/70 border border-[#14ba88] rounded-xl shadow-lg p-8 max-w-5xl mx-auto text-white font-poppins">
  <h2 class="text-2xl font-semibold mb-6 text-[#14ba88]">Cadastrar Produto</h2>

  @if(session('success'))
    <div class="bg-green-700/70 text-green-100 p-4 rounded mb-6 text-sm font-medium">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('fornecedores.produtos.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf

    {{-- Nome --}}
    <div class="flex flex-col">
      <label for="nome" class="text-sm text-white/70 mb-1">Nome do Produto</label>
      <input type="text" id="nome" name="nome"
        class="px-4 py-3 bg-black/40 text-white placeholder-white/40 border border-[#14ba88]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#14ba88] focus:bg-black/30 transition"
        required>
    </div>

    {{-- Descrição --}}
    <div class="flex flex-col">
      <label for="descricao" class="text-sm text-white/70 mb-1">Descrição</label>
      <input type="text" id="descricao" name="descricao"
        class="px-4 py-3 bg-black/40 text-white placeholder-white/40 border border-[#14ba88]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#14ba88] focus:bg-black/30 transition">
    </div>

    {{-- Preço --}}
    <div class="flex flex-col">
      <label for="preco" class="text-sm text-white/70 mb-1">Preço (R$)</label>
      <input type="number" id="preco" name="preco" step="0.01"
        class="px-4 py-3 bg-black/40 text-white placeholder-white/40 border border-[#14ba88]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#14ba88] focus:bg-black/30 transition"
        required>
    </div>

    {{-- Características --}}
    <div class="flex flex-col">
      <label for="caracteristicas" class="text-sm text-white/70 mb-1">Características</label>
      <input type="text" id="caracteristicas" name="caracteristicas"
        class="px-4 py-3 bg-black/40 text-white placeholder-white/40 border border-[#14ba88]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#14ba88] focus:bg-black/30 transition">
    </div>

    {{-- Histórico de Modelos --}}
    <div class="flex flex-col">
      <label for="historico_modelos" class="text-sm text-white/70 mb-1">Histórico de Modelos</label>
      <input type="text" id="historico_modelos" name="historico_modelos"
        class="px-4 py-3 bg-black/40 text-white placeholder-white/40 border border-[#14ba88]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#14ba88] focus:bg-black/30 transition">
    </div>

    {{-- Tamanhos Disponíveis --}}
    <div class="flex flex-col">
      <label for="tamanhos_disponiveis" class="text-sm text-white/70 mb-1">Tamanhos Disponíveis</label>
      <input type="text" id="tamanhos_disponiveis" name="tamanhos_disponiveis"
        class="px-4 py-3 bg-black/40 text-white placeholder-white/40 border border-[#14ba88]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#14ba88] focus:bg-black/30 transition">
    </div>

    {{-- Gênero --}}
    <div class="flex flex-col">
      <label for="genero" class="text-sm text-white/70 mb-1">Gênero</label>
      <select id="genero" name="genero"
        class="px-4 py-3 bg-black/40 text-white border border-[#14ba88]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#14ba88] focus:bg-black/30 transition"
        required>
        <option value="" disabled selected>Selecione o Gênero</option>
        <option value="MASCULINO">Masculino</option>
        <option value="FEMININO">Feminino</option>
        <option value="UNISSEX">Unissex</option>
      </select>
    </div>

    {{-- Categoria --}}
    <div class="flex flex-col">
      <label for="categoria" class="text-sm text-white/70 mb-1">Categoria</label>
      <input type="text" id="categoria" name="categoria"
        class="px-4 py-3 bg-black/40 text-white placeholder-white/40 border border-[#14ba88]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#14ba88] focus:bg-black/30 transition">
    </div>

    {{-- Fotos do Produto --}}
    <div class="md:col-span-2 flex flex-col">
      <label for="fotos" class="text-sm text-white/70 mb-1">Imagens do Produto</label>
      <input type="file" id="fotos" name="fotos[]" multiple accept="image/*"
        class="w-full bg-black/40 text-white/70 border border-[#14ba88]/40 rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#14ba88] file:text-white hover:file:bg-[#0e9b70] transition">
    </div>

    {{-- Ativo/Inativo --}}
    <div class="flex flex-col">
      <label for="ativo" class="text-sm text-white/70 mb-1">Status</label>
      <select id="ativo" name="ativo"
        class="px-4 py-3 bg-black/40 text-white border border-[#14ba88]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#14ba88] focus:bg-black/30 transition"
        required>
        <option value="1">Ativo</option>
        <option value="0">Inativo</option>
      </select>
    </div>

    {{-- Botão --}}
    <div class="md:col-span-2 mt-4">
      <button type="submit"
        class="w-full py-3 font-semibold bg-[#14ba88] hover:bg-[#0e9b70] rounded-lg shadow transition">
        Cadastrar Produto
      </button>
    </div>
  </form>
</div>
