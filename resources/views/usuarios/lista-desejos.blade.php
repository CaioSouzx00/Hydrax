<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
    <title>Minha Lista de Desejos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f0f0f] text-white font-sans">


<!-- Botão voltar -->
<a href="{{ route('dashboard') }}"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#117c66]"
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
    <h1 class="text-3xl font-bold mb-8">MINHA LISTA DE DESEJOS</h1>

    @if($desejos->count() > 0)
     <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
    @foreach($desejos as $desejo)
        @php
            $produto = $desejo->produto;
            $fotos = is_array($produto->fotos) ? $produto->fotos : json_decode($produto->fotos, true);
            $fotoPrincipal = $fotos[0] ?? 'https://via.placeholder.com/400x400?text=Produto';
        @endphp

        <div class="bg-[#111]/50 border border-[#222] rounded-xl shadow-lg overflow-hidden relative group hover:border-[#D5891B]/50 transition-all duration-200">
            
            {{-- Botão remover --}}
            <form action="{{ route('lista-desejos.destroy', $produto->id_produtos) }}" method="POST" class="absolute top-3 right-3 z-50">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-[#111] border border-[#d5891b]/50 rounded-lg hover:bg-[#222] transition">
                    ♥
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
                    <h3 class="text-lg font-semibold truncate" title="{{ $produto->nome }}">{{ $produto->nome }}</h3>
                    <p class="text-gray-400 text-sm truncate">{{ $produto->categoria ?? 'Categoria não informada' }}</p>
                    <p class="text-lg font-bold text-white">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>

                    {{-- Info do fornecedor --}}
                    <div class="flex items-center space-x-2 mt-2">
                        <img src="{{ $produto->fornecedor->foto ? asset('storage/' . $produto->fornecedor->foto) : 'https://via.placeholder.com/40x40?text=F' }}" 
                             alt="{{ $produto->fornecedor->nome_empresa }}" 
                             class="w-8 h-8 rounded-full object-cover border border-[#D5891B]/20">
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

            </a>
        </div>
    @endforeach
</div>

    @else
        <p class="text-gray-500">Sua lista de desejos está vazia.</p>
    @endif
</div>
</body>
</html>
