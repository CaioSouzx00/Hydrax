<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Mais Vendidos - Últimos 7 dias</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans p-6">

<h1 class="text-3xl font-bold mb-6">Produtos Mais Vendidos (Últimos 7 dias)</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($produtosVendidos as $produto)
        @php
            $max = max($produto->vendasPorDia) ?: 1; // array com 7 dias
        @endphp
        <div class="bg-gray-100 rounded-xl p-4 shadow-lg flex flex-col">
            <h2 class="font-bold text-lg mb-2 text-center">{{ $produto->nome }}</h2>
            
            <div class="flex items-end h-40 gap-2 mt-4">
                @foreach($produto->vendasPorDia as $vendas)
                    <div class="flex-1 relative">
                        <div class="absolute -top-6 w-full text-center font-bold text-gray-900">{{ $vendas }}</div>
                        <div class="bg-gradient-to-t from-green-500 to-green-300 rounded-t-lg w-full" style="height: {{ ($vendas/$max)*100 }}%;"></div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between mt-2 text-xs font-medium text-gray-700">
                @foreach($produto->dias as $dia)
                    <span>{{ $dia }}</span>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

</body>
</html>
