<div class="p-6 max-w-md mx-auto bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Verifique seu código</h2>
    <form method="POST" action="{{ route('usuarios.senha.verificarCodigo') }}">
        @csrf
        <input type="text" name="codigo" class="w-full border p-2 mb-4 rounded" placeholder="Código recebido" required>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Verificar</button>
    </form>
</div>
