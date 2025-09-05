<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<footer class="bg-black text-white w-full mt-16">
  <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-sm">
    
    <!-- Coluna 1 -->
    <div>
      <ul class="space-y-3">
        <li><a href="#" class="hover:underline">Cadastre-se para receber novidades</a></li>
        <li><a href="#" class="hover:underline">Cartão presente</a></li>
        <li><a href="#" class="hover:underline">Guia de produtos</a></li>
        <li><a href="#" class="hover:underline">Black Friday</a></li>
        <li><a href="#" class="hover:underline">Acompanhe seu pedido</a></li>
      </ul>
    </div>

    <!-- Coluna 2 -->
    <div>
      <h3 class="font-semibold mb-3">Ajuda</h3>
      <ul class="space-y-3">
        <li><a href="#" class="hover:underline">Dúvidas gerais</a></li>
        <li><a href="#" class="hover:underline">Encontre seu tamanho</a></li>
        <li><a href="#" class="hover:underline">Entregas</a></li>
        <li><a href="#" class="hover:underline">Pedidos</a></li>
        <li><a href="#" class="hover:underline">Devoluções</a></li>
        <li><a href="#" class="hover:underline">Pagamentos</a></li>
        <li><a href="#" class="hover:underline">Produtos</a></li>
        <li><a href="#" class="hover:underline">Corporativo</a></li>
        <li><a href="#" class="hover:underline">Fale conosco</a></li>
        <li><a href="#" class="hover:underline">Relatar problema</a></li>
      </ul>
    </div>

    <!-- Coluna 3 -->
    <div>
      <h3 class="font-semibold mb-3">Sobre Hydrax</h3>
      <ul class="space-y-3">
        <li><a href="#" class="hover:underline">Propósito</a></li>
        <li><a href="#" class="hover:underline">Sustentabilidade</a></li>
        <li><a href="#" class="hover:underline">Sobre o SURA, Inc.</a></li>
      </ul>
    </div>

    <!-- Coluna 4 -->
    <div class="space-y-6">
      <div>
        <h3 class="font-semibold mb-3">Redes sociais</h3>
        <div class="flex space-x-4 text-2xl">
          <a href="#" class="hover:text-[#1877F2]"><i class="fab fa-facebook"></i></a>
          <a href="#" class="hover:text-[#E4405F]"><i class="fab fa-instagram"></i></a>
          <a href="#" class="hover:text-[#FF0000]"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      <div>
        <h3 class="font-semibold mb-3">Formas de pagamento</h3>
        <div class="flex flex-wrap gap-3 items-center">
          <!-- Mastercard -->
          <img src="https://img.icons8.com/color/48/mastercard-logo.png" class="h-8" alt="Mastercard">

          <!-- Pix (SVG inline, sem depender de link externo) -->
          <svg viewBox="0 0 64 64" class="h-8 w-8" role="img" aria-label="Pix" title="Pix">
            <!-- losango com cantos suavizados -->
            <rect x="14" y="14" width="36" height="36" rx="10" ry="10"
                  transform="rotate(45 32 32)" fill="#32BCAD"/>
            <!-- detalhes leves para lembrar o traço interno (opcional) -->
            <path d="M22 32h20" stroke="white" stroke-width="3" stroke-linecap="round" opacity="0.9"/>
            <path d="M32 22v20" stroke="white" stroke-width="3" stroke-linecap="round" opacity="0.9"/>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Linha de baixo -->
  <div class="border-t border-gray-700 mt-6 py-4 text-center text-xs text-gray-400 flex flex-wrap justify-center gap-4">
    <a href="#" class="hover:underline">Brasil</a>
    <a href="#" class="hover:underline">Política de privacidade</a>
    <a href="#" class="hover:underline">Política de cookies</a>
    <a href="#" class="hover:underline">Termos de uso</a>
  </div>

  <!-- Créditos -->
  <div class="text-center text-xs text-gray-500 px-6 pb-6">
    © 2025 Hydrax. Todos os direitos reservados. 
  </div>
</footer>
</body>
</html>
