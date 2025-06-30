<form action="{{ route('usuarios.enderecos.update', $endereco) }}" method="POST" class="max-w-md">
    @csrf
    @method('PUT')

    <label for="cidade" class="block font-semibold">Cidade</label>
    <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $endereco->cidade) }}" required class="border p-2 rounded w-full mb-4">

    <label for="cep" class="block font-semibold">CEP</label>
    <input type="text" name="cep" id="cep" value="{{ old('cep', $endereco->cep) }}" required class="border p-2 rounded w-full mb-4">

    <label for="bairro" class="block font-semibold">Bairro</label>
    <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $endereco->bairro) }}" required class="border p-2 rounded w-full mb-4">

    <label for="estado" class="block font-semibold">Estado</label>
    <input type="text" name="estado" id="estado" value="{{ old('estado', $endereco->estado) }}" required class="border p-2 rounded w-full mb-4" maxlength="2">

    <label for="rua" class="block font-semibold">Rua</label>
    <input type="text" name="rua" id="rua" value="{{ old('rua', $endereco->rua) }}" required class="border p-2 rounded w-full mb-4">

    <label for="numero" class="block font-semibold">Número</label>
    <input type="text" name="numero" id="numero" value="{{ old('numero', $endereco->numero) }}" required class="border p-2 rounded w-full mb-4">

    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Salvar Alterações</button>
</form>
