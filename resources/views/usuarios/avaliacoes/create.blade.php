<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilo para a barra de seleção */
        .rating-bar {
            width: 100%;
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 9999px;
            position: relative;
            cursor: pointer;
        }

        .rating-bar-fill {
            height: 100%;
            background-color: #14ba88;
            border-radius: 9999px;
            transition: width 0.2s ease-in-out;
        }

        .rating-bar-marker {
            position: absolute;
            width: 8px;
            height: 8px;
            background-color: white;
            border: 2px solid #111;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            transition: left 0.2s ease-in-out;
        }
    </style>
</head>
<body class="bg-[#111] text-gray-100 font-sans min-h-screen flex items-center justify-center p-4">

<div class="bg-[#0b282a] p-8 rounded-2xl shadow-lg border border-[#14ba88]/30 w-full max-w-lg">
    <h1 class="text-3xl font-bold mb-6 text-[#14ba88] text-center">Avaliar Produto</h1>
    <p class="text-sm text-gray-400 text-center mb-8">Por favor, classifique o produto nas categorias abaixo.</p>

    <form action="{{ route('avaliacoes.store', $id_produto) }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-gray-300 font-bold text-lg mb-2">Avaliação Geral:</label>
            <div class="flex justify-center text-4xl mb-2 space-x-2">
                <span class="star cursor-pointer text-gray-400" data-value="1">&#9733;</span>
                <span class="star cursor-pointer text-gray-400" data-value="2">&#9733;</span>
                <span class="star cursor-pointer text-gray-400" data-value="3">&#9733;</span>
                <span class="star cursor-pointer text-gray-400" data-value="4">&#9733;</span>
                <span class="star cursor-pointer text-gray-400" data-value="5">&#9733;</span>
            </div>
            <input type="hidden" name="nota" id="nota">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
            <div>
                <label class="block text-gray-300 mb-1">Conforto</label>
                <div class="relative rating-bar" data-field="conforto">
                    <div class="rating-bar-fill w-[0%]"></div>
                    <div class="rating-bar-marker left-[0%]"></div>
                </div>
                <div class="flex justify-between text-xs mt-1 text-gray-400">
                    <span>Muito Ruim</span>
                    <span>Excelente</span>
                </div>
                <input type="hidden" name="conforto" class="rating-input" value="0">
            </div>

            <div>
                <label class="block text-gray-300 mb-1">Qualidade</label>
                <div class="relative rating-bar" data-field="qualidade">
                    <div class="rating-bar-fill w-[0%]"></div>
                    <div class="rating-bar-marker left-[0%]"></div>
                </div>
                <div class="flex justify-between text-xs mt-1 text-gray-400">
                    <span>Muito Ruim</span>
                    <span>Excelente</span>
                </div>
                <input type="hidden" name="qualidade" class="rating-input" value="0">
            </div>

            <div>
                <label class="block text-gray-300 mb-1">Tamanho</label>
                <div class="relative rating-bar" data-field="tamanho">
                    <div class="rating-bar-fill w-[0%]"></div>
                    <div class="rating-bar-marker left-[0%]"></div>
                </div>
                <div class="flex justify-between text-xs mt-1 text-gray-400">
                    <span>Muito Pequeno</span>
                    <span>Perfeito</span>
                    <span>Muito Grande</span>
                </div>
                <input type="hidden" name="tamanho" class="rating-input" value="0">
            </div>

            <div>
                <label class="block text-gray-300 mb-1">Largura</label>
                <div class="relative rating-bar" data-field="largura">
                    <div class="rating-bar-fill w-[0%]"></div>
                    <div class="rating-bar-marker left-[0%]"></div>
                </div>
                <div class="flex justify-between text-xs mt-1 text-gray-400">
                    <span>Muito Pequeno</span>
                    <span>Perfeito</span>
                    <span>Muito Largo</span>
                </div>
                <input type="hidden" name="largura" class="rating-input" value="0">
            </div>
        </div>
        
        <div class="mt-6">
            <label class="block text-gray-300 font-bold mb-2">Comentário (opcional):</label>
            <textarea name="comentario" class="border w-full p-3 rounded text-black bg-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#14ba88]" placeholder="Escreva seu comentário aqui..." rows="4"></textarea>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-[#14ba88] text-black px-8 py-3 rounded-full hover:bg-[#0fae7a] transition font-bold text-lg shadow-lg">
                Enviar Avaliação
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
                    s.classList.add('text-[#14ba88]');
                    s.classList.remove('text-gray-400');
                } else {
                    s.classList.remove('text-[#14ba88]');
                    s.classList.add('text-gray-400');
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
            const value = Math.round(percentage * 4) + 1; // 1 a 5

            const fill = bar.querySelector('.rating-bar-fill');
            const marker = bar.querySelector('.rating-bar-marker');
            const input = document.querySelector(`input[name="${bar.getAttribute('data-field')}"]`);

            fill.style.width = `${percentage * 100}%`;
            marker.style.left = `${percentage * 100}%`;
            input.value = value;
        });
    });

    // Validação antes do envio
    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
        let valid = true;

        // Verifica avaliação geral
        if (!notaInput.value || notaInput.value == 0) valid = false;

        // Verifica cada barra de avaliação
        document.querySelectorAll('.rating-input').forEach(input => {
            if (!input.value || input.value == 0) valid = false;
        });

        if (!valid) {
            e.preventDefault(); // Bloqueia envio
            alert('Por favor, preencha todas as avaliações antes de enviar.');
        }
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');
    const notaInput = document.getElementById('nota');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = parseInt(star.getAttribute('data-value'));
            notaInput.value = value;
            stars.forEach(s => {
                if (parseInt(s.getAttribute('data-value')) <= value) {
                    s.classList.add('text-[#14ba88]');
                    s.classList.remove('text-gray-400');
                } else {
                    s.classList.remove('text-[#14ba88]');
                    s.classList.add('text-gray-400');
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
            // Quando o formulário for enviado com sucesso, volta para a página anterior
            setTimeout(() => {
                history.back();
            }, 900); // timeout pequeno para garantir que o envio ocorreu
        }
    });
});



</script>

</body>
</html>