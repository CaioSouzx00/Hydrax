@php
    $fotos = json_decode($produto->fotos ?? '[]', true);
    $estoqueImagens = json_decode($produto->estoque_imagem ?? '[]', true);
    $tamanhos = json_decode($produto->tamanhos_disponiveis ?? '[]', true);
@endphp

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $produto->nome }} - Detalhes</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

<div class="mb-6">
    <a href="{{ route('dashboard') }}" 
       class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded transition">
        ← Voltar para o Dashboard
    </a>
</div>

<div class="max-w-7xl mx-auto p-6">

    <!-- Grid principal: imagens + informações -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Galeria de Imagens -->
        <div>
            <img src="{{ asset('storage/' . ($fotos[0] ?? 'sem-imagem.png')) }}"
                 class="w-full h-[400px] object-cover rounded-lg border shadow main-image">

            @if(count($fotos) > 1)
            <div class="flex gap-3 mt-3">
                @foreach(array_slice($fotos, 1) as $foto)
                    <img src="{{ asset('storage/' . $foto) }}"
                         class="w-20 h-20 rounded-md border cursor-pointer hover:opacity-80"
                         onclick="document.querySelector('.main-image').src=this.src">
                @endforeach
            </div>
            @endif
        </div>

        <!-- Informações do Produto -->
        <div class="flex flex-col gap-4">
            <h1 class="text-3xl font-bold">{{ $produto->nome }}</h1>

            <div class="flex items-center gap-2 text-yellow-500">
                ★★★★☆ <span class="text-gray-600 text-sm">(89 avaliações)</span>
            </div>

            <div class="flex flex-col">
                <span class="text-2xl font-semibold text-green-600">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                <span class="text-sm line-through text-gray-500">R$ {{ number_format($produto->preco * 1.2, 2, ',', '.') }}</span>
                <span class="text-sm text-green-700">22% OFF</span>
            </div>

            <p class="text-gray-700">{{ $produto->descricao }}</p>

            @if(count($estoqueImagens))
            <div>
                <h3 class="font-medium mb-2">Cores disponíveis</h3>
                <div class="flex gap-3">
                    @foreach($estoqueImagens as $img)
                        <img src="{{ asset('storage/' . $img) }}"
                             class="w-16 h-16 rounded-md border cursor-pointer hover:opacity-80 transition"
                             onclick="document.querySelector('.main-image').src=this.src">
                    @endforeach
                </div>
            </div>
            @endif

            @if(count($tamanhos))
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach($tamanhos as $tamanho)
                    <button type="button" 
                            class="tamanho-btn-produto px-4 py-2 border rounded-md hover:bg-gray-200"
                            data-tamanho="{{ $tamanho }}">
                        {{ $tamanho }}
                    </button>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 mt-2">Nenhum tamanho disponível</p>
            @endif

            <form action="{{ route('carrinho.adicionar', $produto->id_produtos) }}" method="POST" class="mt-4" id="form-carrinho-principal">
                @csrf
                <input type="hidden" name="tamanho" id="tamanhoSelecionadoPrincipal">

                <button type="submit" class="w-full bg-black hover:bg-gray-800 text-white font-bold py-3 px-4 rounded-lg text-lg transition">
                    Adicionar ao carrinho
                </button>

                <p id="erroTamanhoPrincipal" class="text-red-600 mt-2 hidden">Por favor, selecione um tamanho antes de adicionar ao carrinho.</p>
            </form>
        </div>
    </div>

<!-- Produtos recomendados -->
@if(isset($produtos) && $produtos->isNotEmpty())
<div class="mt-12">
    <h2 class="text-2xl font-bold mb-6">Você também pode gostar</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($produtos as $prod)
            @php
                $fotosRec = json_decode($prod->fotos ?? '[]', true);
                $estoqueRec = json_decode($prod->estoque_imagem ?? '[]', true);
                $tamanhosRec = json_decode($prod->tamanhos_disponiveis ?? '[]', true);
            @endphp

            <div class="bg-white rounded-xl shadow p-4 flex flex-col hover:shadow-lg transition">
                
                <!-- Imagem e nome clicáveis -->
                <a href="{{ route('produtos.detalhes', $prod->id_produtos) }}" class="block mb-3">
                    <img src="{{ asset('storage/' . ($fotosRec[0] ?? 'sem-imagem.png')) }}" class="w-full h-48 object-cover rounded mb-2">
                    <h3 class="font-semibold text-lg">{{ $prod->nome }}</h3>
                </a>

                <!-- Miniaturas de cores -->
                @if(count($estoqueRec))
                <div class="flex gap-2 mb-2">
                    @foreach($estoqueRec as $img)
                        <img src="{{ asset('storage/' . $img) }}" class="w-10 h-10 rounded border cursor-pointer hover:opacity-80"
                             onclick="this.closest('div.flex.flex-col').querySelector('img').src=this.src">
                    @endforeach
                </div>
                @endif

                <!-- Avaliações -->
                <div class="flex items-center gap-2 text-yellow-500 mb-2">
                    ★★★★☆ <span class="text-gray-600 text-sm">(89 avaliações)</span>
                </div>

                <!-- Preço -->
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-green-600 font-bold">R$ {{ number_format($prod->preco,2,',','.') }}</span>
                    <span class="line-through text-gray-500 text-sm">R$ {{ number_format($prod->preco*1.2,2,',','.') }}</span>
                    <span class="text-green-700 text-sm">22% OFF</span>
                </div>

                <!-- Tamanhos -->
                @if(count($tamanhosRec))
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach($tamanhosRec as $tam)
                        <button type="button" class="tamanho-btn-rec px-3 py-1 border rounded text-sm hover:bg-gray-200" data-tamanho="{{ $tam }}">
                            {{ $tam }}
                        </button>
                    @endforeach
                </div>
                @else
                    <p class="text-gray-500 mb-3">Nenhum tamanho disponível</p>
                @endif

                <!-- Formulário de carrinho -->
                <form action="{{ route('carrinho.adicionar', $prod->id_produtos) }}" method="POST" class="relative form-carrinho-rec">
                    @csrf
                    <input type="hidden" name="tamanho" class="tamanhoSelecionado-rec">
                    <button type="submit" class="w-full bg-black text-white font-bold py-2 rounded hover:bg-gray-800 transition">
                        Adicionar ao carrinho
                    </button>
                    <p class="text-red-600 mt-2 hidden erroTamanho-rec">Por favor, selecione um tamanho antes de adicionar ao carrinho.</p>
                </form>

            </div>
        @endforeach
    </div>
</div>
@endif


    <!-- Fornecedor principal -->
    @if($produto->fornecedor)
    <div class="flex items-center gap-3 mt-6 p-4 border rounded-lg bg-white shadow">
        <img src="{{ $produto->fornecedor->foto ? asset('storage/' . $produto->fornecedor->foto) : asset('storage/sem-logo.png') }}" 
             alt="Logo {{ $produto->fornecedor->nome_empresa }}"
             class="w-14 h-14 rounded-full object-cover border">
        <div>
            <h3 class="font-semibold text-lg">{{ $produto->fornecedor->nome_empresa }}</h3>
            <p class="text-sm text-gray-500">Vendido por esta empresa</p>
        </div>
    </div>
    @endif
</div>

<script>
    // Produto principal
    const tamanhoBtnsPrincipal = document.querySelectorAll('.tamanho-btn-produto');
    const tamanhoInputPrincipal = document.getElementById('tamanhoSelecionadoPrincipal');
    const erroTamanhoPrincipal = document.getElementById('erroTamanhoPrincipal');

    tamanhoBtnsPrincipal.forEach(btn=>{
        btn.addEventListener('click', ()=>{
            tamanhoBtnsPrincipal.forEach(b=>b.classList.remove('bg-gray-200','border-black'));
            btn.classList.add('bg-gray-200','border-black');
            tamanhoInputPrincipal.value = btn.dataset.tamanho;
            erroTamanhoPrincipal.classList.add('hidden');
        });
    });

    document.getElementById('form-carrinho-principal').addEventListener('submit', function(e){
        if(!tamanhoInputPrincipal.value){
            e.preventDefault();
            erroTamanhoPrincipal.classList.remove('hidden');
        }
    });

    // Produtos recomendados
    document.querySelectorAll('.form-carrinho-rec').forEach(form=>{
        const card = form.closest('div.flex.flex-col');
        const tamanhoBtns = card.querySelectorAll('.tamanho-btn-rec');
        const tamanhoInput = card.querySelector('.tamanhoSelecionado-rec');
        const erro = card.querySelector('.erroTamanho-rec');

        tamanhoBtns.forEach(btn=>{
            btn.addEventListener('click', ()=>{
                tamanhoBtns.forEach(b=>b.classList.remove('bg-gray-200','border-black'));
                btn.classList.add('bg-gray-200','border-black');
                tamanhoInput.value = btn.dataset.tamanho;
                erro.classList.add('hidden');
            });
        });

        form.addEventListener('submit', function(e){
            if(!tamanhoInput.value && tamanhoBtns.length>0){
                e.preventDefault();
                erro.classList.remove('hidden');
            }
        });
    });
</script>

</body>
</html>
