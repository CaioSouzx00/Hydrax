<div class="max-w-5xl mx-auto p-8 rounded-xl">
  <h2 class="text-3xl font-bold mb-8 text-white border-b-2 border-[#14ba88] pb-2">Meu Perfil</h2>

  <form action="{{ route('usuario.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <!-- Nome -->
      <div>
        <label class="block text-base font-semibold text-white mb-1">Nome completo</label>
        <input type="text" name="nome_completo" value="{{ old('nome_completo', $usuario->nome_completo) }}"
          class="w-full border border-[#d1a858] rounded-lg px-4 py-2 bg-[#2a2a2a] text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#14ba88]"
          required>
        @error('nome_completo')
          <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Email -->
      <div>
        <label class="block text-base font-semibold text-white mb-1">Email</label>
        <p class="text-white text-sm bg-[#B69F8F]/10 rounded px-4 py-2 border border-gray-700 shadow-sm">
          {{ $usuario->email }}
        </p>
      </div>

      <!-- Telefone -->
      <div>
        <label class="block text-base font-semibold text-white mb-1">Número de telefone</label>
        <p class="text-white text-sm bg-[#B69F8F]/10 rounded px-4 py-2 border border-gray-700 shadow-sm">
          {{ $usuario->telefone }}
        </p>
      </div>

      <!-- Sexo -->
      <div>
        <label class="block text-base font-semibold text-white mb-1">Sexo</label>
        <p class="text-white text-sm bg-[#B69F8F]/10 rounded px-4 py-2 capitalize border border-gray-700 shadow-sm">
          {{ $usuario->sexo }}
        </p>
      </div>

      <!-- CPF -->
      <div>
        <label class="block text-base font-semibold text-white mb-1">CPF</label>
        <p class="text-white text-sm bg-[#B69F8F]/10 rounded px-4 py-2 border border-gray-700 shadow-sm">
          {{ $usuario->cpf }}
        </p>
      </div>

      <!-- Data de nascimento -->
      <div>
        <label class="block text-base font-semibold text-white mb-1">Data de nascimento</label>
        <p class="text-white text-sm bg-[#B69F8F]/10 rounded px-4 py-2 border border-gray-700 shadow-sm">
          {{ \Carbon\Carbon::parse($usuario->data_nascimento)->format('d/m/Y') }}
        </p>
      </div>

    </div>

    <!-- Botão -->
    <div class="pt-4">
      <button type="submit"
        class="relative inline-flex items-center justify-start px-6 py-3 overflow-hidden font-medium transition-all bg-[#0d8c6a] rounded-xl group text-white text-sm shadow-md">
        <span
          class="absolute top-0 right-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-[#0a6f54] rounded group-hover:-mr-4 group-hover:-mt-4">
          <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
        </span>
        <span
          class="absolute bottom-0 left-0 w-full h-full transition-all duration-500 ease-in-out delay-200 -translate-x-full translate-y-full bg-[#0c7e5f] rounded-2xl group-hover:mb-12 group-hover:translate-x-0"></span>
        <span class="relative w-full text-left transition-colors duration-200 ease-in-out group-hover:text-white">
          Gravar Nome
        </span>
      </button>
    </div>
  </form>
</div>
