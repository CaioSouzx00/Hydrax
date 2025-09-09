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
<body class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-white">

<div class="container mx-auto p-6 grid grid-cols-1 lg:grid-cols-3 gap-8 mt-6">

    <!-- COLUNA PRINCIPAL: CARRINHO -->
    <div class="lg:col-span-2">
        <!-- Voltar -->
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-[#14ba88] inline-block">
                &larr; Voltar à Tela Inicial
            </a>
        </div>

        <h1 class="text-3xl font-bold mb-6">SEU CARRINHO</h1>

        <!-- Mensagens -->
        @if(session('success'))
            <div class="bg-green-600/80 border border-green-600 text-white p-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-600/80 border border-red-600 text-white p-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($carrinho && $carrinho->itens->count() > 0)
            @php $total = 0; @endphp
            @foreach($carrinho->itens as $item)
                @php 
                    $subtotal = $item->quantidade * $item->produto->preco; 
                    $total += $subtotal; 
                    $fotos = json_decode($item->produto->fotos ?? '[]', true);
                    $foto = $fotos[0] ?? null;
                @endphp

                <div class="flex flex-col md:flex-row items-center justify-between border-t border-gray-700 py-4 px-4 hover:bg-[#14ba88]/10">

    <!-- Link para o detalhe do produto -->
        <a href="{{ route('produtos.detalhes', $item->produto->id_produtos) }}" class="flex items-center flex-1">

        <!-- Imagem -->
        <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/100' }}" 
             alt="{{ $item->produto->nome }}" 
             class="w-36 h-36 object-cover rounded-lg mr-4 mb-3 md:mb-0">

        <!-- Informações -->
        <div>
            <p class="font-semibold text-lg">{{ $item->produto->nome }}</p>
            <p class="text-gray-400">Tamanho: {{ $item->tamanho ?? 'Único' }}</p>
            <p class="text-gray-400">Quantidade: {{ $item->quantidade }}</p>
            @if($item->quantidade <= 2)
                <p class="text-red-500 font-medium">Baixo estoque</p>
            @endif
            <p class="mt-1">Preço unitário: 
                <span class="font-semibold">R$ {{ number_format($item->produto->preco, 2, ',', '.') }}</span>
            </p>
            <p class="text-[#D5891B]">Subtotal: 
                <span class="font-semibold">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
            </p>
        </div>
    </a>

    <!-- Botão remover -->
    <form action="{{ route('carrinho.remover', [$item->produto_id, $item->tamanho]) }}" method="POST" class="mt-3 md:mt-0">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600/50 text-white px-4 py-2 rounded-lg hover:bg-red-700/80 transition">
            Remover
        </button>
    </form>
</div>

            @endforeach
        @else
            <p class="text-gray-400">Seu carrinho está vazio.</p>
        @endif
    </div>

    <!-- COLUNA DIREITA: RESUMO DO PEDIDO -->
    <div class="bg-black/30 border border-[#333] rounded-xl p-6 mt-24 h-fit shadow-lg">
        <h2 class="text-xl font-bold mb-12">RESUMO DO PEDIDO:</h2>

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

<a href="{{ route('carrinho.finalizar') }}" 
   class="relative w-full px-5 py-3 overflow-hidden font-bold text-gray-600 bg-white border border-[#14ba88] rounded-lg shadow-inner group text-lg text-center inline-block">

    <!-- bordas animadas -->
    <span class="absolute top-0 left-0 w-0 h-0 transition-all duration-200 
                 border-t-2 border-[#14ba88] group-hover:w-full ease"></span>
    <span class="absolute bottom-0 right-0 w-0 h-0 transition-all duration-200 
                 border-b-2 border-[#14ba88] group-hover:w-full ease"></span>

    <!-- preenchimento verde -->
    <span class="absolute top-0 left-0 w-full h-0 transition-all duration-300 
                 delay-200 bg-[#14ba88] group-hover:h-full ease"></span>
    <span class="absolute bottom-0 left-0 w-full h-0 transition-all duration-300 
                 delay-200 bg-[#14ba88] group-hover:h-full ease"></span>

    <!-- overlay mais escuro -->
    <span class="absolute inset-0 w-full h-full duration-300 delay-300 
                 bg-[#117c66] opacity-0 group-hover:opacity-100"></span>

    <!-- texto -->
    <span class="relative transition-colors duration-300 delay-200 
                 group-hover:text-white ease">
        FINALIZAR COMPRA
    </span>
</a>


        <div class="flex items-center space-x-4 mt-6">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" class="h-6" alt="Visa">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-6" alt="Mastercard">
            <img src="https://logospng.org/download/pix/logo-pix-icone-1024.png" class="h-6" alt="Pix">
        </div>
    </div>
</div>

<!-- RECOMENDAÇÕES -->
<div class="container px-6 mt-16 mb-10">
    <hr class="border-t border-[#d5891b]/20 my-12">
    <h2 class="text-2xl font-bold mb-2 pl-12">RECOMENDADOS PARA VOCÊ</h2>
    <div id="produtos-container" 
         class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-96 scale-75 pr-12
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

@include('usuarios.partials.footer')
</body>
</html>
