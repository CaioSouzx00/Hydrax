<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
<title>Pedido #{{ $pedido->id }} - Rastreamento</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-gray-100 font-sans min-h-screen">

<div class="container mx-auto p-6 space-y-6">

        <!-- Botão Voltar -->
        <div class="mb-5">
            <a href="{{ route('usuarios.pedidos') }}"
               class="group fixed top-5 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#117c66]"
               title="Voltar" aria-label="Botão Voltar">
                <div class="flex items-center justify-center w-10 h-10 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <span class="ml-2 w-0 group-hover:w-auto opacity-0 group-hover:opacity-100 overflow-hidden whitespace-nowrap transition-all duration-300 ease-in-out">
                    Voltar
                </span>
            </a>
        </div>

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
        ['nome' => 'Pedido recebido', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v4H3zM3 7h18v14H3z" /></svg>'],
        ['nome' => 'Separação', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2h-4l-2-2-2 2H6a2 2 0 00-2 2v7" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 13v5a2 2 0 002 2h8a2 2 0 002-2v-5" /></svg>'],
        ['nome' => 'A caminho', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h2l2 5h11l2-5h2" /><circle cx="7.5" cy="18.5" r="1.5" /><circle cx="16.5" cy="18.5" r="1.5" /></svg>'],
        ['nome' => 'Entregue', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" /></svg>'],
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
                    {!! $etapa['icone'] !!}
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

        // Verifica desconto
        $descontoItem = 0;
        if(isset($cupomAplicado)) {
            if($cupomAplicado['tipo'] === 'percentual'){
                $descontoItem = $subtotal * ($cupomAplicado['valor']/100);
            } else {
                $totalProdutos = $pedido->itens->sum(fn($i)=> $i->quantidade * $i->produto->preco);
                $descontoItem = ($subtotal / $totalProdutos) * $cupomAplicado['valor'];
            }
        }

        $subtotalComDesconto = $subtotal - $descontoItem;
        $totalItens += $subtotalComDesconto;
        $descontoTotal += $descontoItem;

        // Verifica se já foi avaliado
        $jaAvaliado = \App\Models\Avaliacao::where('id_usuarios', Auth::guard('usuarios')->id())
                        ->where('id_produtos', $item->produto->id_produtos)
                        ->exists();
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

        <!-- Botão de avaliação -->
        @if($pedido->status === 'finalizado' && !$jaAvaliado)
            <div class="mt-2 md:mt-0">
<a href="{{ route('avaliacoes.create', ['id_produto' => $item->produto->id_produtos]) }}"
   class="relative inline-block rounded-lg px-5 py-2.5 overflow-hidden group bg-[#14ba88] hover:bg-gradient-to-r hover:from-[#14ba88] hover:to-[#0f9e70] text-black font-semibold shadow-md hover:ring-2 hover:ring-offset-2 hover:ring-[#14ba88] transition-all duration-300">
    
    <!-- faixa de brilho -->
    <span aria-hidden="true"
          class="pointer-events-none absolute right-0 top-1/2 -translate-y-1/2 w-10 h-36 transform translate-x-10 rotate-12 bg-white opacity-10 transition-transform duration-700 group-hover:-translate-x-40">
    </span>

    <!-- texto do botão -->
    <span class="relative">Avaliar Produto</span>
</a>

            </div>
        @elseif($pedido->status === 'finalizado' && $jaAvaliado)
            <span class="px-4 py-2 bg-gray-600 text-white text-sm rounded-lg">Produto avaliado</span>
        @endif
    </div>
@endforeach

<!-- Total do pedido -->
<div class="mt-6 p-6 bg-[#1e1e2a]/50 rounded-2xl shadow-lg text-right border border-[#14ba88]/20">
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
