<!DOCTYPE html>
<html lang="pt-br" x-data="{ modalOpen: false, produto: {} }" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
    <title>Produtos - {{ $fornecedor->nome_empresa }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        /* Necessário para o line-clamp */
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] text-white min-h-screen p-6 text-white min-h-screen p-6">

    <!-- Botão voltar redondo -->
    <a href="{{ route('admin.fornecedores') }}"
       class="inline-flex items-center justify-center w-10 h-10 rounded-full 
              bg-gray-700 text-white hover:bg-gray-600 transition-colors duration-300 mb-6">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </a>

    <!-- Título -->
    <h1 class="text-2xl font-bold mb-8">
        <div class="pl-5">
        <span class="text-gray-300 border-b border-gray-600/80 w-fit">Produtos de {{ $fornecedor->nome_empresa }}</span>
        </div>    
    </h1>

    <!-- Produtos -->
    @if($produtos->count() > 0)
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
            @foreach($produtos as $produto)
                @php
                    $fotos = json_decode($produto->fotos ?? '[]', true);
                    $foto = $fotos[0] ?? null;
                @endphp

                <div 
                    class="bg-[#1a1a1a]/50 border border-gray-700 rounded-xl shadow-lg overflow-hidden flex flex-col cursor-pointer transition hover:border-gray-400/40 hover:shadow-gray-500/20"
                    @click="modalOpen = true; produto = {
                        nome: '{{ $produto->nome }}',
                        preco: '{{ number_format($produto->preco, 2, ',', '.') }}',
                        caracteristica: '{{ $produto->caracteristica_produto }}',
                        descricao: '{{ $produto->descricao }}',
                        historia: '{{ $produto->historia }}',
                        ativo: '{{ $produto->ativo ? 'Ativo' : 'Inativo' }}',
                        foto: '{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/400' }}'
                    }"
                >
                    
                    <!-- Imagem -->
                    <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/150' }}" 
                         alt="Imagem do produto"
                         class="w-full h-48 object-cover">

                    <!-- Conteúdo -->
                    <div class="p-5 flex flex-col flex-1">
                        <h2 class="font-semibold text-lg mb-2">{{ $produto->nome }}</h2>
                        
                        <p class="text-gray-400 text-sm">Preço: 
                            <span class="text-white font-medium">
                                R$ {{ number_format($produto->preco, 2, ',', '.') }}
                            </span>
                        </p>

                        <p class="text-gray-400 text-sm mb-2">Descrição: 
                            <span class="text-white line-clamp-2">{{ $produto->descricao }}</span>
                        </p>

                        <!-- Status -->
                        <span class="mt-auto text-sm font-semibold {{ $produto->ativo ? 'text-green-300' : 'text-red-400' }}">
                            {{ $produto->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-10">
    <svg class="w-12 h-12 text-gray-500 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-6 9 6v12a1 1 0 01-1 1H4a1 1 0 01-1-1V9z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10" />
    </svg>
    <p class="text-gray-400 text-center text-lg">
        Nenhum produto cadastrado para este fornecedor.<br>
        Produtos adicionados por {{ $fornecedor->nome_empresa }} aparecerão aqui.
    </p>
</div>

    @endif


    <!-- Modal -->
<div x-show="modalOpen" 
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4"
     x-transition>
    <div class="bg-[#1a1a1a]/80 rounded-xl shadow-lg max-w-4xl w-full overflow-hidden relative">
        
        <!-- Botão fechar -->
        <button @click="modalOpen = false" 
                class="absolute top-3 right-3 text-gray-400 hover:text-white text-2xl">&times;</button>
        
        <div class="flex flex-col md:flex-row">
            <!-- Imagem -->
            <div class="md:w-1/2 h-[500px] bg-[#1a1a1a]/70 flex items-center justify-center">
                <img :src="produto.foto" 
                     alt="Imagem do produto" 
                     class="w-96 h-96 rounded-lg object-contain">
            </div>
            
            <!-- Conteúdo -->
            <div class="p-6 pt-16 md:w-1/2 flex flex-col">
                <h2 class="font-bold text-xl mb-3" x-text="produto.nome"></h2>
                
                <p class="text-gray-400 text-sm">Preço: 
                    <span class="text-white font-medium" x-text="'R$ ' + produto.preco"></span>
                </p>

                <p class="text-gray-400 text-sm mt-2">Descrição:</p>
                <p class="text-white text-sm mb-2" x-text="produto.descricao"></p>

                <span class="text-sm font-semibold" 
                      :class="produto.ativo === 'Ativo' ? 'text-green-300' : 'text-red-400'"
                      x-text="produto.ativo"></span>
            </div>
        </div>
    </div>
</div>



</body>
</html>
