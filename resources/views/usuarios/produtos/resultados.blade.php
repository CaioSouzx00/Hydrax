<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydrax IA - Busca de Produtos</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: radial-gradient(circle at top left, #211828, #0b282a, #17110d);
            color: #eaeaea;
            font-family: 'Poppins', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
        }

        .scan-line {
            position: absolute;
            width: 100%;
            height: 1.5px;
            background: linear-gradient(90deg, transparent, #14ba88, transparent);
            opacity: 0.35;
            animation: scan 4s linear infinite;
        }

        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }

        .neon:hover {
            transform: scale(1.03);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center px-6 py-10">

<!-- Botão Voltar -->
<a href="{{ route('dashboard') }}"
   class="group fixed top-4 left-5 z-50 flex items-center h-10 rounded-full 
          bg-[#14ba88] text-black px-2 transition-all duration-300 
          hover:bg-[#117c66] overflow-hidden">

    <!-- Ícone -->
    <div class="flex items-center justify-center w-10 h-10">
        <svg class="w-7 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </div>

    <!-- Texto -->
    <span class="ml-1 whitespace-nowrap opacity-0 w-0 
                 group-hover:opacity-100 group-hover:w-16 transition-all duration-300">
        Voltar
    </span>
</a>


    <!-- Linha de varredura -->
    <div class="relative w-full max-w-7xl">
        <div class="scan-line"></div>
    </div>

    <!-- Título -->
    <header class="text-center mb-14">
        <h1 class="text-5xl font-extrabold uppercase tracking-[0.14em] text-white">
            Hydrax<span class="text-[#14ba88]">IA</span>
        </h1>
        <p class="text-gray-300 mt-2 text-lg tracking-widest uppercase">
            Interface Inteligente de Busca
        </p>
    </header>

    <!-- Campo de busca -->
    <form action="{{ route('usuario.ia') }}" method="GET"
          class="w-full max-w-3xl mx-auto flex flex-col sm:flex-row items-center gap-4 glass rounded-2xl px-6 py-6 transition">

        <input type="text" name="prompt"
               placeholder="Descreva o que deseja achar…"
               class="flex-1 bg-transparent border border-[#14ba88]/40 rounded-xl px-4 py-3 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-[#14ba88] transition outline-none"
               value="{{ request('prompt') }}">

        <button type="submit"
                class="px-8 py-3 bg-[#14ba88] text-black font-bold uppercase rounded-xl tracking-wider hover:bg-[#0f8d6a] transition-all duration-300">
            Buscar
        </button>
    </form>

    <!-- Resultados -->
    <section class="w-full max-w-7xl mt-16">

        <h2 class="text-xl sm:text-2xl text-gray-300 mb-8 text-center">
            Resultados para:
            <span class="text-[#14ba88] font-semibold">"{{ $prompt }}"</span>
        </h2>

        @if($produtos->isEmpty())
            <p class="text-gray-500 text-lg text-center py-20 border-t border-gray-800 mt-10">
                Nenhum produto encontrado.
            </p>
        @else

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">

                @foreach($produtos as $produto)
                    <div class="glass rounded-2xl overflow-hidden transition-all duration-500 group relative hover:scale-[1.03]">

                        <!-- Imagem -->
                        <div class="relative w-full h-56 overflow-hidden">
                            @if($loop->index % 3 == 0)
                                <span class="absolute top-3 left-3 bg-[#14ba88] text-black text-xs font-bold uppercase px-3 py-1 rounded-full z-10">
                                    Novo
                                </span>
                            @endif

                            <img src="{{ asset('storage/' . json_decode($produto->fotos)[0] ?? $produto->estoque_imagem) }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700"
                                 alt="{{ $produto->nome }}">
                        </div>

                        <!-- Conteúdo -->
                        <div class="p-5 flex flex-col">

                            <p class="text-xs uppercase tracking-wider text-gray-400 mb-1">
                                {{ $produto->marca ?? 'Adidas' }}
                            </p>

                            <h3 class="text-lg font-bold text-white mb-2 truncate uppercase">
                                {{ $produto->nome }}
                            </h3>

                            <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                                {{ $produto->rotulo_categoria ?? $produto->categoria }} — {{ $produto->estilo ?? 'Performance' }}
                            </p>

                            <div class="flex items-center justify-between mt-auto">
                                <span class="text-2xl font-extrabold text-[#14ba88]">
                                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                </span>

                                <a href="#"
                                   class="px-5 py-2 bg-[#14ba88] text-black font-bold rounded-lg uppercase text-sm hover:bg-[#0f8d6a] transition-all">
                                    Comprar
                                </a>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>

        @endif
    </section>

    <footer class="mt-20 pt-8 border-t border-gray-800 text-center text-sm text-gray-600">
        © 2025 Hydrax IA • Sistema Inteligente Sura Experience
    </footer>

</body>
</html>
