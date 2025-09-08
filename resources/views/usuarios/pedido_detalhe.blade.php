<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pedido #{{ $pedido->id }} - Rastreamento</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-gray-100 font-sans min-h-screen">

<div class="container mx-auto p-6 space-y-6">

    <!-- Voltar -->
    <a href="{{ route('usuarios.pedidos') }}" class="text-gray-400 hover:text-[#14ba88] transition inline-block mb-2">
        &larr; Voltar para meus pedidos
    </a>

    <!-- Header do pedido -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
        <h1 class="text-3xl font-bold tracking-wide text-[#14ba88]">Pedido #{{ $pedido->id }}</h1>
        <span class="mt-2 md:mt-0 px-4 py-2 rounded-full text-sm font-semibold 
            {{ $pedido->status == 'finalizado' ? 'bg-[#14ba88] text-black' : 'bg-[#e29b37] text-black' }}">
            {{ strtoupper($pedido->status) }}
        </span>
    </div>

    <p class="text-gray-400 text-sm">Data do pedido: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>

    <!-- Endereço -->
    @if($pedido->endereco)
        <div class="mt-4 text-sm text-gray-300 bg-[#0b282a] rounded-2xl p-4 border border-[#14ba88]/20 shadow-inner">
            <p class="font-semibold text-[#14ba88] mb-2">Endereço de entrega:</p>
            <p>{{ $pedido->endereco->rua }}, {{ $pedido->endereco->numero ?? '' }}</p>
            <p>{{ $pedido->endereco->bairro }} - {{ $pedido->endereco->cidade }}/{{ $pedido->endereco->estado }}</p>
            <p>CEP: {{ $pedido->endereco->cep }}</p>
        </div>
    @endif

   <!-- Rastreamento do pedido -->
<h2 class="text-2xl font-bold mb-6 text-[#14ba88]">Rastreamento da entrega</h2>

@php
    $etapas = [
        ['nome' => 'Pedido recebido', 'icone' => '🛒'],
        ['nome' => 'Separação', 'icone' => '📦'],
        ['nome' => 'A caminho', 'icone' => '🚚'],
        ['nome' => 'Entregue', 'icone' => '🏠'],
    ];
    $statusMap = [
        'finalizado' => 3,
        'a_caminho' => 2,
        'separando' => 1,
        'pendente' => 0
    ];
    $etapaAtual = $statusMap[$pedido->status] ?? 0;
@endphp

<div class="relative mb-12">
    <!-- Linha horizontal -->
    <div class="absolute top-5 left-0 w-full h-1 bg-gray-700 rounded-full z-0"></div>
    <div class="absolute top-5 left-0 h-1 z-0 rounded-full" style="width: {{ ($etapaAtual/(count($etapas)-1))*100 }}%; background-color:#14ba88;"></div>

    <!-- Círculos e nomes -->
    <div class="flex justify-between relative z-10">
        @foreach($etapas as $index => $etapa)
            <div class="flex flex-col items-center w-1/4">
                <div class="w-10 h-10 rounded-full flex items-center justify-center
                    @if($index < $etapaAtual) bg-[#14ba88] text-black
                    @elseif($index == $etapaAtual) bg-[#e29b37] text-black animate-pulse
                    @else bg-gray-700 text-black @endif
                    font-bold text-lg border-2 border-[#14ba88]/40">
                    {{ $etapa['icone'] }}
                </div>
                <p class="text-center text-sm mt-2 text-gray-300">{{ $etapa['nome'] }}</p>
            </div>
        @endforeach
    </div>
</div>


<!-- Itens do pedido -->
<h2 class="text-2xl font-bold mb-4 text-[#14ba88]">Itens do pedido</h2>

@php
    $totalItens = 0;
    $descontoTotal = 0;
@endphp

@foreach($pedido->itens as $item)
    @php
        $subtotal = $item->quantidade * $item->produto->preco;
        $foto = json_decode($item->produto->fotos ?? '[]', true)[0] ?? null;

        // Verifica se o cupom foi aplicado neste item
        $descontoItem = 0;
        if(isset($cupomAplicado)) {
            if($cupomAplicado['tipo'] === 'percentual'){
                $descontoItem = $subtotal * ($cupomAplicado['valor']/100);
            } else {
                // Cupom fixo distribuído proporcionalmente
                $totalProdutos = $pedido->itens->sum(fn($i)=> $i->quantidade * $i->produto->preco);
                $descontoItem = ($subtotal / $totalProdutos) * $cupomAplicado['valor'];
            }
        }

        $subtotalComDesconto = $subtotal - $descontoItem;
        $totalItens += $subtotalComDesconto;
        $descontoTotal += $descontoItem;
    @endphp

    <div class="flex flex-col md:flex-row items-center justify-between border-b border-[#14ba88]/20 py-4 last:border-b-0 gap-4">
        
        <!-- Imagem do produto -->
        <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/100' }}" 
             alt="{{ $item->produto->nome }}" class="w-24 h-24 object-cover rounded-xl border border-[#14ba88]/30">

        <!-- Informações do produto -->
        <div class="flex-1 space-y-1">
            <p class="font-semibold text-white">{{ $item->produto->nome }}</p>
            <p class="text-gray-400 text-sm">Tamanho: {{ $item->tamanho ?? 'Único' }}</p>
            <p class="text-gray-400 text-sm">Qtd: {{ $item->quantidade }}</p>
            <p class="text-gray-200 text-sm">Preço unitário: 
                <span class="font-semibold text-[#14ba88]">R$ {{ number_format($item->produto->preco, 2, ',', '.') }}</span>
            </p>
            <p class="text-gray-200 text-sm">Subtotal: 
                <span class="font-semibold text-[#e29b37]">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
            </p>
            @if($descontoItem > 0)
                <p class="text-green-400 text-sm">Cupom "{{ $cupomAplicado['codigo'] }}" aplicado: -R$ {{ number_format($descontoItem, 2, ',', '.') }}</p>
                <p class="text-gray-200 text-sm">Subtotal com desconto: 
                    <span class="font-semibold text-[#14ba88]">R$ {{ number_format($subtotalComDesconto, 2, ',', '.') }}</span>
                </p>
            @endif
            @if($item->produto->descricao)
                <p class="text-gray-400 text-sm mt-1">{{ $item->produto->descricao }}</p>
            @endif
        </div>
    </div>
@endforeach

<!-- Total do pedido -->
<div class="mt-6 p-6 bg-[#1e1e2a] rounded-2xl shadow-lg text-right border border-[#14ba88]/20">
    <p class="text-gray-300 font-semibold text-lg">Total dos itens: 
        <span class="text-white text-xl">R$ {{ number_format($totalItens, 2, ',', '.') }}</span>
    </p>
    <p class="text-gray-400 text-sm mt-1">* Incluindo taxa de entrega de R$15,00</p>
    @php $totalComEntrega = $totalItens + 15; @endphp
    @if($descontoTotal > 0)
        <p class="text-green-400 text-sm mt-1">Total de desconto aplicado: -R$ {{ number_format($descontoTotal, 2, ',', '.') }}</p>
    @endif
    <p class="text-white font-bold text-xl mt-2">Total final: R$ {{ number_format($totalComEntrega, 2, ',', '.') }}</p>
</div>

</div>

@include('usuarios.partials.footer')
</body>
</html>
