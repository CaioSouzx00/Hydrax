<div style="height: 500px;" class="flex items-center justify-center px-4">
  <div class="p-8 max-w-md w-full bg-[#1a1a1a] rounded-2xl shadow-lg text-white">
    <h2 class="text-2xl font-bold mb-6 border-b-2 border-[#14ba88] pb-2 text-center">Verifique seu código</h2>

    <form id="form-verificar-codigo" method="POST" action="{{ route('usuarios.senha.verificarCodigo') }}" class="space-y-6">
      @csrf
      <input 
        type="text" 
        name="codigo" 
        placeholder="Código recebido" 
        required
        class="w-full px-4 py-3 rounded-lg bg-[#2a2a2a] border border-[#14ba88] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#14ba88]"
      >

      <button 
        type="submit" 
        class="w-full py-3 bg-[#0d8c6a] hover:bg-[#14ba88] rounded-xl font-semibold transition-colors duration-300 shadow-md"
      >
        Verificar
      </button>
    </form>
  </div>
</div>

<script>
document.getElementById('form-verificar-codigo').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = this;
  const formData = new FormData(form);

  fetch(form.action, {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': formData.get('_token')
    },
    body: formData
  })
  .then(res => {
    if (res.status === 401) throw new Error('Código incorreto.');
    if (!res.ok) throw new Error('Erro ao verificar código.');
    return res.text();
  })
  .then(html => {
    document.getElementById('conteudo-principal').innerHTML = html;
  })
  .catch(err => alert(err.message));
});
</script>
