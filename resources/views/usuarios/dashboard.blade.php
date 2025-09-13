<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/imagens/hydrax/hydrax-perfil.png" type="image/png" />
  <title>Hydrax</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    #overlay {
      position: fixed;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.5);
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
      z-index: 40;
    }

    #overlay.active {
      opacity: 0.5;
      pointer-events: auto;
    }

    /* Estilo para dropdown da busca */
    #resultado_busca {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      max-height: 15rem;
      overflow-y: auto;
      z-index: 50;
      background-color: white;
      border-radius: 0.375rem; /* rounded */
      box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1),
                  0 4px 6px -4px rgb(0 0 0 / 0.1);
    }

    #resultado_busca li {
      padding: 0.5rem 1rem;
      cursor: pointer;
      color: black;
    }

    #resultado_busca li:hover {
      background-color: #e5e7eb; /* Tailwind gray-200 */
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-white">

  <!-- Navbar -->
  <header class="fixed top-0 left-0 w-full z-50 backdrop-blur-md bg-gradient-to-br from-[#211828]/90 via-[#0b282a]/90 to-[#17110d]/90ss border-b border-[#7f3a0e] shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="/imagens/hydrax/HYDRA’x.png" alt="Hydrax Logo" class="h-14" />
      </div>

      <!-- Menu principal -->
      <nav class="hidden md:flex items-center gap-6 text-sm">

        <!-- Busca estilizada com campo funcional -->
        <div
          class="relative flex items-center bg-gray-200 rounded-xl px-3 py-1.5 text-black focus-within:ring-2 focus-within:ring-[#d5891b] w-44">
          <input 
            type="text" 
            id="buscar_produto"
            placeholder="Procurar"
            class="bg-transparent outline-none text-sm placeholder-gray-600 w-full"
            autocomplete="off"
            aria-label="Buscar produto"
          />
          <button id="botao_buscar" type="button" class="ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
            </svg>
          </button>
          <ul id="resultado_busca" role="listbox" aria-label="Resultados da busca"></ul>
        </div>

        @if (!Auth::guard('usuarios')->check())
        <!-- Links para visitante -->
        <a href="{{ route('usuarios.create') }}"
          class="relative rounded-2xl px-5 py-2.5 overflow-hidden group bg-[#14ba88] hover:bg-gradient-to-r hover:from-[#14ba88] hover:to-[#1ce0a5] hover:ring-2 hover:ring-offset-2 hover:ring-[#1ce0a5] transition-all ease-out duration-300">
          <span
            class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
          <span class="relative">Cadastrar</span>
        </a>

        <a href="{{ route('login.form') }}"
          class="relative inline-flex items-center justify-start px-5 py-2.5 font-bold rounded-2xl group overflow-hidden">
          <span
            class="w-32 h-32 rotate-45 translate-x-12 -translate-y-2 absolute left-0 top-0 bg-white opacity-[3%]"></span>
          <span
            class="absolute top-0 left-0 w-48 h-48 -mt-1 transition-all duration-500 ease-in-out rotate-45 -translate-x-56 -translate-y-24 bg-white opacity-100 group-hover:-translate-x-8"></span>
          <span class="relative w-full text-left text-white group-hover:text-gray-900">Entrar</span>
          <span class="absolute inset-0 border-2 border-white rounded-2xl"></span>
        </a>

        @else
        @csrf

        <!-- Usuário logado -->
        <div class="relative inline-block text-left" id="user-dropdown">
          <div id="user-name" class="flex items-center space-x-2">
            <div
              class="w-8 h-8 bg-[#d5891b] rounded-full flex items-center justify-center hover:bg-[#d5891b] transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
              </svg>
            </div>
            <span class="mr-4 cursor-pointer font-semibold hover:text-[#d5891b] transition-colors">
              Olá, {{ Auth::guard('usuarios')->user()->nome_completo }} ▾
            </span>
            @if ($errors->has('login_ja_autenticado'))
            <span class="text-sm text-yellow-300 ml-2">
              {{ $errors->first('login_ja_autenticado') }}
            </span>
            @endif

          </div>

          <!-- Menu logout -->
          <div id="logout-menu"
            class="absolute right-0 hidden bg-[#211828]/80 border border-[#7f3a0e] rounded-md shadow-lg mt-2 py-2 min-w-[140px] z-50">
            <a href="{{ route('usuario.painel') }}"
              class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-[#d5891b]/30  transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"
      stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.779.755 6.879 2.041M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
              <span>Perfil</span>
            </a>

            <form id="logoutForm" method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"
                class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-[#d5891b]/30  transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
                <span>Sair</span>
              </button>
            </form>
          </div>
        </div>

        @php $id = Auth::guard('usuarios')->id(); @endphp
        @endif

<!-- Carrinho -->
<a href="{{ route('carrinho.ver') }}" class="relative hover:text-gray-300 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24"
         stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13L17 13M7 13H5.4" />
    </svg>

    @php
    $carrinho = Auth::guard('usuarios')->check()
        ? Auth::guard('usuarios')->user()->carrinhoAtivo()->with('itens')->first()
        : null;

    $quantidade = $carrinho ? $carrinho->itens->sum('quantidade') : 0;
@endphp

@if($quantidade > 0)
    <span 
        class="absolute -top-2 -right-2 bg-black text-white rounded-full w-5 h-5 text-xs flex items-center justify-center animate-bounce-subtle shadow-lg">
        {{ $quantidade }}
    </span>
@endif

<style>
@keyframes bounce-subtle {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-3px); }
}
.animate-bounce-subtle {
  animation: bounce-subtle 1s infinite;
}
</style>

<!-- Lista de Desejos -->
<a href="{{ route('lista-desejos.index') }}" class="relative hover:text-gray-300 transition ml-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 
                 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 
                 4.5 0 00-6.364 0z" />
    </svg>

    @php
        $wishlistCount = Auth::guard('usuarios')->check()
            ? Auth::guard('usuarios')->user()->wishlist()->count()
            : 0;
    @endphp

    @if($wishlistCount > 0)
        <span class="absolute -top-2 -right-2 bg-black text-white rounded-full w-5 h-5 text-xs flex items-center justify-center animate-bounce-subtle shadow-lg">
            {{ $wishlistCount }}
        </span>
    @endif
</a>


</a>

<!-- Minhas Compras -->
<a href="{{ route('usuarios.pedidos') }}" class="relative hover:text-gray-300 transition ml-4">
    <svg xmlns="http://www.w3.org/2000/svg" 
         class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24"
         stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 7h18M3 7l1.5 12h15L21 7M16 11a4 4 0 11-8 0" />
    </svg>

    @php
        $pedidosCount = Auth::guard('usuarios')->check()
            ? Auth::guard('usuarios')->user()->carrinhos()->where('status', 'finalizado')->count()
            : 0;
    @endphp

    @if($pedidosCount > 0)
        <span 
            class="absolute -top-2 -right-2 bg-black text-white rounded-full w-5 h-5 text-xs flex items-center justify-center animate-bounce-subtle shadow-lg">
            {{ $pedidosCount }}
        </span>
    @endif
</a>

<style>
@keyframes bounce-subtle {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-3px); }
}
.animate-bounce-subtle {
  animation: bounce-subtle 1s infinite;
}
</style>


      </nav>
    </div>
  </header>

<main id="main-content" class="min-h-screen">

    <!-- Carrossel Full Width -->
    <div id="carousel" class="relative w-full pt-32 pb-12">
        <div class="overflow-hidden relative h-80">
            <div class="flex transition-transform duration-500" id="carousel-slides">
                <div class="flex-shrink-0 w-full h-80 bg-red-500 flex items-center justify-center text-white text-2xl">
                    <img src="/imagens/hydrax/NIKE.png" alt="Nike 1" class="h-full w-full object-cover">
                </div>
                <div class="flex-shrink-0 w-full h-80 bg-green-500 flex items-center justify-center text-white text-2xl">
                    <img src="/imagens/hydrax/NIKE (2).png" alt="Nike 1" class="h-full w-full object-cover">
                </div>
                <div class="flex-shrink-0 w-full h-80 bg-blue-500 flex items-center justify-center text-white text-2xl">
                    <img src="/imagens/hydrax/NIKE (1).png" alt="Nike 1" class="h-full w-full object-cover">
                </div>
            </div>

            <!-- Botões -->
            <div class="absolute inset-y-0 left-0 flex items-center">
                <button id="prev" class="bg-black/10 text-white/30 hover:bg-black/30 hover:text-white p-2 rounded-full mx-4">‹</button>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center">
                <button id="next" class="bg-black/10 text-white/30 hover:bg-black/30 hover:text-white p-2 rounded-full mx-4">›</button>
            </div>
        </div>

            <!-- Últimos Produtos -->
    <div class="container mt-16 mb-5">
        <hr class="border-t border-[#d5891b]/20 ml-44 my-12">
        <h2 class="text-2xl pl-12 font-bold">NOVOS NA HYDRAX</h2>
        <div id="ultimos-produtos-container" 
             class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-96 pr-10 scale-75
                    [&>div]:bg-white [&>div]:rounded-xl [&>div]:shadow
                    [&>div]:hover:shadow-lg [&>div]:transition 
                    [&>div]:overflow-hidden [&>div]:relative
                    [&>div]:flex [&>div]:flex-col">
            @forelse($ultimosProdutos ?? [] as $produto)
                @include('usuarios.partials.card-rec', ['produto' => $produto])
            @empty
                <p class="text-gray-400">Nenhum produto adicionado recentemente.</p>
            @endforelse
        </div>
    </div>

    <!-- Segundo Carrossel -->
    <div id="carousel-2" class="relative w-full pt-12 pb-12">
        <div class="overflow-hidden relative h-80">
            <div class="flex transition-transform duration-500" id="carousel-slides-2">
                    <img src="/imagens/hydrax/HYDRA’x (3).png" alt="Nike 1" class="h-full w-full pr-12 pl-12 object-cover">
            </div>

            <!-- Botões -->
            <div class="absolute inset-y-0 left-0 flex items-center">
                <button id="prev-2" class="bg-black/0 text-white/0 hover:bg-black/00 hover:text-white/0 p-2 rounded-full mx-4">‹</button>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center">
                <button id="next-2" class="bg-black/0 text-white/0 hover:bg-black/00 hover:text-white/0 p-2 rounded-full mx-4">›</button>
            </div>
        </div>
    </div>


        
    </div>
<h2 class="text-2xl pl-24 font-bold">PRODUTOS</h2>
    <style>
        body { overflow-x: hidden; }
    </style>

    <div class="flex relative">
<!-- Botão de filtros no fluxo normal -->
<div class="absolute top-0 right-12">
  <button id="toggle-filtros" 
          class="text-white hover:text-[#14BA88] px-4 py-2 rounded-md flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 14.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-2.586L3.293 6.707A1 1 0 013 6V4z" />
    </svg>
    Filtros
  </button>
</div>


        <!-- SIDEBAR DE FILTROS -->
        <form id="sidebar-filtros" method="GET" action="{{ route('dashboard') }}" 
            class="w-64 p-4 bg-black/30 backdrop-blur-md text-white border-r border-[#D5891B]/30 
                   absolute h-full z-40 transform -translate-x-full opacity-0 transition-all duration-500 ease-in-out">
            
            <h3 class="font-bold mb-2 text-[#B69F8F]">Gênero</h3>
            <label class="inline-block mb-1"><input type="radio" name="genero" value="MASCULINO"> Masculino</label><br>
            <label class="inline-block mb-1"><input type="radio" name="genero" value="FEMININO"> Feminino</label><br>
            <label class="inline-block mb-1"><input type="radio" name="genero" value="UNISSEX"> Unissex</label>

            <h3 class="font-bold mt-4 mb-2 text-[#B69F8F]">Categoria</h3>
            <select name="categoria" class="border border-[#D5891B]/50 p-1 w-full bg-black/30 text-white rounded backdrop-blur-sm">
                <option value="">Todas</option>
                <option value="Corrida">Corrida</option>
                <option value="Basquete">Basquete</option>
                <option value="Lifestyle">Lifestyle</option>
            </select>

            <h3 class="font-bold mt-4 mb-2 text-[#B69F8F]">Tamanho</h3>
            @foreach([37,38,39,40,41,42,43,44,45,46] as $t)
                <label class="inline-block mr-2 mb-2">
                    <input type="radio" name="tamanho" value="{{ $t }}"> {{ $t }}
                </label>
            @endforeach

            <h3 class="font-bold mt-4 mb-2 text-[#B69F8F]">Preço</h3>
            <input type="number" name="preco_min" placeholder="Mín" class="border border-[#D5891B]/50 p-1 w-20 bg-black/30 text-white rounded backdrop-blur-sm"> -
            <input type="number" name="preco_max" placeholder="Máx" class="border border-[#D5891B]/50 p-1 w-20 bg-black/30 text-white rounded backdrop-blur-sm">

            <button type="submit" class="mt-4 bg-[#D5891B]/50 hover:bg-[#e29b37] text-black font-bold px-4 py-2 w-full rounded transition-colors">
                Filtrar
            </button>
            <button type="button" id="limpar-filtros" class="mt-2 bg-gray-700 hover:bg-gray-600 text-white font-bold px-4 py-2 w-full rounded transition-colors">
                Limpar filtros
            </button>
        </form>

        <!-- Grid de produtos (3 colunas centralizadas) -->
        <div id="produtos-container"
             class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 justify-items-center gap-8 mt-12 pl-36 transition-all duration-300">
        </div>
    </div>

    <!-- Paginação e texto -->
    <div class="mt-12 text-center">
        <div id="paginacao-container" class="flex justify-center mb-2"></div>
        <div id="texto-container" class="text-gray-400 text-sm mb-10"></div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggle-filtros');
        const sidebar = document.getElementById('sidebar-filtros');
        const produtos = document.getElementById('produtos-container');

        let aberto = false;
        toggleBtn.addEventListener('click', () => {
            aberto = !aberto;

            if (aberto) {
                sidebar.classList.remove('-translate-x-full', 'opacity-0');
                sidebar.classList.add('translate-x-0', 'opacity-100');
                produtos.classList.add("ml-32", "mr-10");
            } else {
                sidebar.classList.remove('translate-x-0', 'opacity-100');
                sidebar.classList.add('-translate-x-full', 'opacity-0');
                produtos.classList.remove("ml-32", "mr-10");
            }
        });

        // CARROSSEL
        const slides = document.getElementById('carousel-slides');
        const totalSlides = slides.children.length;
        let index = 0;

        const showSlide = () => {
            slides.style.transform = `translateX(-${index * 100}%)`;
        }

        const nextSlide = () => {
            index = (index + 1) % totalSlides;
            showSlide();
        }

        const prevSlide = () => {
            index = (index - 1 + totalSlides) % totalSlides;
            showSlide();
        }

        document.getElementById('next').addEventListener('click', nextSlide);
        document.getElementById('prev').addEventListener('click', prevSlide);

        setInterval(nextSlide, 5000);
    </script>

    <style>
        /* Transição suave para os cards */
        #produtos-container div {
            transition: all 9s ease;
        }
    </style>

</main>
</main>

<!-- Container do modal -->
<div id="detalhes-produto-container"
     class="fixed inset-0 bg-black/70 z-50 hidden flex items-start justify-center overflow-y-auto pt-20 px-4">

  <!-- Conteúdo do modal -->
  <div id="detalhes-produto-conteudo" 
       class="bg-[#0f0b13]/70 backdrop-blur-xl rounded-2xl shadow-xl border border-[#D5891B]/30 max-w-4xl w-full p-6 text-white relative">
    <!-- Aqui entra o conteúdo do modal (seu div #detalhesProduto) -->
  </div>
</div>

</div>


  <div id="overlay"></div>

  <!-- Sidebar Mobile -->
  @if (!Auth::guard('usuarios')->check())
  <input type="checkbox" id="menu-toggle" class="hidden peer" />
  <label for="menu-toggle"
    class="fixed top-4 left-5 z-50 text-white text-2xl p-2 cursor-pointer peer-checked:hidden hover:text-[#a68e7b]">☰</label>
  <aside
    class="fixed top-0 left-0 h-full w-64 bg-gradient-to-br from-[#211828]/90 via-[#0b282a]/90 to-[#17110d]/90 backdrop-blur-md text-white z-50 transform -translate-x-full peer-checked:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl border-r border-[#d5891b]/30">
    <label for="menu-toggle"
      class="absolute top-4 right-4 text-white text-2xl cursor-pointer hover:text-[#a68e7b] transition">✕</label>
    <div class="mt-16 px-4 py-6">
      <div class="flex justify-center mb-6">
        <img src="/imagens/hydrax/HYDRAX - LOGO1.png" alt="Hydrax Logo" class="h-40 opacity-90 hover:opacity-100 transition" />
      </div>
      <hr class="border-[#d5891b]/40 mb-4" />
      <nav class="space-y-3 text-sm">
        <a href="{{ route('admin.login') }}"
          class="block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#2d4e50] transition shadow-md">Administrador</a>
        <a href="{{ route('fornecedores.login') }}"
          class="block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#2d4e50] transition shadow-md">Fornecedor</a>
      </nav>
      <hr class="border-[#d5891b]/40 mt-6" />
      <p class="text-xs text-center text-green-200 mt-6">
        &copy; 2025 <strong class="text-[#14ba88]">Hydrax</strong>
      </p>
    </div>
  </aside>
  @endif

        
@include('usuarios.partials.footer')


  <script>
  const overlay = document.getElementById('overlay');
  const userDropdown = document.getElementById('user-dropdown');
  const logoutMenu = document.getElementById('logout-menu');
  const enderecoWrapper = document.getElementById('enderecoWrapper');
  const enderecoDropdown = document.getElementById('enderecoDropdown');

  let userTimeout, enderecoTimeout;

  const formFiltros = document.getElementById('sidebar-filtros');

  if (formFiltros) {
    formFiltros.addEventListener('submit', function(e) {
        e.preventDefault(); // impede o reload da página
        carregarProdutos({ page: 1 }); // chama sua função AJAX
    });
}


  function showOverlay() {
    overlay.classList.add('active');
  }

  function hideOverlay() {
    overlay.classList.remove('active');
  }

  // Dropdown usuário
  if (userDropdown) {
    userDropdown.addEventListener('mouseenter', () => {
      clearTimeout(userTimeout);
      logoutMenu.classList.remove('hidden');
      showOverlay();
    });

    userDropdown.addEventListener('mouseleave', () => {
      userTimeout = setTimeout(() => {
        logoutMenu.classList.add('hidden');
        hideOverlay();
      }, 150);
    });
  }

  // Dropdown endereço
  if (enderecoWrapper && enderecoDropdown) {
    enderecoWrapper.addEventListener('mouseenter', () => {
      clearTimeout(enderecoTimeout);
      enderecoDropdown.classList.remove('hidden');
      showOverlay();
    });

    enderecoWrapper.addEventListener('mouseleave', () => {
      enderecoTimeout = setTimeout(() => {
        enderecoDropdown.classList.add('hidden');
        hideOverlay();
      }, 200);
    });
  }

  // Fechar dropdowns ao clicar no overlay
  if (overlay) {
    overlay.addEventListener('click', () => {
      if (logoutMenu) logoutMenu.classList.add('hidden');
      if (enderecoDropdown) enderecoDropdown.classList.add('hidden');
      hideOverlay();
    });
  }

  /*======================== Busca produtos ==========================*/

  const buscarUrl = @json(route('produtos.buscar'));
  const inputBuscar = document.getElementById('buscar_produto');
  const produtosContainer = document.getElementById('produtos-container');
  const paginacaoContainer = document.getElementById('paginacao-container');
  const textoContainer = document.getElementById('texto-container');

  let debounceTimeout;

  function carregarProdutos(params = {}) {
    const termo = inputBuscar.value.trim();
    const genero = document.querySelector('input[name="genero"]:checked')?.value || '';
    const categoria = document.querySelector('select[name="categoria"]')?.value || '';
    const tamanho = document.querySelector('input[name="tamanho"]:checked')?.value || '';
    const preco_min = document.querySelector('input[name="preco_min"]')?.value || '';
    const preco_max = document.querySelector('input[name="preco_max"]')?.value || '';

    const queryParams = new URLSearchParams({
      q: termo,
      genero,
      categoria,
      tamanho,
      preco_min,
      preco_max,
      page: params.page || 1
    });

    fetch(`${buscarUrl}?${queryParams.toString()}`)
      .then(res => res.json())
      .then(data => {
        produtosContainer.innerHTML = data.html;
        paginacaoContainer.innerHTML = data.pagination;
        textoContainer.innerHTML = data.texto;
      });
  }

  // Paginação AJAX com event delegation
  paginacaoContainer.addEventListener('click', function(e) {
    if(e.target.tagName === 'A') {
      e.preventDefault();
      const page = new URL(e.target.href).searchParams.get('page');
      carregarProdutos({ page });
    }

    const formFiltros = document.getElementById('sidebar-filtros');

  });

  // Busca com debounce
  function realizarBusca() {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
      carregarProdutos({ page: 1 }); // reset da página ao buscar
    }, 300);
  }

  if(inputBuscar) inputBuscar.addEventListener('input', realizarBusca);
  const botaoBuscar = document.getElementById('botao_buscar');
  if(botaoBuscar) botaoBuscar.addEventListener('click', () => carregarProdutos({ page: 1 }));

  const botaoLimpar = document.getElementById('limpar-filtros');

if (botaoLimpar) {
    botaoLimpar.addEventListener('click', () => {
        // Limpa todos os campos do form
        formFiltros.reset();

        // Recarrega os produtos sem filtros
        carregarProdutos({ page: 1 });
    });
}




    // CARROSSEL 2
    const slides2 = document.getElementById('carousel-slides-2');
    const totalSlides2 = slides2.children.length;
    let index2 = 0;

    const showSlide2 = () => {
        slides2.style.transform = `translateX(-${index2 * 100}%)`;
    }

    const nextSlide2 = () => {
        index2 = (index2 + 1) % totalSlides2;
        showSlide2();
    }

    const prevSlide2 = () => {
        index2 = (index2 - 1 + totalSlides2) % totalSlides2;
        showSlide2();
    }

    document.getElementById('next-2').addEventListener('click', nextSlide2);
    document.getElementById('prev-2').addEventListener('click', prevSlide2);

    setInterval(nextSlide2, 5000);



  // Carrega página inicial
  carregarProdutos();
</script>



</body>

</html>