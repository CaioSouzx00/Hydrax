<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Fornecedores</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#111] text-white min-h-screen">

<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

    @if(session('success'))
        <div class="bg-green-600 text-white p-3 rounded mb-6 col-span-full">
            {{ session('success') }}
        </div>
    @endif

    @foreach($fornecedores as $fornecedor)
        <div class="bg-[#1a1a1a] border border-gray-700 rounded-xl shadow p-4 flex flex-col justify-between">
            <h2 class="text-lg font-bold mb-1">{{ $fornecedor->nome_empresa }}</h2>
            <p class="text-gray-400 text-sm mb-1">Email: {{ $fornecedor->email }}</p>
            <p class="text-gray-400 text-sm mb-1">Telefone: {{ $fornecedor->telefone }}</p>
            <p class="text-gray-400 text-sm mb-1">CNPJ: {{ $fornecedor->cnpj }}</p>

            <div class="flex flex-col gap-2 mt-2">
                <a href="{{ route('admin.fornecedor.produtos', $fornecedor->id_fornecedores) }}"
                   class="w-full py-2 bg-blue-600 hover:bg-blue-700 rounded text-white font-semibold text-center">
                   Produtos
                </a>
            </div>
        </div>
    @endforeach

</div>

<div class="container mx-auto mt-6">
    {{ $fornecedores->links() }}
</div>

</body>
</html>
