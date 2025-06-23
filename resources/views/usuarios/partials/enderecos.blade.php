<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Endereços</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow space-y-6">

        {{-- MENSAGENS --}}
        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- TABELA DE ENDEREÇOS --}}
        @if($enderecos->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Cidade</th>
                            <th class="px-4 py-2">CEP</th>
                            <th class="px-4 py-2">Bairro</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Rua</th>
                            <th class="px-4 py-2">Número</th>
                            <th class="px-4 py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enderecos as $endereco)
                            {{-- Linha principal --}}
                            <tr class="text-center endereco-row-{{ $endereco->id_endereco }}">
                                <td class="px-2 py-1">{{ $endereco->cidade }}</td>
                                <td class="px-2 py-1">{{ $endereco->cep }}</td>
                                <td class="px-2 py-1">{{ $endereco->bairro }}</td>
                                <td class="px-2 py-1">{{ $endereco->estado }}</td>
                                <td class="px-2 py-1">{{ $endereco->rua }}</td>
                                <td class="px-2 py-1">{{ $endereco->numero }}</td>
                                <td class="px-2 py-1 flex gap-2 justify-center">
                                    <button onclick="toggleEdit({{ $endereco->id_endereco }})"
                                            class="bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-700 text-sm">
                                        Editar
                                    </button>

                                    <form method="POST"
                                          action="{{ route('endereco.destroy', [$usuario->id_usuarios, $endereco->id_endereco]) }}"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este endereço?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Linha com formulário de edição --}}
                            <tr id="edit-form-{{ $endereco->id_endereco }}" class="hidden bg-gray-50">
                                <td colspan="7">
                                    <form method="POST" action="{{ route('endereco.update', [$usuario->id_usuarios, $endereco->id_endereco]) }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                                        @csrf
                                        @method('PUT')

                                        <input type="text" name="cidade" value="{{ old('cidade', $endereco->cidade) }}" placeholder="Cidade" required class="border p-2 rounded">
                                        <input type="text" name="cep" value="{{ old('cep', $endereco->cep) }}" placeholder="CEP" required class="border p-2 rounded">
                                        <input type="text" name="bairro" value="{{ old('bairro', $endereco->bairro) }}" placeholder="Bairro" required class="border p-2 rounded">
                                        <input type="text" name="estado" value="{{ old('estado', $endereco->estado) }}" placeholder="Estado" maxlength="2" required class="border p-2 rounded">
                                        <input type="text" name="rua" value="{{ old('rua', $endereco->rua) }}" placeholder="Rua" required class="border p-2 rounded">
                                        <input type="text" name="numero" value="{{ old('numero', $endereco->numero) }}" placeholder="Número" required class="border p-2 rounded">

                                        <div class="md:col-span-3 flex justify-end gap-2">
                                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
                                            <button type="button" onclick="toggleEdit({{ $endereco->id_endereco }})"
                                                    class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancelar</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">Você ainda não possui nenhum endereço cadastrado.</p>
        @endif

        {{-- FORMULÁRIO PARA NOVO ENDEREÇO --}}
        @if($enderecos->count() < 3)
            <form method="POST" action="{{ route('endereco.store', $usuario->id_usuarios) }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="cidade" placeholder="Cidade" required class="border p-2 rounded" value="{{ old('cidade') }}">
                <input type="text" name="cep" placeholder="CEP" required class="border p-2 rounded" value="{{ old('cep') }}">
                <input type="text" name="bairro" placeholder="Bairro" required class="border p-2 rounded" value="{{ old('bairro') }}">
                <input type="text" name="estado" placeholder="Estado (UF)" maxlength="2" required class="border p-2 rounded" value="{{ old('estado') }}">
                <input type="text" name="rua" placeholder="Rua" required class="border p-2 rounded" value="{{ old('rua') }}">
                <input type="text" name="numero" placeholder="Número" required class="border p-2 rounded" value="{{ old('numero') }}">

                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Cadastrar Endereço</button>
                </div>
            </form>
        @endif

    </div>

    <script>
        function toggleEdit(id) {
            const form = document.getElementById('edit-form-' + id);
            const row = document.querySelector('.endereco-row-' + id);
            if (form && row) {
                const isHidden = form.classList.contains('hidden');
                if (isHidden) {
                    form.classList.remove('hidden');
                    row.style.display = 'none';
                } else {
                    form.classList.add('hidden');
                    row.style.display = '';
                }
            }
        }
    </script>

</body>
</html>
