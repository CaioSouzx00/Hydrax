<form id="form-trocar-senha" method="POST" action="{{ route('usuarios.senha.trocar') }}" 
  class="max-w-md mx-auto space-y-6 p-8 rounded-lg text-white pt-24">

  <h1 class="text-3xl font-bold mb-2 border-b-2 border-[#d1a858] pb-2 flex items-center justify-center gap-3">
    <!-- Ícone cadeado -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#d1a858]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c.828 0 1.5.672 1.5 1.5v1.5h-3v-1.5c0-.828.672-1.5 1.5-1.5z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M5 11V7a7 7 0 0114 0v4" />
      <rect width="14" height="9" x="5" y="11" rx="2" ry="2" />
    </svg>
    Troca de senha
  </h1>

  <h2 class="text-center text-lg text-gray-300 mb-8 px-4">
    Por favor, escolha uma nova senha segura para proteger sua conta.
  </h2>

  @csrf

  <!-- Nova senha -->
  <div class="flex items-center space-x-3 relative">
    <img src="/imagens/Post Jif 2025/5.png" alt="Ícone de senha" class="w-5 h-5">
    <input
      type="password"
      name="nova_senha"
      id="nova_senha"
      placeholder="Nova senha"
      required
      class="h-11 px-4 pr-10 rounded-lg border border-[#D5891B] bg-[#2a2a2a] text-white placeholder-gray-400 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#14ba88]"
    >
  </div>

  <!-- Confirme a nova senha -->
  <div class="flex items-center space-x-3 relative">
    <img src="/imagens/Post Jif 2025/5.png" alt="Ícone de senha" class="w-5 h-5">
    <input
      type="password"
      name="nova_senha_confirmation"
      id="nova_senha_confirmation"
      placeholder="Confirme a nova senha"
      required
      class="h-11 px-4 pr-10 rounded-lg border border-[#D5891B] bg-[#2a2a2a] text-white placeholder-gray-400 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#14ba88]"
    >
  </div>

  <div class="flex justify-end"> <!-- container para alinhar o botão à direita -->
    <button
      id="btn-salvar-senha"
      type="submit"
      class="box-border relative z-30 inline-flex items-center justify-center w-auto px-8 py-3 overflow-hidden font-bold text-white transition-all duration-300 bg-[#0d8c6a] rounded-md cursor-pointer group ring-offset-2 ring-1 ring-[#14ba88] ring-offset-[#1a422f] hover:ring-offset-[#2a6e4a] ease focus:outline-none"
    >
      <span class="absolute bottom-0 right-0 w-8 h-20 -mb-8 -mr-5 transition-all duration-300 ease-out transform rotate-45 translate-x-1 bg-white opacity-10 group-hover:translate-x-0"></span>
      <span class="absolute top-0 left-0 w-20 h-8 -mt-1 -ml-12 transition-all duration-300 ease-out transform -rotate-45 -translate-x-1 bg-white opacity-10 group-hover:translate-x-0"></span>
      <span class="relative z-20 flex items-center text-sm">
        Salvar
      </span>
    </button>
  </div>

</form>

<script>
  function toggleNovaSenha() {
    const input = document.getElementById("nova_senha");
    const icon = document.getElementById("icon-nova_senha");
    if (input.type === "password") {
      input.type = "text";
      icon.src = "/imagens/Post Jif 2025 (2).png";
      icon.alt = "Ocultar senha";
    } else {
      input.type = "password";
      icon.src = "/imagens/Post Jif 2025.png";
      icon.alt = "Mostrar senha";
    }
  }

  function toggleNovaSenhaConfirmation() {
    const input = document.getElementById("nova_senha_confirmation");
    const icon = document.getElementById("icon-nova_senha_confirmation");
    if (input.type === "password") {
      input.type = "text";
      icon.src = "/imagens/Post Jif 2025 (2).png";
      icon.alt = "Ocultar senha";
    } else {
      input.type = "password";
      icon.src = "/imagens/Post Jif 2025.png";
      icon.alt = "Mostrar senha";
    }
  }
</script>
