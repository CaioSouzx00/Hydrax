<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Mais Vendidos - Últimos 7 dias</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f0f0f] font-sans p-6 text-gray-200">

<h1 class="text-3xl font-bold mb-8 text-white">Produtos Mais Vendidos (Últimos 7 dias)</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($produtosVendidos as $produto)
        @php
            $max = max($produto->vendasPorDia) ?: 1; // array com 7 dias
        @endphp
        <div class="bg-[#1a1a1a] rounded-2xl p-6 shadow-lg border border-gray-800 flex flex-col hover:shadow-xl transition">
            <h2 class="font-bold text-xl mb-4 text-center text-white border-b border-gray-700 pb-2">
                {{ $produto->nome }}
            </h2>
            
            <!-- Gráfico de barras -->
            <div class="flex items-end h-44 gap-3 mt-6">
                @foreach($produto->vendasPorDia as $vendas)
                    <div class="flex-1 relative">
                        <!-- Valor em cima da barra -->
                        <div class="absolute -top-6 w-full text-center font-bold text-gray-300">
                            {{ $vendas }}
                        </div>
                        <!-- Barra -->
                        <div class="bg-gradient-to-t from-green-600 to-green-400 rounded-t-lg w-full shadow-md" 
                             style="height: {{ ($vendas/$max)*100 }}%;"></div>
                    </div>
                @endforeach
            </div>

            <!-- Dias da semana -->
            <div class="flex justify-between mt-3 text-xs font-medium text-gray-400">
                @foreach($produto->dias as $dia)
                    <span>{{ $dia }}</span>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
</body>
</html>
