<div class="max-w-xl mx-auto text-gray-800">
    <h2 class="text-2xl font-bold mb-4">Configurações de Privacidade</h2>
    <p class="mb-6 text-gray-600">Nesta seção você pode solicitar a exclusão definitiva da sua conta e dados pessoais.</p>

    <div id="alerta-exclusao" class="hidden bg-green-100 border border-green-300 text-green-800 rounded-lg px-4 py-2 mb-4"></div>

    <div class="bg-red-50 border border-red-300 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-red-700 mb-2">❌ Solicitar exclusão da conta</h3>
        <p class="text-sm text-red-600 mb-4">Ao confirmar, sua conta será marcada para exclusão e será automaticamente apagada em 3 dias.</p>

        <form id="form-solicitar-exclusao" action="/excluir-conta" method="POST" class="space-y-4">
            @csrf
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded font-semibold transition">
                Confirmar exclusão da conta
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
            alert(data.mensagem);
            // Aqui você pode dar um reload parcial, ou chamar um callback
        })
        .catch(() => alert('Erro ao solicitar exclusão.'));
    });
</script>
