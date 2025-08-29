<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #produtos-container .preco-promocional {
            @apply text-red-600 font-bold;
        }
        #produtos-container .preco-antigo {
            @apply line-through text-gray-500 text-sm;
        }
    </style>
</head>
<body class="bg-[#111] text-white">

<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-3 gap-8">
    
    <!-- COLUNA ESQUERDA (Itens do Carrinho) -->
    <div class="md:col-span-2">
        <h1 class="text-3xl font-bold mb-6">SEU CARRINHO</h1>

        @if($carrinho && $carrinho->itens->count() > 0)
            @php $total = 0; @endphp
            @foreach($carrinho->itens as $item)
                @php 
                    $subtotal = $item->quantidade * $item->produto->preco; 
                    $total += $subtotal; 
                    $fotos = json_decode($item->produto->fotos ?? '[]', true);
                    $foto = $fotos[0] ?? null;
                @endphp

                <div class="flex flex-col md:flex-row items-center justify-between border-b border-gray-700 py-4">
                    <!-- Imagem -->
                    <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/100' }}" 
                         alt="{{ $item->produto->nome }}" 
                         class="w-28 h-28 object-cover rounded mr-4 mb-2 md:mb-0">

                    <!-- Informações -->
                    <div class="flex-1">
                        <p class="font-semibold text-lg">{{ $item->produto->nome }}</p>
                        <p class="text-gray-400">Tamanho: {{ $item->tamanho ?? 'Único' }}</p>
                        <p class="text-gray-400">Qtd: {{ $item->quantidade }}</p>
                        @if($item->quantidade <= 2)
                            <p class="text-red-500 font-medium">Baixo estoque</p>
                        @endif
                        <p class="mt-1">Preço unitário: 
                            <span class="font-semibold">R$ {{ number_format($item->produto->preco, 2, ',', '.') }}</span>
                        </p>
                        <p>Subtotal: 
                            <span class="font-semibold">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                        </p>
                    </div>

                    <!-- Botão remover -->
                    <form action="{{ route('carrinho.remover', [$item->produto_id, $item->tamanho]) }}" 
                          method="POST" class="mt-3 md:mt-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                            Remover
                        </button>
                    </form>
                </div>
            @endforeach
        @else
            <p class="text-gray-400">Seu carrinho está vazio.</p>
        @endif
    </div>

    <!-- COLUNA DIREITA (Resumo do Pedido) -->
    <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-6 h-fit shadow-lg">
        <h2 class="text-xl font-bold mb-4">RESUMO DO PEDIDO</h2>
        <div class="flex justify-between text-gray-300 mb-2">
            <span>{{ $carrinho ? $carrinho->itens->sum('quantidade') : 0 }} item(s)</span>
            <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-gray-300 mb-2">
            <span>Entrega</span>
            <span>R$ 15,00</span>
        </div>
        <div class="flex justify-between text-lg font-bold border-t border-gray-700 pt-3 mb-6">
            <span>Total</span>
            <span>R$ {{ number_format($total + 15, 2, ',', '.') }}</span>
        </div>

        <a href="#" class="block text-sm text-gray-400 mb-4 hover:underline">Usar código promocional</a>

        <form action="{{ route('carrinho.finalizar') }}" method="POST">
            @csrf
            <button class="w-full bg-white text-black font-bold py-3 rounded-lg hover:bg-gray-200 transition">
                FINALIZAR
            </button>
        </form>

        <div class="flex items-center space-x-3 mt-6">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" class="h-6" alt="Visa">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-6" alt="Mastercard">
            <img src="https://logospng.org/download/pix/logo-pix-icone-1024.png" class="h-6" alt="Pix">
        </div>
    </div>
</div>

<!-- RECOMENDAÇÕES -->
<div class="container mx-auto px-6 mt-16">
    <h2 class="text-2xl font-bold mb-6">AS NOSSAS RECOMENDAÇÕES</h2>
    <div id="produtos-container" 
         class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6
                [&>div]:bg-white [&>div]:rounded-xl [&>div]:shadow 
                [&>div]:hover:shadow-lg [&>div]:transition 
                [&>div]:overflow-hidden [&>div]:relative
                [&>div]:flex [&>div]:flex-col">
        @forelse($produtos ?? [] as $produto)
            @include('usuarios.partials.card-produto', ['produto' => $produto])
        @empty
            <p class="text-gray-400">Nenhum produto disponível no momento.</p>
        @endforelse
    </div>
</div>

</body>
</html>
