<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
    <title>Listagem de Fornecedores</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] border border-gray-800 text-white min-h-screen">
    <!-- Botão voltar -->
    <a href="{{ route('admin.dashboard') }}"
       class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300"
       title="Voltar para o painel">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
    </a>
<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

    @if(session('success'))
        <div class="bg-green-600 text-white p-3 rounded mb-6 col-span-full">
            {{ session('success') }}
        </div>
    @endif

    @foreach($fornecedores as $fornecedor)
        <div class="bg-[#1a1a1a]/50 border border-gray-700 rounded-xl shadow mt-12 p-4 flex flex-col justify-between">
            <h2 class="text-lg font-bold mb-1">{{ $fornecedor->nome_empresa }}</h2>
            <p class="text-gray-400 text-sm mb-1">Email: {{ $fornecedor->email }}</p>
            <p class="text-gray-400 text-sm mb-1">Telefone: {{ $fornecedor->telefone }}</p>
            <p class="text-gray-400 text-sm mb-1">CNPJ: {{ $fornecedor->cnpj }}</p>

            <div class="flex flex-col gap-2 mt-2">
                <a href="{{ route('admin.fornecedor.produtos', $fornecedor->id_fornecedores) }}"
                   class="w-full py-2 rounded-lg bg-gray-700 text-white hover:bg-gray-600 transition-colors duration-30 font-semibold text-center">
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
