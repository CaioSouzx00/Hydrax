<div class="rounded-xl p-6 max-w-3xl mx-auto mt-8">
  <h2 class="text-2xl font-bold mb-6 text-white border-b-2 border-[#14ba88] pb-2">Editar Endereço</h2>

  <form action="{{ route('usuarios.enderecos.update', $endereco) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf
    @method('PUT')

    <!-- Cidade -->
    <div>
      <label for="cidade" class="block text-sm font-semibold text-white mb-1">Cidade</label>
      <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $endereco->cidade) }}" required
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:ring-2 focus:ring-[#14ba88] focus:outline-none">
    </div>

    <!-- CEP -->
    <div>
      <label for="cep" class="block text-sm font-semibold text-white mb-1">CEP</label>
      <input type="text" name="cep" id="cep" value="{{ old('cep', $endereco->cep) }}" required
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:ring-2 focus:ring-[#14ba88] focus:outline-none">
    </div>

    <!-- Bairro -->
    <div>
      <label for="bairro" class="block text-sm font-semibold text-white mb-1">Bairro</label>
      <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $endereco->bairro) }}" required
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:ring-2 focus:ring-[#14ba88] focus:outline-none">
    </div>

    <!-- Estado -->
    <div>
      <label for="estado" class="block text-sm font-semibold text-white mb-1">Estado</label>
      <input type="text" name="estado" id="estado" value="{{ old('estado', $endereco->estado) }}" required maxlength="2"
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:ring-2 focus:ring-[#14ba88] focus:outline-none">
    </div>

    <!-- Rua -->
    <div>
      <label for="rua" class="block text-sm font-semibold text-white mb-1">Rua</label>
      <input type="text" name="rua" id="rua" value="{{ old('rua', $endereco->rua) }}" required
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:ring-2 focus:ring-[#14ba88] focus:outline-none">
    </div>

    <!-- Número -->
    <div>
      <label for="numero" class="block text-sm font-semibold text-white mb-1">Número</label>
      <input type="text" name="numero" id="numero" value="{{ old('numero', $endereco->numero) }}" required
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:ring-2 focus:ring-[#14ba88] focus:outline-none">
    </div>

    <!-- Botão -->
    <div class="col-span-1 md:col-span-2 flex justify-end pt-2">
      <button type="submit"
        class="relative inline-flex items-center justify-start px-6 py-3 overflow-hidden font-medium transition-all bg-[#D5891B] rounded-xl group text-white text-sm shadow-md hover:bg-[#D5891B]">
        <span class="absolute top-0 right-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-[#945025] rounded group-hover:-mr-4 group-hover:-mt-4">
          <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
        </span>
        <span class="absolute bottom-0 left-0 w-full h-full transition-all duration-500 ease-in-out delay-200 -translate-x-full translate-y-full bg-[#945025] rounded-2xl group-hover:mb-12 group-hover:translate-x-0"></span>
        <span class="relative w-full text-left transition-colors duration-200 ease-in-out group-hover:text-white">
          Salvar Alterações
        </span>
      </button>
    </div>
  </form>
</div>
