<div class="max-w-3xl mx-auto text-gray-100 px-6 py-10">
  <div class="flex items-center gap-3 mb-6">
    <!-- Ícone de cadeado (Heroicons) -->
    <svg class="w-8 h-8 text-[#D5891B]" xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm6-18a4 4 0 00-4 4v4h8V7a4 4 0 00-4-4z" />
    </svg>
    <h2 class="text-4xl font-bold text-white">Configurações de Privacidade</h2>
  </div>

  <p class="text-gray-300 text-base mb-8 leading-relaxed">
    Nesta seção, você pode gerenciar as configurações de privacidade da sua conta. Caso deseje, é possível solicitar a exclusão definitiva de todos os seus dados, conforme previsto na legislação vigente. O processo é irreversível e leva até 3 dias úteis para ser concluído.
  </p>

  <!-- Alerta de sucesso -->
  <div id="alerta-exclusao"
    class="hidden bg-green-600 border border-green-700 text-green-100 rounded-lg px-6 py-4 text-base font-medium mb-6"></div>

 <!-- Bloco de exclusão -->
<div class="bg-[#2c0f0f]/50 border border-red-700/50 rounded-xl p-8 shadow-lg">
  <h3 class="text-2xl font-semibold text-red-200 mb-4">❌ Solicitar exclusão da conta</h3>
  <p class="text-base text-red-100 leading-relaxed mb-6">
    Ao confirmar a exclusão, sua conta será marcada para remoção imediata. Todos os seus dados serão permanentemente apagados após 72 horas. Essa ação é <span class="font-semibold text-red-300">irreversível</span> e você não poderá recuperar nenhuma informação associada ao seu perfil.
  </p>

  <form id="form-solicitar-exclusao" action="/excluir-conta" method="POST" class="space-y-6">
    @csrf
    <button type="submit"
      class="relative w-full px-6 py-3 overflow-hidden font-semibold text-red-100 bg-red-800 border border-red-800 rounded-lg shadow-inner group">
      <span
        class="absolute top-0 left-0 w-0 h-0 transition-all duration-200 border-t-2 border-red-300 group-hover:w-full ease"></span>
      <span
        class="absolute bottom-0 right-0 w-0 h-0 transition-all duration-200 border-b-2 border-red-300 group-hover:w-full ease"></span>
      <span
        class="absolute top-0 left-0 w-full h-0 transition-all duration-300 delay-200 bg-red-600 group-hover:h-full ease"></span>
      <span
        class="absolute bottom-0 left-0 w-full h-0 transition-all duration-300 delay-200 bg-red-600 group-hover:h-full ease"></span>
      <span
        class="absolute inset-0 w-full h-full duration-300 delay-300 bg-red-300 opacity-0 group-hover:opacity-100"></span>
      <span class="relative transition-colors duration-300 delay-200 group-hover:text-white ease">
        Confirmar exclusão definitiva da conta
      </span>
    </button>
  </form>
</div>

</div>

<script>
  document.getElementById('form-solicitar-exclusao').addEventListener('submit', function (e) {
    e.preventDefault();

    fetch(this.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': this.querySelector('[name=_token]').value,
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      },
      body: new FormData(this)
    })
      .then(res => {
        if (!res.ok) throw new Error('Falha na solicitação');
        return res.json();
      })
      .then(data => {
        const alerta = document.getElementById('alerta-exclusao');
        alerta.classList.remove('hidden');
        alerta.textContent = data.mensagem;
      })
      .catch(() => alert('Erro ao solicitar exclusão.'));
  });
</script>