<div class="max-w-xl mx-auto mt-12 rounded-xl p-8 flex flex-col items-center">
  <h2 class="text-3xl font-semibold text-white mb-4 flex items-center gap-3">
    <!-- Ícone de email maior -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#d1a858]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18a2 2 0 002-2V8a2 2 0 00-2-2H3a2 2 0 00-2 2v6a2 2 0 002 2z" />
    </svg>
    Trocar E-mail
  </h2>

<div class="w-full max-w-md border-b-2 border-[#d1a858] mb-6"></div>

  <p class="text-center text-gray-300 mb-8 px-4 text-lg">
    Atualize seu e-mail para garantir que suas notificações e comunicações sejam enviadas corretamente.
  </p>

  <form action="{{ route('usuarios.email.update') }}" method="POST" novalidate class="w-full max-w-md">
    @csrf

    <!-- E-mail atual -->
    <div class="mb-6">
      <label for="email_atual" class="block text-sm font-medium text-gray-300 mb-2 text-center">E-mail atual</label>
      <input type="text" id="email_atual" value="{{ $usuario->email }}" readonly
             class="w-full px-4 py-3 border border-[#d1a858] rounded-lg bg-[#2a2a2a] text-white cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-[#14ba88] shadow-md" />
    </div>

    <!-- Novo e-mail -->
    <div class="mb-8">
      <label for="novo_email" class="block text-sm font-medium text-gray-300 mb-2 text-center">Novo e-mail</label>
      <input type="email" name="novo_email" id="novo_email" required
             class="w-full px-4 py-3 border border-[#d1a858] rounded-lg bg-[#2a2a2a] text-white focus:outline-none focus:ring-2 focus:ring-[#14ba88] shadow-md" 
             placeholder="seu-novo-email@exemplo.com" />
      @error('novo_email')
        <p class="text-red-500 text-sm mt-1 font-medium text-center">{{ $message }}</p>
      @enderror
    </div>

<!-- Botão -->
<div class="w-full max-w-md mx-auto">
  <button type="submit" 
    class="relative inline-flex items-center justify-center p-4 px-6 py-3 overflow-hidden font-medium bg-[#0d8c6a] text-[#0d8c6a] transition duration-300 ease-out border-2 border-[#0d8c6a] rounded-full shadow-md group w-full">
    
    <span class="absolute inset-0 flex items-center justify-center w-full h-full text-[#0d8c6a] duration-300 -translate-x-full bg-white group-hover:translate-x-0 ease">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
      </svg>
    </span>
    
    <span class="absolute flex items-center justify-center w-full h-full text-white transition-all duration-300 transform group-hover:translate-x-full ease">
      Salvar e mandar para email solicitado
    </span>
    
    <span class="relative invisible">Salvar e mandar para email solicitado</span>
  </button>
</div>

  </form>
</div>
