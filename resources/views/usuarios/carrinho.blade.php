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

        <a href="#" class="block text-sm text-gray-400 mb-4 hover:underline">Usar código promocional</a>

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
<div class="container mx-auto px-6 mt-16 mb-10">
    <hr class="border-t border-[#d5891b]/20 my-12">
    <h2 class="text-2xl font-bold mb-6">RECOMENDADOS PARA VOCÊ</h2>
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
