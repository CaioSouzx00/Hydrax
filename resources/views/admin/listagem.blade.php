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
            background-color: #f5f5f5;
        }
        table th, table td {
            text-align: center;
        }
        .btn-adidas {
            @apply px-3 py-1 rounded font-semibold transition-colors;
        }
        .btn-ativar {
            @apply bg-black text-white hover:bg-gray-800;
        }
        .btn-desativar {
            @apply bg-red-600 text-white hover:bg-red-700;
        }
        .pagination a {
            @apply px-3 py-1 border border-gray-300 rounded mx-1 hover:bg-gray-200;
        }
        .pagination .active {
            @apply bg-black text-white border-black;
        }
    </style>
</head>
<body>
    <div class="container mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-6 text-black">Todos os Produtos</h1>

        @if(session('success'))
            <div class="mb-6 p-3 bg-green-500 text-white rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
            <table class="w-full table-auto">
                <thead class="bg-black text-white">
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
                        <tr class="{{ $produto->ativo ? '' : 'bg-red-100' }} hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3">{{ $produto->id_produtos }}</td>
                            <td class="px-4 py-3 font-medium">{{ $produto->nome }}</td>
                            <td class="px-4 py-3">{{ $produto->fornecedor->nome_empresa ?? 'Sem fornecedor' }}</td>
                            <td class="px-4 py-3">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ $produto->ativo ? 'Sim' : 'Não' }}</td>
                            <td class="px-4 py-3">
                                <form action="{{ route('admin.produtos.toggle', $produto->id_produtos) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-adidas {{ $produto->ativo ? 'btn-desativar' : 'btn-ativar' }}">
                                        {{ $produto->ativo ? 'Desativar' : 'Ativar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-center pagination">
            {{ $produtos->links() }}
        </div>
    </div>
</body>
</html>
