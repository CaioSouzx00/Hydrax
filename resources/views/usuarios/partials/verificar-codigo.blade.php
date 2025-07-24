<div class="p-6 max-w-md mx-auto bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Verifique seu código</h2>
    <form id="form-verificar-codigo" method="POST" action="{{ route('usuarios.senha.verificarCodigo') }}">
        @csrf
        <input type="text" name="codigo" class="w-full border p-2 mb-4 rounded" placeholder="Código recebido" required>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Verificar</button>
    </form>
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
        // Substitui o conteúdo principal pelo retorno (provavelmente o form de trocar senha)
        document.getElementById('conteudo-principal').innerHTML = html;
    })
    .catch(err => alert(err.message));
});
</script>
