<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
<title>Minhas Compras - Hydrax</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-gray-100 font-sans min-h-screen">

<div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-3 gap-8">

    <!-- COLUNA ESQUERDA: Lista de Pedidos -->
    <div class="md:col-span-2 space-y-6">

        <!-- Voltar -->
        <div>
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-[#14ba88]/50 transition">
                &larr; Voltar a Tela Inicial
            </a>
        </div>

        <h1 class="text-3xl font-bold text-[#14ba88] tracking-wide">Minhas Compras</h1>

        @foreach($pedidos as $pedido)
            <a href="{{ route('pedidos.detalhe', $pedido->id) }}" 
               class="block bg-[#1e1e2a] border border-[#14ba88]/20 rounded-2xl p-6 hover:border-[#14ba88]/50 transition flex flex-col gap-4">

                <!-- Header do pedido -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-lg text-white">Pedido #{{ $pedido->id }}</p>
                        <p class="text-gray-400 text-sm">Data: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                 {{ $pedido->status == 'finalizado' ? 'bg-[#14ba88] text-black' : 'bg-[#e29b37] text-black' }}">
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

                    <div class="flex flex-col md:flex-row items-center gap-4 border-t border-[#14ba88]/20 pt-4 last:border-b-0">

                        <!-- Imagem -->
                        <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/100' }}" 
                             alt="{{ $item->produto->nome }}" 
                             class="w-24 h-24 object-cover rounded-xl border border-[#14ba88]/30">

                        <!-- Informações -->
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

                            <!-- Endereço -->
                            @if($pedido->endereco)
                                <div class="mt-2 text-sm text-gray-300 bg-[#0b282a] rounded-xl p-3 border border-[#14ba88]/20">
                                    <p class="font-semibold text-[#14ba88] mb-1">Endereço de entrega:</p>
                                    <p>{{ $pedido->endereco->rua }}, {{ $pedido->endereco->numero ?? '' }}</p>
                                    <p>{{ $pedido->endereco->bairro }} - {{ $pedido->endereco->cidade }}/{{ $pedido->endereco->estado }}</p>
                                    <p>CEP: {{ $pedido->endereco->cep }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </a>
        @endforeach
    </div>

    <!-- COLUNA DIREITA: Resumo geral -->
    <div class="bg-[#1e1e2a] border border-[#14ba88]/20 rounded-2xl p-6 flex flex-col gap-4">
        <h2 class="text-xl font-bold text-[#14ba88]">Resumo Geral</h2>

        <div class="flex justify-between text-gray-300">
            <span>Total de pedidos</span>
            <span class="text-white font-semibold">{{ $pedidos->count() }}</span>
        </div>

        <div class="flex justify-between text-gray-300">
            <span>Total gasto</span>
            <span class="text-white font-semibold">
                R$ {{ number_format($pedidos->sum(fn($p) => $p->itens->sum(fn($i) => $i->quantidade * $i->produto->preco) + 15), 2, ',', '.') }}
            </span>
        </div>

        <p class="text-gray-400 text-sm mt-4">* Valor total já considerando a taxa de entrega de R$15,00 por pedido.</p>
    </div>

</div>

@include('usuarios.partials.footer')

</body>
</html>
