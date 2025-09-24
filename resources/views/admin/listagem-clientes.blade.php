<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
    <title>Listagem de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] border border-gray-800 min-h-screen">

<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

    @if(session('success'))
        <div class="bg-green-600 text-white p-3 rounded mb-6 col-span-full">
            {{ session('success') }}
        </div>
    @endif

    @foreach($usuarios as $usuario)
        <div class="bg-[#1a1a1a] border border-gray-700 rounded-xl shadow p-4 flex flex-col justify-between">
            <h2 class="text-lg font-bold text-white mb-1">{{ $usuario->nome_completo }}</h2>
            <p class="text-gray-400 text-sm mb-1">Email: {{ $usuario->email }}</p>
            <p class="text-gray-400 text-sm mb-1">CPF: {{ $usuario->cpf }}</p>
            <p class="text-sm mb-2">Status: 
                <span class="{{ $usuario->ativo ? 'text-green-400' : 'text-red-400' }}">
                    {{ $usuario->ativo ? 'Ativo' : 'Inativo' }}
                </span>
            </p>

            <div class="flex flex-col gap-2 mt-2">
    <a href="{{ route('admin.cliente.historico', ['id' => $usuario->id_usuarios]) }}"
       class="w-full py-2 bg-blue-600 hover:bg-blue-700 rounded text-white font-semibold text-center">
       Histórico de Compras
    </a>

</div>

        </div>
    @endforeach

</div>

<div class="container mx-auto mt-6">
    {{ $usuarios->links() }}
</div>

</body>
</html>
