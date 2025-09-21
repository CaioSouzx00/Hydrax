<div class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] border border-[#d5891b]/50 rounded-xl shadow-lg p-8 max-w-5xl mx-auto mb-12 text-white font-poppins">
  <h2 class="text-2xl font-semibold mb-6 text-[#e29b37]">Cadastrar Produto</h2>

  @if(session('success'))
    <div class="bg-green-700/70 text-green-100 p-4 rounded mb-6 text-sm font-medium">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('fornecedores.produtos.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-3">
    @csrf

    <div>
      <label for="nome" class="block text-sm text-[#d5891b] mb-1">Nome do Produto</label>
      <input type="text" id="nome" name="nome" placeholder="Nome do Produto"
        class="w-full px-4 py-3 bg-[#17110d] text-white/70 hover:text-white placeholder-white/40 border border-[#d5891b]/40 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-[#d5891b] focus:bg-[#211828] transition" required />
    </div>

    <div>
    <label for="cor">Cor do produto:</label>
    <input type="text" name="cor" id="cor" class="border p-2 rounded" required>
  e</div>


    <div>
      <label for="descricao" class="block text-sm text-[#d5891b] mb-1">Descrição</label>
      <input type="text" id="descricao" name="descricao" placeholder="Descrição"
        class="w-full px-4 py-3 bg-[#17110d] text-white/70 hover:text-white placeholder-white/40 border border-[#d5891b]/40 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-[#d5891b] focus:bg-[#211828] transition" />
    </div>

    <div>
      <label for="preco" class="block text-sm text-[#d5891b] mb-1">Preço (R$)</label>
      <input type="number" id="preco" name="preco" placeholder="Preço (R$)" step="0.01"
        class="w-full px-4 py-3 bg-[#17110d] text-white/70 hover:text-white placeholder-white/40 border border-[#d5891b]/40 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-[#d5891b] focus:bg-[#211828] transition" required />
    </div>

    <div>
      <label for="caracteristicas" class="block text-sm text-[#d5891b] mb-1">Características</label>
      <input type="text" id="caracteristicas" name="caracteristicas" placeholder="Características"
        class="w-full px-4 py-3 bg-[#17110d] text-white/70 hover:text-white placeholder-white/40 border border-[#d5891b]/40 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-[#d5891b] focus:bg-[#211828] transition" />
    </div>

    <div>
      <label for="historico_modelos" class="block text-sm text-[#d5891b] mb-1">Histórico de Modelos</label>
      <input type="text" id="historico_modelos" name="historico_modelos" placeholder="Histórico de Modelos"
        class="w-full px-4 py-3 bg-[#17110d] text-white/70 hover:text-white placeholder-white/40 border border-[#d5891b]/40 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-[#d5891b] focus:bg-[#211828] transition" />
    </div>

    <div>
      <label for="tamanhos_disponiveis" class="block text-sm text-[#d5891b] mb-1">Tamanhos Disponíveis (ex: 38,39,40)</label>
      <input type="text" id="tamanhos_disponiveis" name="tamanhos_disponiveis" placeholder="Tamanhos Disponíveis (ex: 38,39,40)"
        class="w-full px-4 py-3 bg-[#17110d] text-white/70 hover:text-white placeholder-white/40 border border-[#d5891b]/40 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-[#d5891b] focus:bg-[#211828] transition" />
    </div>

    <div>
      <label for="categoria" class="block text-sm text-[#d5891b] mb-1">Categoria</label>
      <input type="text" id="categoria" name="categoria" placeholder="Categoria"
        class="w-full px-4 py-3 bg-[#17110d] text-white/70 hover:text-white placeholder-white/40 border border-[#d5891b]/40 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-[#d5891b] focus:bg-[#211828] transition" />
    </div>

    <div>
      <label for="genero" class="block text-sm text-[#d5891b] mb-1">Gênero</label>
      <select id="genero" name="genero" required
        class="w-full px-4 py-3 bg-[#17110d] text-white/70 hover:text-white placeholder-white/40 border border-[#d5891b]/40 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-[#d5891b] focus:bg-[#211828] transition">
        <option value="" disabled selected>Selecione o Gênero</option>
        <option value="MASCULINO">Masculino</option>
        <option value="FEMININO">Feminino</option>
        <option value="UNISSEX">Unissex</option>
      </select>
    </div>

    <!-- Linha 1: Ativo e Imagens Estoque lado a lado -->
    <div class="md:col-span-2 grid grid-cols-2 gap-6 items-end">
      <div>
        <label for="ativo" class="block text-sm text-[#d5891b] mb-1">Status</label>
        <select id="ativo" name="ativo" required
          class="w-full px-4 py-3 bg-[#17110d] text-white/70 hover:text-white placeholder-white/40 border border-[#d5891b]/40 rounded-lg
                 focus:outline-none focus:ring-2 focus:ring-[#d5891b] focus:bg-[#211828] transition">
          <option value="1">Ativo</option>
          <option value="0">Inativo</option>
        </select>
      </div>

      <div>
        <label for="estoque_imagem" class="block text-sm text-[#d5891b] mb-1">Imagens do Estoque</label>
        <input type="file" id="estoque_imagem" name="estoque_imagem[]" multiple accept="image/*"
          class="w-full bg-[#17110d] border border-[#d5891b]/50 rounded-lg px-4 py-2 text-white/70
                 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                 file:bg-[#d5891b] file:text-[#17110d] hover:file:bg-[#e29b37] transition"/>
      </div>
    </div>

    <!-- Linha 2: Imagens Produto e Botão lado a lado -->
    <div class="md:col-span-2 grid grid-cols-2 gap-6 items-end mt-4">
      <div>
        <label for="fotos" class="text-sm text-[#d5891b] mb-1 block">Imagens do Produto</label>
        <input type="file" id="fotos" name="fotos[]" multiple accept="image/*"
          class="w-full bg-[#17110d] text-white/70 border border-[#d5891b]/40 rounded-lg px-4 py-2 
                 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold 
                 file:bg-[#d5891b] file:text-[#17110d] hover:file:bg-[#e29b37] transition">
      </div>

      <div>
        <button type="submit"
          class="w-full py-3 font-semibold bg-[#d5891b] hover:bg-[#e29b37] rounded-lg shadow transition text-black/80">
          Cadastrar Produto
        </button>
      </div>
    </div>
  </form>
</div>
