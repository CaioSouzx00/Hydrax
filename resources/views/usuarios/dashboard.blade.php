<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

        <!-- Busca -->
        <div class="relative flex items-center bg-gray-200 rounded-xl px-3 py-1.5 text-black focus-within:ring-2 focus-within:ring-[#d5891b]">
          <input type="text" placeholder="Procurar" class="bg-transparent outline-none text-sm placeholder-gray-600 w-28 focus:w-44 transition-all duration-300" />
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
          </svg>
        </div>

        @if (!Auth::guard('usuarios')->check())
          <!-- Links para visitante -->
          <a href="{{ route('usuarios.create') }}" class="relative rounded-2xl px-5 py-2.5 overflow-hidden group bg-[#14ba88] hover:bg-gradient-to-r hover:from-[#14ba88] hover:to-[#1ce0a5] hover:ring-2 hover:ring-offset-2 hover:ring-[#1ce0a5] transition-all ease-out duration-300">
            <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
            <span class="relative">Cadastrar</span>
          </a>

          <a href="{{ route('login.form') }}" class="relative inline-flex items-center justify-start px-5 py-2.5 font-bold rounded-2xl group overflow-hidden">
            <span class="w-32 h-32 rotate-45 translate-x-12 -translate-y-2 absolute left-0 top-0 bg-white opacity-[3%]"></span>
            <span class="absolute top-0 left-0 w-48 h-48 -mt-1 transition-all duration-500 ease-in-out rotate-45 -translate-x-56 -translate-y-24 bg-white opacity-100 group-hover:-translate-x-8"></span>
            <span class="relative w-full text-left text-white group-hover:text-gray-900">Entrar</span>
            <span class="absolute inset-0 border-2 border-white rounded-2xl"></span>
          </a>

        @else
          @csrf

          <!-- Usuário logado -->
          <div class="relative inline-block text-left" id="user-dropdown">
            <div id="user-name" class="flex items-center space-x-2">
              <div class="w-8 h-8 bg-[#d5891b] rounded-full flex items-center justify-center hover:bg-[#d5891b] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
              </div>
              <span class="mr-4 cursor-pointer font-semibold hover:text-[#d5891b] transition-colors">
                Olá, {{ Auth::guard('usuarios')->user()->nome_completo }} ▾
              </span>
            </div>

            <!-- Menu logout -->
            <div id="logout-menu" class="absolute right-0 hidden bg-[#211828]/80 border border-[#7f3a0e] rounded-md shadow-lg mt-2 py-2 min-w-[140px] z-50">
                <a href="{{ route('usuario.painel') }}" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-[#d5891b]/30  transition-colors">
    <span>Perfil</span>
</a>


            <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-[#d5891b]/30  transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                  </svg>
                  <span>Sair</span>
                </button>
              </form>
            </div>
          </div>

          @php $id = Auth::guard('usuarios')->id(); @endphp

          <!-- Dropdown Endereço -->
          <div class="relative text-white hover:text-indigo-400" id="enderecoWrapper">
            <button id="enderecoBtn" class="flex items-center gap-2 px-4 py-2  transition-all duration-300 shadow-md hover:shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11.5a2 2 0 100-4 2 2 0 000 4zm0 9.5c-4.418 0-8-5.373-8-9a8 8 0 1116 0c0 3.627-3.582 9-8 9z" />
            </svg>
            <span>Endereço ▾</span>
            </button>

            <div id="enderecoDropdown" class="absolute hidden bg-gray-900 border border-indigo-600 rounded-md shadow-lg mt-2 py-2 min-w-[180px] z-50">
              <a href="{{ route('endereco.create', $id) }}" class="block px-4 py-2 text-sm text-white hover:bg-indigo-600/30">Cadastrar Endereço</a>
              <a href="{{ route('usuario.enderecos', $id) }}" class="block px-4 py-2 text-sm text-white hover:bg-indigo-600/30">Listar Endereços</a>
            </div>
          </div>

        @endif

        <!-- Carrinho -->
        <a href="#" class="relative hover:text-gray-300 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13L17 13M7 13H5.4" />
          </svg>
        </a>
      </nav>
    </div>
  </header>

<div id="overlay"></div>

  <!-- Sidebar Mobile -->
  @if (!Auth::guard('usuarios')->check())
    <input type="checkbox" id="menu-toggle" class="hidden peer" />
    <label for="menu-toggle" class="fixed top-4 left-5 z-50 text-white text-2xl p-2 cursor-pointer peer-checked:hidden hover:text-[#a68e7b]">☰</label>
<aside class="fixed top-0 left-0 h-full w-64 bg-black/80 backdrop-blur-md text-white z-50 transform -translate-x-full peer-checked:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl border-r border-[#d5891b]/30">
  <label for="menu-toggle" class="absolute top-4 right-4 text-white text-2xl cursor-pointer hover:text-[#a68e7b] transition">✕</label>
  <div class="mt-16 px-4 py-6">
    <div class="flex justify-center mb-6">
      <img src="/imagens/hydrax/HYDRAX - LOGO1.png" alt="Hydrax Logo" class="h-40 opacity-90 hover:opacity-100 transition" />
    </div>
    <hr class="border-[#d5891b]/40 mb-4" />
    <nav class="space-y-3 text-sm">
      <a href="{{ route('admin.login') }}" class="block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#0b282a] transition shadow-md">Administrador</a>
      <a href="{{ route('fornecedores.login') }}" class="block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#0b282a] transition shadow-md">Fornecedor</a>
    </nav>
    <hr class="border-[#d5891b]/40 mt-6" />
    <p class="text-xs text-center text-green-200 mt-6">
      &copy; 2025 <strong class="text-[#14ba88]">Hydrax</strong>
    </p>
  </div>
</aside>


  @endif

  <!-- Conteúdo Principal -->
  <main class="pt-28 max-w-7xl mx-auto px-6">
    <h2 class="text-3xl font-bold mb-10">Destaques Hydrax</h2>
    <div class="grid md:grid-cols-3 gap-6">
      <div class="bg-white text-black rounded-xl p-6 shadow-md hover:shadow-xl hover:scale-[1.03] transition-all">
        <h3 class="text-xl font-semibold">Administrador</h3>
        <p class="text-sm mt-3 text-gray-600">Controle geral do sistema.</p>
      </div>
      <div class="bg-white text-black rounded-xl p-6 shadow-md hover:shadow-xl hover:scale-[1.03] transition-all">
        <h3 class="text-xl font-semibold">Usuário</h3>
        <p class="text-sm mt-3 text-gray-600">Acesse funcionalidades de usuário.</p>
      </div>
      <div class="bg-white text-black rounded-xl p-6 shadow-md hover:shadow-xl hover:scale-[1.03] transition-all">
        <h3 class="text-xl font-semibold">Fornecedor</h3>
        <p class="text-sm mt-3 text-gray-600">Gerencie produtos e entregas.</p>
      </div>
    </div>
  </main>

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

  // Dropdown endereço
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

  // Fechar dropdowns ao clicar no overlay
  overlay.addEventListener('click', () => {
    logoutMenu.classList.add('hidden');
    enderecoDropdown.classList.add('hidden');
    hideOverlay();
  });
</script>

</body>

</html>
