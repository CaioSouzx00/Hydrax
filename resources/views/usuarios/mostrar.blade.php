<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fornecedor - {{ $fornecedor->nome_empresa }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-white">

    <div class="max-w-7xl mx-auto p-6 pt-24">
        <div class="bg-white/10 rounded-2xl p-6 shadow-xl mb-8 flex flex-col md:flex-row justify-between items-center text-center md:text-left border border-[#d5891b]/30">
            <div class="mb-4 md:mb-0">
                <h1 class="text-4xl font-bold text-[#e29b37]">{{ $fornecedor->nome_empresa }}</h1>
                <p class="mt-2 text-gray-300 max-w-2xl mx-auto md:mx-0">
                    {{ $fornecedor->historia ?? 'Sem descrição disponível.' }}
                </p>
            </div>
            <div class="text-right">
    <div class="flex items-center space-x-[1px]">
        @php
            $notaMediaFornecedor = $mediaAvaliacoes ?? 0;
        @endphp

        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= floor($notaMediaFornecedor))
                <span class="text-[#14ba88]">&#9733;</span>
            @elseif ($i - 0.5 <= $notaMediaFornecedor)
                <span class="text-[#14ba88] opacity-50">&#9733;</span>
            @else
                <span class="text-gray-600">&#9733;</span>
            @endif
        @endfor
    </div>
    @if($totalAvaliacoes > 0)
        <span class="text-xs text-gray-400">
            ({{ $totalAvaliacoes }} avaliações)
        </span>
    @endif

    <p class="text-sm text-gray-400">{{ $totalProdutos ?? 0 }} produtos</p>
    <p class="text-sm text-gray-400">{{ $totalVendidos ?? 0 }} vendidos</p>
</div>

                <p class="text-sm text-gray-400">{{ $totalProdutos ?? 0 }} produtos</p>
                <p class="text-sm text-gray-400">{{ $totalVendidos ?? 0 }} vendidos</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6">
        <h2 class="relative text-2xl font-bold w-fit 
                   after:content-[''] after:block after:absolute after:left-0 after:right-0 after:bottom-0 
                   after:border-b after:border-[#d5891b]/80">
            CATÁLOGO DE PRODUTOS
        </h2>
    </div>

    <!-- Container para produtos -->
    <div id="produtos-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 justify-center gap-8 mt-12 px-6 md:px-36 transition-all duration-300">
    @foreach($produtos as $produto)
        @include('usuarios.partials.card-produto', ['produto' => $produto, 'idsDesejados' => $idsDesejados])
    @endforeach
</div>


    <!-- Container para paginação -->
    <div class="mt-8">
    {{ $produtos->links() }}
</div>


    <!-- JS para carregar produtos via AJAX -->
    <script>
        document.addEventListener('click', function(e) {
            if(e.target.closest('.pagination a')) {
                e.preventDefault();
                let url = e.target.closest('a').href;
                carregarProdutos(url);
            }
        });

        function carregarProdutos(url) {
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('produtos-container').innerHTML = data.html;
                    document.getElementById('paginacao-container').innerHTML = data.pagination;
                });
        }
    </script>

</body>
</html>
