<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
    <title>Produtos Mais Vendidos - Últimos 7 dias</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] text-white min-h-screen p-6 relative">

<!-- Botão voltar redondo -->
<a href="{{ route('admin.dashboard') }}"
   class="fixed top-4 left-4 z-50 w-10 h-10 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300 shadow-lg"
   title="Voltar">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
</a>

<h1 class="text-2xl font-bold mb-8 mt-10 border-b border-gray-700/80 w-fit text-white">Produtos Mais Vendidos (Últimos 7 dias)</h1>

@if($produtosVendidos->count() > 0)
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach($produtosVendidos as $produto)
        @php
            $max = max($produto->vendasPorDia) ?: 1;
        @endphp
        <div class="bg-[#1a1a1a]/50 border border-gray-700 rounded-xl p-5 shadow flex flex-col hover:shadow-gray-500/20 transition">
            
            <h2 class="text-white font-semibold text-lg mb-4 text-center border-b border-gray-700 pb-2">
                {{ $produto->nome }}
            </h2>
            
            <!-- Gráfico de barras monocromático -->
            <div class="flex items-end h-40 gap-2 mt-4">
                @foreach($produto->vendasPorDia as $vendas)
                    <div class="flex-1 relative">
                        <!-- Valor em cima da barra (opcional, cinza) -->
                        <div class="absolute -top-6 w-full text-center font-bold text-gray-300">
                            {{ $vendas }}
                        </div>
                        <!-- Barra -->
                        <div class="bg-gray-500 rounded-t-md w-full shadow-sm" 
                             style="height: {{ ($vendas/$max)*100 }}%;"></div>
                    </div>
                @endforeach
            </div>

            <!-- Dias da semana -->
            <div class="flex justify-between mt-3 text-xs font-medium">
                @foreach($produto->dias as $index => $dia)
                    @php
                        $vendasDia = $produto->vendasPorDia[$index];
                        $corDia = $vendasDia > 0 ? 'text-blue-400' : 'text-gray-400';
                    @endphp
                    <span class="{{ $corDia }}">{{ $dia }}</span>
                @endforeach
            </div>

        </div>
    @endforeach
</div>
@else
<div class="flex flex-col items-center justify-center py-20">
    <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gray-800/50 border border-gray-700 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z" />
        </svg>
    </div>
    <h2 class="text-xl font-bold text-white">Nenhum produto vendido nos últimos 7 dias</h2>
    <p class="text-gray-400 mt-2">Produtos adicionados aparecerão aqui quando houver vendas.</p>
</div>
@endif

</body>
</html>
