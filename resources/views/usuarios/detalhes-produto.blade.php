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

<!-- Botão Voltar -->
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

            <!-- Avaliações -->
            <div class="flex items-center gap-2 text-yellow-500">
                ★★★★☆ <span class="text-gray-600 text-sm">(89 avaliações)</span>
            </div>

            <!-- Preço -->
            <div class="flex flex-col">
                <span class="text-2xl font-semibold text-green-600">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                <span class="text-sm line-through text-gray-500">R$ {{ number_format($produto->preco * 1.2, 2, ',', '.') }}</span>
                <span class="text-sm text-green-700">22% OFF</span>
            </div>

            <!-- Descrição -->
            <p class="text-gray-700">{{ $produto->descricao }}</p>

            <!-- Cores -->
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

            <!-- Tamanhos -->
            @if(count($tamanhos))
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach($tamanhos as $tamanho)
                    <button type="button" 
                            class="tamanho-btn px-4 py-2 border rounded-md hover:bg-gray-200"
                            data-tamanho="{{ $tamanho }}">
                        {{ $tamanho }}
                    </button>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 mt-2">Nenhum tamanho disponível</p>
            @endif

            <!-- Formulário de Carrinho -->
<form action="{{ route('carrinho.adicionar', $produto->id_produtos) }}" method="POST" class="mt-4" id="form-carrinho">
    @csrf
    <input type="hidden" name="tamanho" id="tamanhoSelecionado">

    <!-- Botão único -->
    <button type="submit" class="w-full bg-black hover:bg-gray-800 text-white font-bold py-3 px-4 rounded-lg text-lg transition">
        Adicionar ao carrinho
    </button>

    <p id="erroTamanho" class="text-red-600 mt-2 hidden">Por favor, selecione um tamanho antes de adicionar ao carrinho.</p>
</form>
        </div>
    </div>

    <!-- Fornecedor: abaixo da grid -->
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
    const tamanhoBtns = document.querySelectorAll('.tamanho-btn');
    const tamanhoInput = document.getElementById('tamanhoSelecionado');
    const erroTamanho = document.getElementById('erroTamanho');

    tamanhoBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tamanhoBtns.forEach(b => b.classList.remove('bg-gray-200', 'border-black'));
            btn.classList.add('bg-gray-200', 'border-black');

            tamanhoInput.value = btn.dataset.tamanho;
            erroTamanho.classList.add('hidden');
        });
    });

    document.getElementById('form-carrinho').addEventListener('submit', function(e){
        if(!tamanhoInput.value){
            e.preventDefault();
            erroTamanho.classList.remove('hidden');
        }
    });
</script>

</body>
</html>
