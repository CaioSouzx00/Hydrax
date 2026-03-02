<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
    <title>Vendas por Fornecedor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] text-white min-h-screen p-6">
<!-- Botão voltar redondo -->
<a href="{{ route('admin.dashboard') }}"
   class="fixed top-4 left-4 z-50 w-10 h-10 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300 shadow-lg"
   title="Voltar">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
</a>
<h1 class="text-2xl font-bold mb-8 mt-10 border-b border-gray-700/80 w-fit text-white">Vendas por Fornecedor (Últimos 6 meses)</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($dadosFornecedores as $fornecedor)
        <div class="bg-[#1a1a1a]/30 rounded-2xl p-6 shadow-lg border border-gray-800 hover:shadow-xl transition">
            <h2 class="font-bold text-xl mb-6 text-white border-b border-gray-700 pb-2">{{ $fornecedor['nome'] }}</h2>

            <!-- Labels dos meses -->
            <div class="flex justify-between text-xs font-semibold mb-2 text-gray-400">
                @foreach($labels as $label)
                    <span>{{ $label }}</span>
                @endforeach
            </div>

            <!-- Gráfico de barras -->
            <div class="flex items-end h-40 gap-2">
                @foreach($fornecedor['valores'] as $valor)
                    @php
                        $max = max($fornecedor['valores']) ?: 1;
                        $altura = ($valor / $max) * 100;
                    @endphp
                    <div class="flex-1 rounded-t-lg bg-gradient-to-t from-blue-800 to-blue-200 shadow-md"
                         style="height: {{ $altura }}%;"></div>
                @endforeach
            </div>

            <!-- Valores -->
            <div class="flex justify-between mt-3 text-sm font-medium text-gray-300">
                @foreach($fornecedor['valores'] as $valor)
                    <span>{{ $valor }}</span>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

</body>
</html>
