<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Produtos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#0f0f0f] text-gray-200">
    <div class="container mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-6 text-white">Todos os Produtos</h1>

        @if(session('success'))
            <div class="mb-6 p-3 bg-green-600 text-white rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto shadow-lg rounded-lg bg-[#1a1a1a] border border-gray-800">
            <table class="w-full table-auto">
                <thead class="bg-[#111] text-gray-100">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Nome</th>
                        <th class="px-4 py-3">Fornecedor</th>
                        <th class="px-4 py-3">Preço</th>
                        <th class="px-4 py-3">Ativo</th>
                        <th class="px-4 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produtos as $produto)
                        <tr class="{{ $produto->ativo ? 'hover:bg-[#222]' : 'bg-red-900/40 hover:bg-red-900/60' }} transition-colors">
                            <td class="px-4 py-3">{{ $produto->id_produtos }}</td>
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

        <div class="mt-6 flex justify-center space-x-2">
            {{ $produtos->links() }}
        </div>
    </div>
</body>
</html>
