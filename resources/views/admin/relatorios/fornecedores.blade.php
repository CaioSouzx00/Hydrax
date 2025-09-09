<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas por Fornecedor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f0f0f] font-sans p-6 text-gray-200">

<h1 class="text-3xl font-bold mb-8 text-white">Vendas por Fornecedor (Últimos 6 meses)</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($dadosFornecedores as $fornecedor)
        <div class="bg-[#1a1a1a] rounded-2xl p-6 shadow-lg border border-gray-800 hover:shadow-xl transition">
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
                    <div class="flex-1 rounded-t-lg bg-gradient-to-t from-green-600 to-green-400 shadow-md"
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
