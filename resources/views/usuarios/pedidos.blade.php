<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Compras</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#111] text-white font-sans">

<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-3 gap-8">

    <!-- COLUNA ESQUERDA -->
    <div class="md:col-span-2">

        <h1 class="text-3xl font-bold mb-6 tracking-wide">MINHAS COMPRAS</h1>

        @foreach($pedidos as $pedido)
            <div class="bg-[#1a1a1a] border border-gray-800 rounded-2xl shadow-xl p-6 mb-6 hover:shadow-2xl transition duration-300">
                
                <!-- Header do pedido -->
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="font-semibold text-lg">Pedido #{{ $pedido->id }}</p>
                        <p class="text-gray-400 text-sm">Data: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                 {{ $pedido->status == 'finalizado' ? 'bg-green-600 text-white' : 'bg-yellow-500 text-black' }}">
                        {{ strtoupper($pedido->status) }}
                    </span>
                </div>

                <!-- Itens do pedido -->
                @foreach($pedido->itens as $item)
                    @php 
                        $subtotal = $item->quantidade * $item->produto->preco; 
                        $fotos = json_decode($item->produto->fotos ?? '[]', true);
                        $foto = $fotos[0] ?? null;
                    @endphp

                    <div class="flex flex-col md:flex-row items-center justify-between border-b border-gray-700 py-4 last:border-b-0">
                        <!-- Imagem -->
                        <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/100' }}" 
                             alt="{{ $item->produto->nome }}" 
                             class="w-28 h-28 object-cover rounded-xl shadow-lg mr-4 mb-2 md:mb-0">

                        <!-- Info -->
                        <div class="flex-1">
                            <p class="font-semibold text-lg">{{ $item->produto->nome }}</p>
                            <p class="text-gray-400 text-sm">Tamanho: {{ $item->tamanho ?? 'Único' }}</p>
                            <p class="text-gray-400 text-sm">Qtd: {{ $item->quantidade }}</p>
                            <p class="mt-1 text-gray-200">Preço unitário: 
                                <span class="font-semibold">R$ {{ number_format($item->produto->preco, 2, ',', '.') }}</span>
                            </p>
                            <p class="text-gray-200">Subtotal: 
                                <span class="font-semibold text-white">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </p>

                            <!-- Endereço -->
                            @if($pedido->endereco)
                                <div class="mt-3 text-sm text-gray-300 bg-[#222] rounded-xl p-3 shadow-inner">
                                    <p class="font-semibold text-white mb-1">Endereço de entrega:</p>
                                    <p>{{ $pedido->endereco->rua }}, {{ $pedido->endereco->numero ?? '' }}</p>
                                    <p>{{ $pedido->endereco->bairro }} - {{ $pedido->endereco->cidade }}/{{ $pedido->endereco->estado }}</p>
                                    <p>CEP: {{ $pedido->endereco->cep }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <!-- COLUNA DIREITA (Resumo geral) -->
    <div class="bg-[#1a1a1a] border border-gray-800 rounded-2xl p-6 shadow-xl">
        <h2 class="text-xl font-bold mb-4 tracking-wide">RESUMO GERAL</h2>

        <div class="flex justify-between text-gray-300 mb-2">
            <span>Total de pedidos</span>
            <span>{{ $pedidos->count() }}</span>
        </div>

        <div class="flex justify-between text-gray-300 mb-2">
            <span>Total gasto</span>
            <span>
                R$ {{ number_format($pedidos->sum(fn($p) => $p->itens->sum(fn($i) => $i->quantidade * $i->produto->preco) + 15), 2, ',', '.') }}
            </span>
        </div>

        <p class="text-gray-400 text-sm mt-6">* Este é o valor total já considerando a taxa de entrega de R$15,00 por pedido.</p>
    </div>
</div>

</body>
</html>
