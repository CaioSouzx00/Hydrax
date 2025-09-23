
<body class="min-h-screen text-white">

<div class="relative ">
    
    <!-- Tabela -->
    <div class="mt-0 overflow-x-auto shadow-lg rounded-lg bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] border border-gray-800">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-[#111] text-gray-100 text-center">
                <tr>
                    <th class="px-4 py-4">ID</th>
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">Fornecedor</th>
                    <th class="px-4 py-3">Preço</th>
                    <th class="px-4 py-3">Ativo</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($produtos as $produto)
                    <tr class="{{ $produto->ativo ? 'hover:bg-white/10' : 'bg-red-900/40 hover:bg-red-900/60' }} transition-colors">
                        <td class="px-4 py-4">{{ $produto->id_produtos }}</td>
                        <td class="px-4 py-3 font-medium text-white">{{ $produto->nome }}</td>
                        <td class="px-4 py-3">{{ $produto->fornecedor->nome_empresa ?? 'Sem fornecedor' }}</td>
                        <td class="px-4 py-3">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $produto->ativo ? 'Sim' : 'Não' }}</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.produtos.toggle', $produto->id_produtos) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                    class="px-3 py-1 rounded font-semibold transition-colors 
                                           {{ $produto->ativo 
                                                ? 'bg-red-600 text-white hover:bg-red-700' 
                                                : 'bg-green-600 text-white hover:bg-green-700' }}">
                                    {{ $produto->ativo ? 'Desativar' : 'Ativar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>