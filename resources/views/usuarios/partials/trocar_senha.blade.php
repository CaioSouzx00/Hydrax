<form id="form-trocar-senha" method="POST" action="{{ route('usuarios.senha.trocar') }}" class="max-w-md mx-auto space-y-6 p-6 rounded-lg bg-[#1a1a1a] text-white">
  @csrf

  <!-- Nova senha -->
  <div class="relative">
    <input
      type="password"
      name="nova_senha"
      id="nova_senha"
      placeholder="Nova senha"
      required
      class="w-full px-4 py-3 rounded-lg bg-[#2a2a2a] border border-[#14ba88] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#14ba88]"
    >
    <button type="button"
      tabindex="-1"
      class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-400 hover:text-[#14ba88] focus:outline-none"
      onclick="toggleSenha('nova_senha', this)"
      aria-label="Mostrar/ocultar senha">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" id="icon-nova_senha">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      </svg>
    </button>
  </div>

  <!-- Confirme a nova senha -->
  <div class="relative">
    <input
      type="password"
      name="nova_senha_confirmation"
      id="nova_senha_confirmation"
      placeholder="Confirme a nova senha"
      required
      class="w-full px-4 py-3 rounded-lg bg-[#2a2a2a] border border-[#14ba88] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#14ba88]"
    >
    <button type="button"
      tabindex="-1"
      class="absolute top-1/2 right-3 -translate-y-1/2 text-gray-400 hover:text-[#14ba88] focus:outline-none"
      onclick="toggleSenha('nova_senha_confirmation', this)"
      aria-label="Mostrar/ocultar senha">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" id="icon-nova_senha_confirmation">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      </svg>
    </button>
  </div>

  <button
    id="btn-salvar-senha"
    type="submit"
    class="w-full py-3 bg-[#0d8c6a] hover:bg-[#14ba88] rounded-xl font-semibold transition-colors duration-300 shadow-md"
  >
    Salvar
  </button>
</form>

<script>
  function toggleSenha(idInput, btn) {
    const input = document.getElementById(idInput);
    const iconId = "icon-" + idInput;
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
      input.type = "text";
      icon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.964 9.964 0 012.223-3.436m3.457-2.59A9.962 9.962 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.968 9.968 0 01-4.727 5.35M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M3 3l18 18" />
      `;
    } else {
      input.type = "password";
      icon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      `;
    }
  }
</script>
