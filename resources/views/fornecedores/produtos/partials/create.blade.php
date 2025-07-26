<div class="bg-[#0b282a]/70 border border-[#14ba88] rounded-xl shadow-lg p-8 max-w-5xl mx-auto text-white font-poppins">
  <h2 class="text-2xl font-semibold mb-6 text-[#14ba88]">Cadastrar Produto</h2>

  @if(session('success'))
    <div class="bg-green-700/70 text-green-100 p-4 rounded mb-6 text-sm font-medium">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('fornecedores.produtos.store') }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf

    <input type="text" name="nome" placeholder="Nome do Produto" class="input-style" required />
    <input type="text" name="descricao" placeholder="Descrição" class="input-style" />
    <input type="number" name="preco" placeholder="Preço (R$)" step="0.01" class="input-style" required />
    <div class="md:col-span-2">
  <label class="block text-sm text-white/70 mb-1">Imagens do Estoque</label>
  <input type="file" name="estoque_imagem[]" multiple accept="image/*"
         class="w-full bg-black/40 border border-[#14ba88]/50 rounded-lg px-4 py-2 text-white/70
                file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                file:bg-[#14ba88] file:text-white hover:file:bg-[#0e9b70] transition"/>
</div>

    <input type="text" name="caracteristicas" placeholder="Características" class="input-style" />
    <input type="text" name="historico_modelos" placeholder="Histórico de Modelos" class="input-style" />
    <input type="text" name="tamanhos_disponiveis" placeholder="Tamanhos Disponíveis (ex: P,M,G)" class="input-style" />

    <select name="genero" class="input-style" required>
      <option value="" disabled selected>Selecione o Gênero</option>
      <option value="MASCULINO">Masculino</option>
      <option value="FEMININO">Feminino</option>
      <option value="UNISSEX">Unissex</option>
    </select>

    <input type="text" name="categoria" placeholder="Categoria" class="input-style" />

    <div class="md:col-span-2">
      <label class="block text-sm text-white/70 mb-1">Imagens do Produto</label>
      <input type="file" name="fotos[]" multiple accept="image/*"
             class="w-full bg-black/40 border border-[#14ba88]/50 rounded-lg px-4 py-2 text-white/70
                    file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                    file:bg-[#14ba88] file:text-white hover:file:bg-[#0e9b70] transition"/>
    </div>

    <select name="ativo" class="input-style" required>
      <option value="1">Ativo</option>
      <option value="0">Inativo</option>
    </select>

    <div class="md:col-span-2 mt-4">
      <button type="submit"
        class="w-full py-3 font-semibold bg-[#14ba88] hover:bg-[#0e9b70] rounded-lg shadow transition">
        ✅ Cadastrar Produto
      </button>
    </div>
  </form>
</div>

<style>
  .input-style {
    @apply w-full px-4 py-3 bg-black/40 text-white placeholder-white/40 border border-[#14ba88]/40 rounded-lg
           focus:outline-none focus:ring-2 focus:ring-[#14ba88] focus:bg-black/30 transition;
  }
</style>