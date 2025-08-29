@php
    $fotos = json_decode($produto->fotos ?? '[]', true);
    $estoqueImagens = json_decode($produto->estoque_imagem ?? '[]', true);
    $tamanhos = json_decode($produto->tamanhos_disponiveis ?? '[]', true);
@endphp

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produto->nome }} - Detalhes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

<div class="max-w-7xl mx-auto p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Galeria de Imagens -->
        <!-- Imagem principal -->
        <img src="{{ asset('storage/' . ($fotos[0] ?? 'sem-imagem.png')) }}"
             class="w-full h-[400px] object-cover rounded-lg border shadow main-image">

        <!-- Miniaturas -->
        @if(count($fotos) > 1)
        <div class="flex gap-3 mt-3">
            @foreach(array_slice($fotos, 1) as $foto)
                <img src="{{ asset('storage/' . $foto) }}"
                     class="w-20 h-20 rounded-md border cursor-pointer hover:opacity-80"
                     onclick="document.querySelector('.main-image').src=this.src">
            @endforeach
        </div>
        @endif

        <!-- Informações do Produto -->
        <div class="flex flex-col gap-4">
            <h1 class="text-3xl font-bold">{{ $produto->nome }}</h1>
            
            <!-- Avaliações -->
            <div class="flex items-center gap-2 text-yellow-500">
                ★★★★☆ <span class="text-gray-600 text-sm">(89 avaliações)</span>
            </div>

            <!-- Preço -->
            <div class="flex flex-col">
                <span class="text-2xl font-semibold text-green-600">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                <span class="text-sm line-through text-gray-500">R$ {{ number_format($produto->preco * 1.2, 2, ',', '.') }}</span>
                <span class="text-sm text-green-700">22% OFF</span>
            </div>

            <!-- Descrição -->
            <p class="text-gray-700">{{ $produto->descricao }}</p>

            <!-- Cores -->
            @if(count($estoqueImagens))
            <div>
                <h3 class="font-medium mb-2">Cores disponíveis</h3>
                <div class="flex gap-3">
                    @foreach($estoqueImagens as $index => $img)
                    <img src="{{ asset('storage/' . $img) }}"
                         class="w-16 h-16 rounded-md border cursor-pointer hover:opacity-80 transition"
                         onclick="document.querySelector('.main-image').src=this.src">
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Tamanhos -->
            @if(count($tamanhos))
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach($tamanhos as $tamanho)
                    <button class="px-4 py-2 border rounded-md hover:bg-gray-200">
                        {{ $tamanho }}
                    </button>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 mt-2">Nenhum tamanho disponível</p>
            @endif

            <!-- Botão Comprar -->
            <button class="mt-6 w-full bg-black text-white py-3 rounded-lg text-lg font-semibold hover:bg-gray-800 transition">
                Comprar agora
            </button>
        </div>
    </div>
</div>

</body>
</html>
