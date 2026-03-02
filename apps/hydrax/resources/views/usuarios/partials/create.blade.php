<div class="rounded-xl p-6 mt-8">
  <h2 class="text-2xl font-bold mb-6 text-white border-b-2 border-[#14ba88] pb-2">Cadastrar Novo Endereço</h2>

  <form action="{{ route('usuarios.enderecos.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf

    <!-- Rua -->
    <div class="col-span-1">
      <label class="block text-sm font-semibold text-white mb-1">Rua</label>
      <input type="text" name="rua" maxlength="60" required placeholder="Ex: Avenida Paulista"
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#14ba88]">
    </div>

    <!-- Número -->
    <div class="col-span-1">
      <label class="block text-sm font-semibold text-white mb-1">Número</label>
      <input type="text" name="numero" maxlength="10" required placeholder="Ex: 123"
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#14ba88]">
    </div>

    <!-- Bairro -->
    <div class="col-span-1">
      <label class="block text-sm font-semibold text-white mb-1">Bairro</label>
      <input type="text" name="bairro" maxlength="60" required placeholder="Ex: Bela Vista"
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#14ba88]">
    </div>

    <!-- Cidade -->
    <div class="col-span-1">
      <label class="block text-sm font-semibold text-white mb-1">Cidade</label>
      <input type="text" name="cidade" maxlength="60" required placeholder="Ex: São Paulo"
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#14ba88]">
    </div>

    <!-- CEP -->
    <div class="col-span-1">
      <label class="block text-sm font-semibold text-white mb-1">CEP</label>
      <input type="text" name="cep" maxlength="10" required placeholder="Ex: 12345-678"
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#14ba88]">
    </div>

    <!-- Estado -->
    <div class="col-span-1">
      <label class="block text-sm font-semibold text-white mb-1">Estado</label>
      <input type="text" name="estado" maxlength="2" required placeholder="Ex: SP"
        class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#14ba88]">
    </div>

    <!-- Botão -->
    <div class="col-span-1 md:col-span-2 flex justify-end pt-2">
      <button type="submit"
        class="relative inline-flex items-center justify-start px-6 py-3 overflow-hidden font-medium transition-all bg-[#0d8c6a] rounded-xl group text-white text-sm shadow-md">
        <span class="absolute top-0 right-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-[#0a6f54] rounded group-hover:-mr-4 group-hover:-mt-4">
          <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
        </span>
        <span class="absolute bottom-0 left-0 w-full h-full transition-all duration-500 ease-in-out delay-200 -translate-x-full translate-y-full bg-[#0c7e5f] rounded-2xl group-hover:mb-12 group-hover:translate-x-0"></span>
        <span class="relative w-full text-left transition-colors duration-200 ease-in-out group-hover:text-white">
          Salvar Endereço
        </span>
      </button>
    </div>
  </form>
</div>
