<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto - {{ $produto->nome }}</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0911] text-white min-h-screen flex flex-col items-center p-6">

@php
    $fotos = json_decode($produto->fotos, true) ?: [];
    $tamanhos = json_decode($produto->tamanhos_disponiveis, true) ?: [];
    $estoqueImagens = json_decode($produto->estoque_imagem, true) ?: [];
@endphp

<div class="max-w-6xl w-full bg-[#0f0b13]/70 backdrop-blur-xl rounded-2xl shadow-xl border border-[#D5891B]/30 p-6 fade-in">
    
    <!-- Botão Voltar -->

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
        <!-- Imagem Principal e Carrossel -->
        <div class="flex flex-col gap-4">
            <img src="{{ $fotos[0] ?? 'https://via.placeholder.com/500x500?text=Produto' }}" 
                 alt="Imagem principal do produto"
                 class="main-image w-full h-[400px] object-cover rounded-xl shadow-lg border border-[#D5891B]/20">

            @if(count($fotos) > 1)
            <div class="flex gap-2 overflow-x-auto mt-2">
                @foreach($fotos as $index => $foto)
                    @if($index != 0)
                    <img src="{{ asset('storage/' . $foto) }}" 
                         class="w-24 h-24 object-cover rounded shadow cursor-pointer hover:opacity-80 transition"
                         onclick="document.querySelector('.main-image').src=this.src">
                    @endif
                @endforeach
            </div>
            @endif
        </div>

        <!-- Detalhes -->
        <div class="flex flex-col gap-3">
            <h1 class="text-3xl font-bold text-[#D5891B]">{{ $produto->nome }}</h1>
            <p class="text-2xl font-semibold text-white mt-2">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>

            <div class="mt-4 space-y-2 text-gray-300">
                <p><strong>Descrição:</strong> {{ $produto->descricao }}</p>
                <p><strong>Características:</strong> {{ $produto->caracteristica_produto }}</p>
                <p><strong>História:</strong> {{ $produto->historia }}</p>
                <p><strong>Gênero:</strong> {{ $produto->genero }}</p>
                <p><strong>Categoria:</strong> {{ $produto->categoria }}</p>
                <p><strong>Tamanhos Disponíveis:</strong> {{ count($tamanhos) ? implode(', ', $tamanhos) : 'Nenhum tamanho disponível' }}</p>
            </div>

            <!-- Carrossel de estoque -->
            @if(count($estoqueImagens))
            <div class="mt-6">
                <h3 class="text-[#D5891B] font-semibold mb-2">Imagens do Estoque</h3>
                <div class="relative w-full max-w-md mx-auto">
                    <div id="carrosselEstoque" class="overflow-hidden rounded-xl shadow-md border border-[#D5891B]/30">
                        @foreach($estoqueImagens as $index => $img)
                        <img src="{{ asset('storage/' . $img) }}"
                             alt="Imagem estoque {{ $index + 1 }}"
                             class="w-full h-64 object-cover transition-opacity duration-500 {{ $index === 0 ? 'block' : 'hidden' }}"
                             data-index="{{ $index }}">
                        @endforeach
                    </div>

                    <button onclick="mudarImagem(-1)"
                            class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-[#D5891B]/80 hover:bg-[#b07317] text-white rounded-full p-2 transition">‹</button>
                    <button onclick="mudarImagem(1)"
                            class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-[#D5891B]/80 hover:bg-[#b07317] text-white rounded-full p-2 transition">›</button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    let imgAtual = 0;
    const imagens = document.querySelectorAll('#carrosselEstoque img');

    function mudarImagem(direcao) {
        imagens[imgAtual].classList.add('hidden');
        imagens[imgAtual].classList.remove('block');

        imgAtual += direcao;
        if (imgAtual < 0) imgAtual = imagens.length - 1;
        if (imgAtual >= imagens.length) imgAtual = 0;

        imagens[imgAtual].classList.remove('hidden');
        imagens[imgAtual].classList.add('block');
    }
</script>

<style>
.fade-in {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
</style>

</body>
</html>
