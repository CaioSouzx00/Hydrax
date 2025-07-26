<div class="p-8 max-w-xl mx-auto rounded-2xl relative mt-10 text-white text-center">
  <h2 class="text-2xl font-bold mb-6 border-b-2 border-[#14ba88] pb-2 flex items-center justify-center gap-2 mx-auto max-w-max">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#14ba88]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.656 0 3-1.343 3-3s-1.344-3-3-3-3 1.343-3 3 1.344 3 3 3z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M6.115 17.94a9 9 0 0111.77 0M9.172 14.828a5 5 0 015.656 0" />
    </svg>
    Digite sua senha para continuar
  </h2>

  <p class="mb-6 text-gray-300 text-base max-w-md mx-auto">
    Por segurança, pedimos que você confirme sua senha atual para continuar com as alterações na sua conta.
  </p>

  <form id="form-verificar-senha" class="space-y-6 max-w-md mx-auto">
    @csrf
    <label for="senha_atual" class="flex items-center gap-2 text-base font-semibold justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#14ba88]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.656 0 3-1.343 3-3s-1.344-3-3-3-3 1.343-3 3 1.344 3 3 3z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.115 17.94a9 9 0 0111.77 0M9.172 14.828a5 5 0 015.656 0" />
      </svg>
      Senha atual
    </label>
    <input type="password" id="senha_atual" name="senha_atual"
      class="w-full border border-[#d1a858] bg-[#2a2a2a] text-white p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#14ba88] shadow-md"
      placeholder="Digite sua senha atual" required>

    <button type="submit" 
      class="relative inline-flex items-center justify-center p-4 px-6 py-3 overflow-hidden font-medium bg-[#0d8c6a] text-[#0d8c6a] transition duration-300 ease-out border-2 border-[#0d8c6a] rounded-full shadow-md group w-full max-w-md mx-auto">
      
      <span class="absolute inset-0 flex items-center justify-center w-full h-full  text-[#0d8c6a] duration-300 -translate-x-full bg-white group-hover:translate-x-0 ease">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
        </svg>
      </span>
      
      <span class="absolute flex items-center justify-center w-full h-full text-white transition-all duration-300 transform group-hover:translate-x-full ease">
        Confirmar senha e continuar
      </span>
      
      <span class="relative invisible">Confirmar senha e continuar</span>
    </button>

  </form>

<a href="{{ route('usuarios.senha.verificarCodigo.form') }}" id="link-nao-sei-senha"
  class="inline-block mt-6 text-base text-[#14ba88] hover:text-[#0d8c6a] transition duration-300 underline max-w-md text-left mx-auto">
  Esqueci minha senha
</a>


  <div id="loader"
    class="hidden absolute inset-0 bg-black bg-opacity-70 flex items-center justify-center rounded-2xl z-20 max-w-xl mx-auto">
    <svg class="animate-spin h-10 w-10 text-[#14ba88]" xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor"
        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-verificar-senha');
    const loader = document.getElementById('loader');

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      loader.classList.remove('hidden'); // mostra loader

      const formData = new FormData(this);

      fetch("{{ route('usuarios.senha.verificarCodigo') }}", {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': formData.get('_token')
        },
        body: formData
      })
        .then(res => {
          loader.classList.add('hidden'); // esconde loader
          if (res.status === 401) throw new Error('Senha incorreta.');
          if (!res.ok) throw new Error('Erro ao verificar senha.');
          return res.text();
        })
        .then(html => {
          document.getElementById('conteudo-principal').innerHTML = html;
        })
        .catch(err => {
          loader.classList.add('hidden'); // esconde loader
          alert(err.message);
        });
    });
  });
</script>
