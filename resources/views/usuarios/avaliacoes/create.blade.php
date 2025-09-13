<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilo das estrelas */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
            gap: 0.5rem;
            font-size: 2rem;
        }

        .star {
            cursor: pointer;
            color: #444; /* cor das estrelas apagadas */
            transition: color 0.2s;
        }

        .star.selected,
        .star.hovered {
            color: #14ba88; /* cor VIP verde */
        }
    </style>
</head>
<body class="bg-[#111] text-gray-100 font-sans min-h-screen flex items-center justify-center">

<div class="bg-[#0b282a] p-8 rounded-2xl shadow-lg border border-[#14ba88]/30 w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6 text-[#14ba88] text-center">Avaliar Produto</h1>

    <form action="{{ route('avaliacoes.store', $id_produto) }}" method="POST" class="space-y-4">
        @csrf

        <!-- Estrelas -->
        <div>
            <label class="block text-gray-300 mb-2">Nota:</label>
            <div class="star-rating">
                <span class="star" data-value="5">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="1">&#9733;</span>
            </div>
            <input type="hidden" name="nota" id="nota" value="">
        </div>

        <!-- Comentário -->
        <div>
            <label class="block text-gray-300 mb-2">Comentário (opcional):</label>
            <textarea name="comentario" class="border w-full p-3 rounded text-black bg-gray-100 placeholder-gray-500" placeholder="Escreva um comentário" rows="4"></textarea>
        </div>

        <!-- Botão -->
        <div class="text-center">
            <button type="submit" class="bg-[#14ba88] text-black px-6 py-2 rounded-xl hover:bg-[#0fae7a] transition font-semibold">
                Enviar Avaliação
            </button>
        </div>
    </form>
</div>

<script>
    const stars = document.querySelectorAll('.star');
    const notaInput = document.getElementById('nota');
    let selected = 0;

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            stars.forEach(s => s.classList.remove('hovered'));
            star.classList.add('hovered');
            let val = parseInt(star.getAttribute('data-value'));
            stars.forEach(s => {
                if(parseInt(s.getAttribute('data-value')) <= val) s.classList.add('hovered');
            });
        });

        star.addEventListener('mouseout', () => {
            stars.forEach(s => s.classList.remove('hovered'));
            stars.forEach(s => {
                if(parseInt(s.getAttribute('data-value')) <= selected) s.classList.add('selected');
            });
        });

        star.addEventListener('click', () => {
            selected = parseInt(star.getAttribute('data-value'));
            notaInput.value = selected;
            stars.forEach(s => s.classList.remove('selected'));
            stars.forEach(s => {
                if(parseInt(s.getAttribute('data-value')) <= selected) s.classList.add('selected');
            });
        });
    });
</script>
</body>
</html>
