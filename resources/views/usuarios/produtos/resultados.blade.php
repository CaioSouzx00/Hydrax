<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydrax IA - Busca de Produtos Adidas</title>

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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: radial-gradient(circle at top left, #0d1117, #000);
            color: #e0e0e0;
            font-family: 'Poppins', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .scan-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, #888, transparent);
            animation: scan 3s linear infinite;
            opacity: 0.2;
        }

        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-start py-10 px-6">

    <div class="relative w-full max-w-7xl">
        <div class="scan-line"></div>
    </div>

    <header class="text-center mb-12">
        <h1 class="text-5xl font-extrabold tracking-[0.15em] text-white uppercase">
            Hydrax<span class="text-gray-400">IA</span>
        </h1>
        <p class="text-gray-400 mt-2 text-lg tracking-widest uppercase">
            Busca inteligente de produtos <span class="text-gray-300 font-semibold">Adidas</span>
        </p>
    </header>

    <form 
        action="{{ route('usuario.ia') }}" 
        method="GET" 
        class="w-full max-w-3xl mx-auto flex flex-col sm:flex-row items-center gap-4 glass rounded-2xl px-6 py-5 shadow-lg transition hover:shadow-gray-700/30"
    >
        <input 
            type="text" 
            name="prompt" 
            placeholder="Digite o que deseja buscar (ex: tênis, jaqueta, coleção...)"
            class="flex-1 bg-transparent border-none focus:ring-0 text-lg text-gray-200 placeholder-gray-500 outline-none"
            value="{{ request('prompt') }}"
        >
        <button 
            type="submit"
            class="px-8 py-3 bg-gray-200 text-black font-bold uppercase rounded-xl tracking-wider hover:bg-white hover:scale-105 transition-all duration-300"
        >
            Buscar
        </button>
    </form>

    <section class="w-full max-w-7xl mt-14">
        <h2 class="text-xl sm:text-2xl text-gray-300 mb-8 text-center">
            Resultados para: 
            <span class="text-gray-100 font-semibold">"{{ $prompt }}"</span>
        </h2>

        @if($produtos->isEmpty())
            <p class="text-gray-500 text-lg text-center py-20 border-t border-gray-800 mt-10">
                Nenhum produto encontrado. <span class="text-gray-400">Tente outra busca.</span> 🤖
            </p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($produtos as $produto)
                    <div class="glass rounded-2xl overflow-hidden shadow-xl hover:shadow-gray-600/40 transition-all duration-500 group relative">
                        <div class="relative w-full h-56 overflow-hidden">
                            @if($loop->index % 3 == 0)
                                <span class="absolute top-3 left-3 bg-gray-200 text-black text-xs font-bold uppercase px-3 py-1 rounded-full z-10">Novo</span>
                            @endif

                            <img 
                                src="{{ asset('storage/' . json_decode($produto->fotos)[0] ?? $produto->estoque_imagem) }}" 
                                alt="{{ $produto->nome }}" 
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-all duration-700"
                            >
                        </div>

                        <div class="p-5 flex flex-col">
                            <p class="text-xs uppercase tracking-wider text-gray-400 mb-1">
                                {{ $produto->marca ?? 'Adidas' }}
                            </p>

                            <h3 class="text-lg font-bold text-white mb-2 truncate uppercase">
                                {{ $produto->nome }}
                            </h3>

                            <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                                {{ $produto->rotulo_categoria ?? $produto->categoria }} - {{ $produto->estilo ?? 'Performance' }}
                            </p>

                            <div class="flex items-center justify-between mt-auto">
                                <span class="text-2xl font-extrabold text-white">
                                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                </span>
                                <a 
                                    href="#"
                                    class="px-5 py-2 bg-gray-300 text-black font-bold rounded-lg uppercase text-sm hover:bg-white hover:scale-105 transition-all duration-300"
                                >
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
        <p>© 2025 Hydrax IA | Interface Inteligente Adidas Experience</p>
    </footer>

</body>
</html>
