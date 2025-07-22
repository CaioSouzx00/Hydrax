<div class="p-6 max-w-md mx-auto bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Trocar Senha</h2>
    <form id="form-trocar-senha" method="POST" action="{{ route('usuarios.senha.trocar') }}">
        @csrf
        <input type="password" name="nova_senha" class="w-full border p-2 mb-3 rounded" placeholder="Nova senha" required>
        <input type="password" name="nova_senha_confirmation" class="w-full border p-2 mb-4 rounded" placeholder="Confirme a nova senha" required>
        <button id="btn-salvar-senha" type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Salvar</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-trocar-senha');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch("{{ route('usuarios.senha.trocar') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.sucesso) {
                    alert(data.sucesso);
                    document.getElementById('conteudo-principal').innerHTML = '';
                } else {
                    alert('Erro ao trocar senha.');
                }
            })
            .catch((e) => {
                console.error('Erro na requisição:', e);
                alert('Erro ao trocar senha.');
            });
        });
    }
});
</script>
