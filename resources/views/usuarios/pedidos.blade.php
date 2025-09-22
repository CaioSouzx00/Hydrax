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

        <!-- Botão Voltar -->
        <div class="mb-5">
            <a href="{{ route('dashboard') }}"
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

        <h1 class="text-3xl font-bold text-white border-b border-[#14ba88]/80 w-fit tracking-wide">Minhas Compras</h1>

        @if($pedidos->isEmpty())
            <!-- Quando não houver pedidos -->
            <div class="flex flex-col items-center justify-center bg-[#1e1e2a]/50 border border-[#14ba88]/20 rounded-2xl p-10 mt-6 text-center animate-fade-in">
                <!-- Ícone -->
                <svg class="w-16 h-16 text-[#14ba88] mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007.53 17h10.94a1 1 0 00.88-1.45L17 9H7m5 4v6m-4-6v6m8-6v6"/>
                </svg>

                <!-- Mensagem -->
                <p class="text-gray-300 text-lg font-medium mb-2">Você ainda não fez nenhuma compra.</p>
                <p class="text-gray-500 text-sm mb-6">Quando você comprar algo, seus pedidos aparecerão aqui.</p>

                <!-- Botão -->
                <a href="{{ route('dashboard') }}"
                   class="px-6 py-3 bg-[#14ba88] hover:bg-[#117c66] text-black font-semibold rounded-xl transition-all duration-200 shadow-lg">
                    Explorar Produtos
                </a>
            </div>
        @else
            @foreach($pedidos as $pedido)
                <a href="{{ route('pedidos.detalhe', $pedido->id) }}" 
                   class="block bg-[#1e1e2a]/50 border border-[#14ba88]/20 rounded-2xl p-6 hover:border-[#14ba88]/50 transition flex flex-col gap-4">

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
        @endif
    </div>

    <!-- COLUNA DIREITA: Resumo geral -->
    <div class="bg-[#1e1e2a]/50 border border-[#14ba88]/20 rounded-2xl p-6 flex flex-col gap-4 
                md:sticky md:top-6 md:self-start mt-20 h-fit">
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

<!-- Animação opcional -->
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}
</style>

</body>
</html>
