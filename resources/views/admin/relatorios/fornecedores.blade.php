<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas por Fornecedor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans p-6">

<h1 class="text-3xl font-bold mb-6">Vendas por Fornecedor (Últimos 6 meses)</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($dadosFornecedores as $fornecedor)
        <div class="bg-gray-100 rounded-xl p-4 shadow-lg">
            <h2 class="font-bold text-lg mb-4">{{ $fornecedor['nome'] }}</h2>
            <div class="flex justify-between text-xs font-semibold mb-2">
                @foreach($labels as $label)
                    <span>{{ $label }}</span>
                @endforeach
            </div>
            <div class="flex items-end h-40 gap-2">
                @foreach($fornecedor['valores'] as $valor)
                    @php
                        $max = max($fornecedor['valores']) ?: 1;
                        $altura = ($valor / $max) * 100;
                    @endphp
                    <div class="flex-1 bg-gradient-to-t from-green-500 to-green-300 rounded-t-lg" 
                         style="height: {{ $altura }}%;"></div>
                @endforeach
            </div>
            <div class="flex justify-between mt-2 text-sm font-medium">
                @foreach($fornecedor['valores'] as $valor)
                    <span>{{ $valor }}</span>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

</body>
</html>
