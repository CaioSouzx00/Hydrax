<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
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

  <!-- Navbar -->
  <header class="fixed top-0 left-0 w-full z-50 backdrop-blur-md bg-gradient-to-br from-[#211828]/90 via-[#0b282a]/90 to-[#17110d]/90 border-b border-[#7f3a0e] shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="/imagens/hydrax/HYDRA’x.png" alt="Hydrax Logo" class="h-14" />
      </div>
      <!-- Menu -->
      <nav class="hidden md:flex items-center gap-6 text-sm"></nav>
    </div>
  </header>

  <!-- Botão voltar -->
  <a href="javascript:history.back()"
   class="group fixed top-5 right-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#117c66]"
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

  <!-- Card do fornecedor -->
  <section class="max-w-7xl mx-auto px-6 mt-28">
    <div class="bg-black/30 rounded-2xl p-6 shadow-xl flex flex-col md:flex-row justify-between items-center text-center md:text-left border border-[#d5891b]/30">
        
        <!-- Foto do fornecedor -->
        <div class="flex flex-col items-center md:items-start mb-6 md:mb-0 md:mr-6">
            <img src="{{ $fornecedor->foto ? asset('storage/' . $fornecedor->foto) : asset('storage/sem-logo.png') }}" 
                 alt="Logo {{ $fornecedor->nome_empresa }}"
                 class="w-24 h-24 rounded-full object-cover border-2 border-[#d5891b]/60 shadow-md">
        </div>

        <!-- Informações principais -->
        <div class="flex-1">
            <h1 class="text-4xl font-bold text-[#e29b37]">{{ $fornecedor->nome_empresa }}</h1>
            <p class="mt-2 text-gray-300 max-w-2xl mx-auto md:mx-0">
                {{ $fornecedor->historia ?? 'Sem descrição disponível.' }}
            </p>
        </div>

        <!-- Estatísticas e avaliações -->
        <div class="text-right mt-6 md:mt-0">
                        @if($totalAvaliacoes > 0)
                <span class="text-xs text-gray-400 mb-2">
                    Avaliações({{ $totalAvaliacoes }})
                </span>
            @endif
            <div class="flex items-center space-x-[1px] justify-center md:justify-end">
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

            <p class="text-sm text-gray-400">{{ $totalProdutos ?? 0 }} produtos</p>
            <p class="text-sm text-gray-400">{{ $totalVendidos ?? 0 }} vendidos</p>
        </div>
    </div>
  </section>

  <!-- Catálogo -->
  <div class="max-w-7xl mx-auto px-6 mt-12">
    <h2 class="relative text-2xl font-bold w-fit 
               after:content-[''] after:block after:absolute after:left-0 after:right-0 after:bottom-0 
               after:border-b after:border-[#d5891b]/80">
        PRODUTOS DA EMPRESA
    </h2>
  </div>

<!-- Grid de produtos (1-2-3 colunas, centralizada) -->
<div id="produtos-container"
     class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 justify-items-center gap-8 mt-12 px-6 md:px-12 lg:px-36 transition-all duration-300">
    @foreach($produtos as $produto)
        @include('usuarios.partials.card-produto', ['produto' => $produto])
    @endforeach
</div>


  <!-- Paginação via AJAX -->
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
  <script>
document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('header');
    let lastScroll = 0;
    const delta = 5;
    let ticking = false;

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (Math.abs(scrollTop - lastScroll) > delta) {
                    if (scrollTop > lastScroll && scrollTop > 100) {
                        // Scroll para baixo: "desintegrar"
                        navbar.classList.add('disintegrate');
                        navbar.classList.remove('reappear');
                    } else {
                        // Scroll para cima: reaparecer
                        navbar.classList.add('reappear');
                        navbar.classList.remove('disintegrate');
                    }
                    lastScroll = scrollTop;
                }

                ticking = false;
            });
            ticking = true;
        }
    });
});
</script>

<style>
header {
    position: fixed;
    top: 0;
    width: 100%;
    background: #0b282a;
    color: white;
    z-index: 50;
    transition: transform 0.3s ease-in-out, opacity 0.6s ease, clip-path 0.6s ease;
}

/* efeito desintegrando */
.disintegrate {
    opacity: 0;
    transform: translateY(-50px);
    clip-path: polygon(0 0, 100% 0, 100% 70%, 0 100%);
}

/* reaparecer suavemente */
.reappear {
    opacity: 1;
    transform: translateY(0);
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
}
</style>
@include('usuarios.partials.footer')
</body>
</html>
