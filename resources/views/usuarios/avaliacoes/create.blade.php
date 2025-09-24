<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
    <title>Avaliação</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilo para a barra de seleção */
        .rating-bar {
            width: 100%;
            height: 8px;
            background-color: #2d2d2d;
            border-radius: 9999px;
            position: relative;
            cursor: pointer;
        }

        .rating-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #d5891b, #e29b37);
            border-radius: 9999px;
            transition: width 0.2s ease-in-out;
        }

        .rating-bar-marker {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #17110d;
            border: 2px solid #e29b37;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            transition: left 0.2s ease-in-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-gray-100 font-sans min-h-screen flex items-center justify-center p-4">
<!-- Botão voltar -->
<a href="{{ url()->previous() }}"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#d5891b] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#b4751c]"
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
<div class="bg-[#1a1a22]/50 p-8 rounded-2xl shadow-lg border border-[#d5891b]/30 w-full max-w-lg">
    <h1 class="text-3xl font-bold mb-6 text-white text-center border-b border-[#d5891b]/80 ">Avaliar Produto</h1>
    <p class="text-sm text-gray-400 text-center mb-8">Por favor, classifique o produto nas categorias abaixo.</p>

    <form action="{{ route('avaliacoes.store', $id_produto) }}" method="POST" class="space-y-6">
        @csrf

        <!-- Estrelas -->
        <div>
            <label class="block text-gray-300 font-bold text-lg mb-2">Avaliação Geral:</label>
            <div class="flex justify-center text-4xl mb-2 space-x-2">
                <span class="star cursor-pointer text-gray-600" data-value="1">&#9733;</span>
                <span class="star cursor-pointer text-gray-600" data-value="2">&#9733;</span>
                <span class="star cursor-pointer text-gray-600" data-value="3">&#9733;</span>
                <span class="star cursor-pointer text-gray-600" data-value="4">&#9733;</span>
                <span class="star cursor-pointer text-gray-600" data-value="5">&#9733;</span>
            </div>
            <input type="hidden" name="nota" id="nota">
        </div>

        <!-- Barras de avaliação -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
            @foreach (['Conforto','Qualidade','Tamanho','Largura'] as $field)
            <div>
                <label class="block text-gray-300 mb-1">{{ $field }}</label>
                <div class="relative rating-bar" data-field="{{ strtolower($field) }}">
                    <div class="rating-bar-fill w-[0%]"></div>
                    <div class="rating-bar-marker left-[0%]"></div>
                </div>
                <div class="flex justify-between text-xs mt-1 text-gray-400">
                    @if($field == 'Conforto' || $field == 'Qualidade')
                        <span>Muito Ruim</span><span>Excelente</span>
                    @elseif($field == 'Tamanho')
                        <span>Muito Pequeno</span><span>Perfeito</span><span>Muito Grande</span>
                    @else
                        <span>Muito Pequeno</span><span>Perfeito</span><span>Muito Largo</span>
                    @endif
                </div>
                <input type="hidden" name="{{ strtolower($field) }}" class="rating-input" value="0">
            </div>
            @endforeach
        </div>
        
        <!-- Comentário -->
        <div class="mt-6">
            <label class="block text-gray-300 font-bold mb-2">Comentário (opcional):</label>
            <textarea name="comentario" class="ring-1 ring-[#e29b37]/30 w-full p-3 rounded bg-[#2d2d2d]/70 text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#d5891b]/70" placeholder="Escreva seu comentário aqui..." rows="4"></textarea>
        </div>

        <!-- Botão -->
        <div class="text-center">
            <button type="submit" class="relative inline-block rounded-full px-8 py-3 overflow-hidden group bg-[#d5891b] hover:bg-gradient-to-r hover:from-[#d5891b] hover:to-[#e29b37] text-black font-bold text-lg shadow-lg hover:ring-2 hover:ring-offset-2 hover:ring-[#d5891b] transition-all duration-300">
                <span aria-hidden="true"
                    class="pointer-events-none absolute right-0 top-1/2 -translate-y-1/2 w-10 h-36 transform translate-x-10 rotate-12 bg-white opacity-10 transition-transform duration-700 group-hover:-translate-x-40">
                </span>
                <span class="relative">Enviar Avaliação</span>
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');
    const notaInput = document.getElementById('nota');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = parseInt(star.getAttribute('data-value'));
            notaInput.value = value;
            stars.forEach(s => {
                if (parseInt(s.getAttribute('data-value')) <= value) {
                    s.classList.add('text-[#d5891b]');
                    s.classList.remove('text-gray-600');
                } else {
                    s.classList.remove('text-[#d5891b]');
                    s.classList.add('text-gray-600');
                }
            });
        });
    });

    const ratingBars = document.querySelectorAll('.rating-bar');
    ratingBars.forEach(bar => {
        bar.addEventListener('click', (event) => {
            const rect = bar.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const percentage = Math.max(0, Math.min(1, x / rect.width));
            const value = Math.round(percentage * 4) + 1;

            const fill = bar.querySelector('.rating-bar-fill');
            const marker = bar.querySelector('.rating-bar-marker');
            const input = document.querySelector(`input[name="${bar.getAttribute('data-field')}"]`);

            fill.style.width = `${percentage * 100}%`;
            marker.style.left = `${percentage * 100}%`;
            input.value = value;
        });
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
        let valid = true;
        if (!notaInput.value || notaInput.value == 0) valid = false;
        document.querySelectorAll('.rating-input').forEach(input => {
            if (!input.value || input.value == 0) valid = false;
        });

        if (!valid) {
            e.preventDefault();
            alert('Por favor, preencha todas as avaliações antes de enviar.');
        } else {
            setTimeout(() => history.back(), 900);
        }
    });
});
</script>

</body>
</html>
