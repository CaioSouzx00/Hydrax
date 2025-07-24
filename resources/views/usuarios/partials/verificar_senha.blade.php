<div class="p-6 max-w-md mx-auto bg-white rounded shadow relative">
    <h2 class="text-xl font-bold mb-4">Digite sua senha para continuar</h2>
    <form id="form-verificar-senha">
        @csrf
        <input type="password" name="senha_atual" class="w-full border p-2 mb-4 rounded" placeholder="Senha atual" required>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Confirmar</button>
    </form>
    
    <a href="{{ route('usuarios.senha.verificarCodigo.form') }}" id="link-nao-sei-senha" class="text-sm text-blue-600">
        Não sei minha senha
    </a>

    <!-- Loader escondido inicialmente -->
    <div id="loader" class="hidden absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center rounded">
        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-verificar-senha');
    const loader = document.getElementById('loader');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        loader.classList.remove('hidden');  // mostra loader

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
