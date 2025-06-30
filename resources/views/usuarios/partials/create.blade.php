<div>
    <h2 class="text-2xl font-bold mb-4">Adicionar Endereço</h2>

    <form action="{{ route('usuarios.enderecos.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Rua</label>
            <input type="text" name="rua" class="border px-3 py-2 rounded w-full" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Número</label>
            <input type="text" name="numero" class="border px-3 py-2 rounded w-full" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Bairro</label>
            <input type="text" name="bairro" class="border px-3 py-2 rounded w-full" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Cidade</label>
            <input type="text" name="cidade" class="border px-3 py-2 rounded w-full" required>
        </div>

        <div>
            <label class="block text-sm font-medium">CEP</label>
            <input type="text" name="cep" class="border px-3 py-2 rounded w-full" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Estado</label>
            <input type="text" name="estado" class="border px-3 py-2 rounded w-full" required>
        </div>

        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
            Salvar Endereço
        </button>
    </form>
</div>
