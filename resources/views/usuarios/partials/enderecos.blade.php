<h2 class="text-xl font-bold mb-4">Seus Endereços Cadastrados</h2>

@if($enderecos->isEmpty())
    <p class="text-gray-600">Você ainda não cadastrou nenhum endereço.</p>
@else
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2 text-left">Cidade</th>
                <th class="border px-4 py-2 text-left">CEP</th>
                <th class="border px-4 py-2 text-left">Bairro</th>
                <th class="border px-4 py-2 text-left">Estado</th>
                <th class="border px-4 py-2 text-left">Rua</th>
                <th class="border px-4 py-2 text-left">Número</th>
                <th class="border px-4 py-2 text-left">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enderecos as $endereco)
            <tr>
                <td class="border px-4 py-2">{{ $endereco->cidade }}</td>
                <td class="border px-4 py-2">{{ $endereco->cep }}</td>
                <td class="border px-4 py-2">{{ $endereco->bairro }}</td>
                <td class="border px-4 py-2">{{ $endereco->estado }}</td>
                <td class="border px-4 py-2">{{ $endereco->rua }}</td>
                <td class="border px-4 py-2">{{ $endereco->numero }}</td>
                <td class="border px-4 py-2 flex gap-2">
                    <a href="#" class="editar-endereco text-orange-600 hover:text-orange-800" data-id="{{ $endereco->id_endereco }}">
                        ✏️ Editar
                    </a>
                    <form method="POST" action="{{ route('usuarios.enderecos.destroy', $endereco->id_endereco) }}" onsubmit="return confirm('Confirma exclusão deste endereço?')" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:text-red-800">🗑️ Excluir</button>
</form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
