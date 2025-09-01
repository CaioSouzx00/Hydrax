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
  <header class="fixed top-0 left-0 w-full z-50 backdrop-blur-md bg-black/50 border-b border-[#7f3a0e] shadow-sm">
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
        <!-- Slides -->
        <div class="overflow-hidden relative h-80">
            <div class="flex transition-transform duration-500" id="carousel-slides">
                <div class="flex-shrink-0 w-full h-80 bg-red-500 flex items-center justify-center text-white text-2xl">
                    Slide 1
                </div>
                <div class="flex-shrink-0 w-full h-80 bg-green-500 flex items-center justify-center text-white text-2xl">
                    Slide 2
                </div>
                <div class="flex-shrink-0 w-full h-80 bg-blue-500 flex items-center justify-center text-white text-2xl">
                    Slide 3
                </div>
            </div>

            <!-- Botões alinhados verticalmente -->
            <div class="absolute inset-y-0 left-0 flex items-center">
                <button id="prev" class="bg-black/10 text-white/30 hover:bg-black/30 hover:text-white p-2 rounded-full mx-4">‹</button>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center">
                <button id="next" class="bg-black/10 text-white/30 hover:bg-black/30 hover:text-white p-2 rounded-full mx-4">›</button>
            </div>
        </div>
    </div>

    <!-- <div class="flex">
    <!-- SIDEBAR DE FILTROS --
    <form method="GET" action="{{ route('dashboard') }}" class="w-64 p-4 bg-gray-900 text-white border-r border-gray-700">
        <!-- Gênero --
        <h3 class="font-bold mb-2">Gênero</h3>
        <label><input type="radio" name="genero" value="MASCULINO"> Masculino</label><br>
        <label><input type="radio" name="genero" value="FEMININO"> Feminino</label><br>
        <label><input type="radio" name="genero" value="UNISSEX"> Unissex</label>

        <!-- Categoria --
        <h3 class="font-bold mt-4 mb-2">Categoria</h3>
        <select name="categoria" class="border p-1 w-full">
            <option value="">Todas</option>
            <option value="Corrida">Corrida</option>
            <option value="Basquete">Basquete</option>
            <option value="Lifestyle">Lifestyle</option>
        </select>

        <!-- Tamanho --
        <h3 class="font-bold mt-4 mb-2">Tamanho</h3>
        @foreach([37,38,39,40,41,42,43,44,45,46] as $t)
            <label class="inline-block mr-2 mb-2">
                <input type="radio" name="tamanho" value="{{ $t }}"> {{ $t }}
            </label>
        @endforeach

        <!-- Preço --
        <h3 class="font-bold mt-4 mb-2">Preço</h3>
        <input type="number" name="preco_min" placeholder="Mín" class="border p-1 w-20"> -
        <input type="number" name="preco_max" placeholder="Máx" class="border p-1 w-20">

        <button type="submit" class="mt-4 bg-black text-white px-4 py-2 w-full">
            Filtrar
        </button>
    </form>
-->

    <!-- Grid de produtos -->
<div id="produtos-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-6 pl-64 pr-64">
  <!-- Produtos serão carregados aqui via AJAX -->
</div>


<!-- Paginação e texto -->
<div class="mt-6 text-center">
    <!-- Botões da paginação -->
    <div class="flex justify-center mb-2">
        {{ $produtos->links('vendor.pagination.custom') }}
    </div>
    <!-- Texto centralizado abaixo --> 
     <div class="text-gray-400 text-sm mb-10"> Mostrando {{ $produtos->firstItem() }} a {{ $produtos->lastItem() }} de {{ $produtos->total() }} resultados </div>
</div>



    <script>
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

        // Auto-play: troca de slide a cada 5 segundos
        setInterval(nextSlide, 5000);
    </script>

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
    class="fixed top-0 left-0 h-full w-64 bg-black/80 backdrop-blur-md text-white z-50 transform -translate-x-full peer-checked:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl border-r border-[#d5891b]/30">
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

  <script>
  const overlay = document.getElementById('overlay');
  const userDropdown = document.getElementById('user-dropdown');
  const logoutMenu = document.getElementById('logout-menu');
  const enderecoWrapper = document.getElementById('enderecoWrapper');
  const enderecoDropdown = document.getElementById('enderecoDropdown');

  let userTimeout, enderecoTimeout;

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
  overlay.addEventListener('click', () => {
    if (logoutMenu) logoutMenu.classList.add('hidden');
    if (enderecoDropdown) enderecoDropdown.classList.add('hidden');
    hideOverlay();
  });

  /*======================== Busca produtos ==========================*/

  const buscarUrl = "{{ route('produtos.buscar') }}";
const inputBuscar = document.getElementById('buscar_produto');
const resultado = document.getElementById('resultado_busca');
const produtosContainer = document.getElementById('produtos-container');

let debounceTimeout;

// Função principal de busca + paginação
function carregarProdutos(params = {}) {
    // Pega os filtros atuais
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
        ...params
    });

    fetch(`${buscarUrl}?${queryParams.toString()}`)
        .then(res => res.json())
        .then(data => {
            resultado.style.display = 'none';
            produtosContainer.innerHTML = data.html;

            // Intercepta links de paginação
            document.querySelectorAll('#produtos-container .pagination a').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const url = new URL(link.href);
                    const page = url.searchParams.get('page') || 1;
                    carregarProdutos({ page });
                });
            });
        })
        .catch(() => {
            produtosContainer.innerHTML = '<p class="text-red-500 p-6 pt-24">Nenhum produto encontrado.</p>';
        });
}

// Busca com debounce
function realizarBusca() {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        carregarProdutos({ page: 1 }); // reset da página ao buscar
    }, 300);
}

inputBuscar.addEventListener('input', realizarBusca);
document.getElementById('botao_buscar').addEventListener('click', () => carregarProdutos({ page: 1 }));

// Opcional: carregar página inicial
carregarProdutos();

</script>


</body>

</html>