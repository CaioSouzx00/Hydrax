<form action="{{ route('usuarios.enderecos.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium">Rua</label>
        <input type="text" name="rua" class="border px-3 py-2 rounded w-full" maxlength="60" required placeholder="Ex: Avenida Paulista">
    </div>

    <div>
        <label class="block text-sm font-medium">Número</label>
        <input type="text" name="numero" class="border px-3 py-2 rounded w-full" maxlength="10" required placeholder="Ex: 123">
    </div>

    <div>
        <label class="block text-sm font-medium">Bairro</label>
        <input type="text" name="bairro" class="border px-3 py-2 rounded w-full" maxlength="60" required placeholder="Ex: Bela Vista">
    </div>

    <div>
        <label class="block text-sm font-medium">Cidade</label>
        <input type="text" name="cidade" class="border px-3 py-2 rounded w-full" maxlength="60" required placeholder="Ex: São Paulo">
    </div>

    <div>
        <label class="block text-sm font-medium">CEP</label>
        <input type="text" name="cep" class="border px-3 py-2 rounded w-full" maxlength="10" required placeholder="Ex: 12345-678">
    </div>

    <div>
        <label class="block text-sm font-medium">Estado</label>
        <input type="text" name="estado" class="border px-3 py-2 rounded w-full" maxlength="2" required placeholder="Ex: SP">
    </div>

    <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
        Salvar Endereço
    </button>
</form>
