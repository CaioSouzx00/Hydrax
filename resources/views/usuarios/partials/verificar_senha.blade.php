<div class="p-6 max-w-md mx-auto bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Digite sua senha para continuar</h2>
    <form id="form-verificar-senha">
        @csrf
        <input type="password" name="senha_atual" class="w-full border p-2 mb-4 rounded" placeholder="Senha atual" required>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Confirmar</button>
    </form>
    
    <a href="#" id="link-nao-sei-senha" class="text-sm text-blue-600">Não sei minha senha</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form-verificar-senha').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/verificar', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token')
            },
            body: formData
        })
        .then(res => {
            if (res.status === 401) throw new Error('Senha incorreta.');
            if (!res.ok) throw new Error('Erro ao verificar senha.');
            return res.text();
        })
        .then(html => {
            document.getElementById('conteudo-principal').innerHTML = html;
        })
        .catch(err => alert(err.message));
    });

    document.getElementById('link-nao-sei-senha').addEventListener('click', function(e) {
        e.preventDefault();

        fetch('/usuarios/senha/verificar-codigo', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => {
            if (!res.ok) throw new Error('Erro ao carregar formulário de verificação');
            return res.text();
        })
        .then(html => {
            document.getElementById('conteudo-principal').innerHTML = html;
        })
        .catch(err => alert(err.message));
    });
});
</script>
