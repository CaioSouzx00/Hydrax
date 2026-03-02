<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
    <title>Listagem de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] border border-gray-800 min-h-screen">

    <!-- Botão voltar -->
    <a href="{{ route('admin.dashboard') }}"
       class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300"
       title="Voltar para o painel">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
    </a>

    <div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">

        @if(session('success'))
            <div class="bg-green-600/60 border border-green-500 text-white p-3 rounded-lg col-span-full">
                {{ session('success') }}
            </div>
        @endif

        @foreach($usuarios as $usuario)
            <div class="bg-[#1a1a1a]/50 border border-gray-700 rounded-xl p-5 flex flex-col justify-between
                        hover:border-gray-500 transition-colors duration-300">
                
                <!-- Nome -->
                <h2 class="text-lg font-bold text-white mb-2 border-b border-gray-700 pb-1">
                    {{ $usuario->nome_completo }}
                </h2>

                <!-- Infos -->
                <p class="text-gray-400 text-sm mb-1"><span class="font-semibold text-gray-300">Email:</span> {{ $usuario->email }}</p>
                <p class="text-gray-400 text-sm mb-1"><span class="font-semibold text-gray-300">CPF:</span> {{ $usuario->cpf }}</p>

                <!-- Botão -->
                <div class="flex flex-col gap-2 mt-3">
                    <a href="{{ route('admin.cliente.historico', ['id' => $usuario->id_usuarios]) }}"
                       class="w-full py-2 rounded-lg font-semibold text-center
                              bg-gray-700 text-white
                              hover:bg-gray-600 transition-colors duration-300">
                       Histórico de Compras
                    </a>
                </div>
            </div>
        @endforeach

    </div>

    <!-- Paginação -->
    <div class="container mx-auto mt-8">
        {{ $usuarios->links() }}
    </div>

</body>
</html>
