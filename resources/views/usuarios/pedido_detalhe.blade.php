<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pedido #{{ $pedido->id }} - Rastreamento</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#111] text-white font-sans min-h-screen">

<div class="container mx-auto p-6">

    <!-- Voltar -->
    <a href="{{ route('usuarios.pedidos') }}" class="text-gray-400 hover:text-white mb-6 inline-block">&larr; Voltar para meus pedidos</a>

    <!-- Header do pedido -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <h1 class="text-3xl font-bold tracking-wide">Pedido #{{ $pedido->id }}</h1>
        <span class="mt-2 md:mt-0 px-4 py-2 rounded-full text-sm font-semibold 
            {{ $pedido->status == 'finalizado' ? 'bg-green-600 text-white' : 'bg-yellow-500 text-black' }}">
            {{ strtoupper($pedido->status) }}
        </span>
    </div>

    <p class="text-gray-400 text-sm mb-4">Data do pedido: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>

    <!-- Endereço -->
    @if($pedido->endereco)
        <div class="mt-4 text-sm text-gray-300 bg-[#222] rounded-2xl p-4 shadow-inner mb-8">
            <p class="font-semibold text-white mb-2">Endereço de entrega:</p>
            <p>{{ $pedido->endereco->rua }}, {{ $pedido->endereco->numero ?? '' }}</p>
            <p>{{ $pedido->endereco->bairro }} - {{ $pedido->endereco->cidade }}/{{ $pedido->endereco->estado }}</p>
            <p>CEP: {{ $pedido->endereco->cep }}</p>
        </div>
    @endif

    <!-- Rastreamento do pedido -->
    <h2 class="text-2xl font-bold mb-6">Rastreamento da entrega</h2>

    @php
        // Etapas da entrega
        $etapas = [
            ['nome' => 'Pedido recebido', 'icone' => '🛒'],
            ['nome' => 'Separação', 'icone' => '📦'],
            ['nome' => 'A caminho', 'icone' => '🚚'],
            ['nome' => 'Entregue', 'icone' => '🏠'],
        ];

        // Determina etapa atual baseada no status
        $statusMap = [
            'finalizado' => 3,
            'a_caminho' => 2,
            'separando' => 1,
            'pendente' => 0
        ];
        $etapaAtual = $statusMap[$pedido->status] ?? 0;
    @endphp

    <div class="relative mb-12">
        <div class="flex justify-between items-center">
            @foreach($etapas as $index => $etapa)
                <div class="flex flex-col items-center relative flex-1">
                    <!-- Círculo -->
                    <div class="w-10 h-10 rounded-full flex items-center justify-center 
                        @if($index < $etapaAtual) bg-green-600 text-black
                        @elseif($index == $etapaAtual) bg-yellow-500 text-black animate-pulse
                        @else bg-gray-700 text-black @endif z-10 relative font-bold text-lg">
                        {{ $etapa['icone'] }}
                    </div>
                    <!-- Nome da etapa -->
                    <p class="text-center text-sm mt-2">{{ $etapa['nome'] }}</p>

                    <!-- Linha conectando etapas -->
                    @if($index < count($etapas) - 1)
                        <div class="absolute top-5 left-1/2 w-full h-1 bg-gray-700 z-0" style="transform: translateX(50%);"></div>
                        <div class="absolute top-5 left-1/2 h-1 z-0" style="transform: translateX(50%); width: {{ ($etapaAtual > $index ? 100 : 0) }}%; background-color:#16a34a;"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Itens do pedido -->
    <h2 class="text-2xl font-bold mb-4">Itens do pedido</h2>

    @foreach($pedido->itens as $item)
        @php
            $subtotal = $item->quantidade * $item->produto->preco;
            $fotos = json_decode($item->produto->fotos ?? '[]', true);
            $foto = $fotos[0] ?? null;
        @endphp

        <div class="flex flex-col md:flex-row items-center justify-between border-b border-gray-700 py-4 last:border-b-0">
            
            <!-- Imagem do produto -->
            <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/100' }}" 
                 alt="{{ $item->produto->nome }}" class="w-28 h-28 object-cover rounded-xl shadow-lg mr-4 mb-2 md:mb-0">

            <!-- Informações do produto -->
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
                @if($item->produto->descricao)
                    <p class="text-gray-400 text-sm mt-2">{{ $item->produto->descricao }}</p>
                @endif
            </div>
        </div>
    @endforeach

    <!-- Total do pedido -->
    <div class="mt-6 p-6 bg-[#1a1a1a] rounded-2xl shadow-xl text-right">
        <p class="text-gray-300 font-semibold text-lg">Total do pedido: 
            <span class="text-white text-xl">
                R$ {{ number_format($pedido->itens->sum(fn($i) => $i->quantidade * $i->produto->preco) + 15, 2, ',', '.') }}
            </span>
        </p>
        <p class="text-gray-400 text-sm mt-1">* Incluindo taxa de entrega de R$15,00</p>
    </div>

</div>

</body>
</html>
