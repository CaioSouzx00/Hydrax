<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
    <title>Minha Lista de Desejos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class=" min-h-screen bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-white font-poppins">
<!-- Navbar -->
  <header class="fixed top-0 left-0 w-full z-50 backdrop-blur-md bg-gradient-to-br from-[#211828]/90 via-[#0b282a]/90 to-[#17110d]/90ss border-b border-[#7f3a0e] shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">

      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="/imagens/hydrax/HYDRA’x.png" alt="Hydrax Logo" class="h-14" />
      </div>

      <!-- Menu principal -->
      <nav class="hidden md:flex items-center gap-6 text-sm">

<style>
@keyframes bounce-subtle {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-3px); }
}
.animate-bounce-subtle {
  animation: bounce-subtle 1s infinite;
}
</style>


      </nav>
    </div>
  </header>
<!-- Botão voltar -->
<a href="{{ route('dashboard') }}"
   class="group fixed top-5 right-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#117c66]"
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

<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8 text-white mt-24 border-b border-[#d5891b]/80 w-fit">MINHA LISTA DE DESEJOS</h1>

    @if($desejos->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($desejos as $desejo)
            @php
                $produto = $desejo->produto;
                $fotos = is_array($produto->fotos) ? $produto->fotos : json_decode($produto->fotos, true);
                $fotoPrincipal = $fotos[0] ?? 'https://via.placeholder.com/400x400?text=Produto';
            @endphp

            <div class="bg-gradient-to-b from-[#211828] via-[#0b282a] to-[#17110d] border border-[#d5891b]/30 rounded-xl shadow-lg overflow-hidden relative group hover:border-[#d5891b]/50 transition-all duration-300">
                
{{-- Botão remover / Curtir --}}
<form action="{{ route('lista-desejos.destroy', $produto->id_produtos) }}" method="POST" class="absolute top-3 right-3 z-50">
    @csrf
    @method('DELETE')
    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-lg border border-[#d5891b]/50 text-[#d5891b] bg-[#111] hover:bg-[#222] hover:scale-110 transition-all duration-300 relative group">
        <span class="absolute inset-0 bg-[#14ba88] rounded-lg opacity-0 group-hover:opacity-20 transition-all duration-300"></span>
        <svg class="w-5 h-5 relative z-10" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 
            4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 
            14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 
            6.86-8.55 11.54L12 21.35z"/>
        </svg>
    </button>
</form>


                {{-- Link para detalhes do produto --}}
                <a href="{{ route('produtos.detalhes', $produto->id_produtos) }}">
                    {{-- Foto do produto --}}
                    <div class="w-full h-64">
                        <img src="{{ asset('storage/' . $fotoPrincipal) }}" alt="{{ $produto->nome }}" class="w-full h-full object-cover">
                    </div>

                    {{-- Info do produto --}}
                    <div class="p-4 flex flex-col space-y-2">
                        <h3 class="text-lg font-semibold truncate text-white" title="{{ $produto->nome }}">{{ $produto->nome }}</h3>
                        <p class="text-gray-400 text-sm truncate">{{ $produto->categoria ?? 'Categoria não informada' }}</p>
                        <p class="text-lg font-bold text-[#14ba88]">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>

                        {{-- Info do fornecedor --}}
                        <div class="flex items-center space-x-2 mt-2">
                            <img src="{{ $produto->fornecedor->foto ? asset('storage/' . $produto->fornecedor->foto) : 'https://via.placeholder.com/40x40?text=F' }}" 
                                 alt="{{ $produto->fornecedor->nome_empresa }}" 
                                 class="w-8 h-8 rounded-full object-cover border border-[#14ba88]/30">
                            <span class="text-gray-400 text-xs">{{ $produto->fornecedor->nome_empresa ?? 'Fornecedor não informado' }}</span>
                        </div>

                        {{-- Avaliação --}}
                        <div class="flex items-center space-x-2 mt-2">
                            <div class="flex items-center space-x-[1px]">
                                @php
                                    $notaMediaCard = $produto->avaliacoes_avg_nota ?? 0;
                                    $avaliacoesContador = $produto->avaliacoes->count() ?? 0;
                                @endphp

                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($notaMediaCard))
                                        <span class="text-[#14ba88]">&#9733;</span>
                                    @elseif ($i - 0.5 <= $notaMediaCard)
                                        <span class="text-[#14ba88] opacity-50">&#9733;</span>
                                    @else
                                        <span class="text-gray-600">&#9733;</span>
                                    @endif
                                @endfor
                            </div>
                            @if($avaliacoesContador > 0)
                                <span class="text-xs text-gray-400">({{ $avaliacoesContador }} avaliações)</span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @else
        <div class="flex flex-col items-center justify-center mt-12">
    <svg class="w-16 h-16 text-[#d5891b]/70 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
    <p class="text-[#d5891b]/80 text-lg font-semibold text-center">
        Sua lista de desejos está vazia!
    </p>
    <p class="text-gray-400 text-sm text-center mt-1">
        Adicione produtos para vê-los aqui e acompanhar seus favoritos.
    </p>
</div>

    @endif
</div>
@include('usuarios.partials.footer')
</body>
</html>
