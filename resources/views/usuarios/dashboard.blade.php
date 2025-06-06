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
  </style>
</head>

<body class="bg-gray-900 text-white">
  <!-- Navbar -->
  <header class="fixed top-0 left-0 w-full z-50 backdrop-blur-md bg-gray-950/80 border-b border-indigo-800 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg" alt="Hydrax Logo" class="h-8" />
        <h1 class="text-2xl font-[Orbitron] tracking-[0.15em] text-white">Hydrax</h1>
      </div>

      <!-- Menu principal -->
      <nav class="hidden md:flex items-center gap-6 text-sm">
        <!-- Busca -->
        <div class="relative flex items-center bg-gray-200 rounded-full px-3 py-1 text-black focus-within:ring-2 focus-within:ring-blue-500">
          <input type="text" placeholder="Procurar" class="bg-transparent outline-none text-sm placeholder-gray-600 w-28 focus:w-44 transition-all duration-300" />
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
          </svg>
        </div>

        @if (!Auth::guard('usuarios')->check())
          <a href="{{ route('usuarios.create') }}" class="relative rounded-2xl px-5 py-2.5 overflow-hidden group bg-indigo-500 relative hover:bg-gradient-to-r hover:from-indigo-500 hover:to-indigo-400 hover:ring-2 hover:ring-offset-2 hover:ring-indigo-400 transition-all ease-out duration-300">
    <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
    <span class="relative">Cadastrar</span>
</a>

          <a href="{{ route('login.form') }}" class="relative inline-flex items-center justify-start inline-block px-5 py-3 overflow-hidden font-bold rounded-2xl group">
          <span class="w-32 h-32 rotate-45 translate-x-12 -translate-y-2 absolute left-0 top-0 bg-white opacity-[3%]"></span>
          <span class="absolute top-0 left-0 w-48 h-48 -mt-1 transition-all duration-500 ease-in-out rotate-45 -translate-x-56 -translate-y-24 bg-white opacity-100 group-hover:-translate-x-8"></span>
          <span class="relative w-full text-left text-white transition-colors duration-200 ease-in-out group-hover:text-gray-900">Entrar</span>
          <span class="absolute inset-0 border-2 border-white rounded-2xl"></span>
          </a>
        @else
  @csrf

<div class="relative inline-block text-left" id="user-dropdown">
  <!-- Nome do usuário -->
  <span
    id="user-name"
    class="mr-4 cursor-pointer text-white font-semibold select-none hover:text-indigo-400 transition-colors duration-300 ease-in-out"
  >
    Olá, {{ Auth::guard('usuarios')->user()->nome_completo }} ▾
  </span>

  <!-- Dropdown escondido inicialmente -->
  <div
    id="logout-menu"
    class="absolute right-0 hidden bg-gray-900 border border-indigo-600 rounded-md shadow-lg mt-2 py-2 min-w-[140px] z-50"
  >
    <form id="logoutForm" method="POST" action="{{ route('logout') }}">
      @csrf
<button
  type="submit"
  class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-indigo-600/30 transition-colors duration-200 ease-in-out"
>
  <!-- Ícone de logout -->
  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
  </svg>
  <span>Sair</span>
</button>

    </form>
  </div>
</div>
        @endif

        
        @if(Auth::guard('usuarios')->check())
          @php $id = Auth::guard('usuarios')->id(); @endphp
                <!-- Endereço Dropdown -->
      <div class="relative" id="enderecoWrapper">
        <button id="enderecoBtn" class="hover:text-indigo-400 transition">Endereço</button>
        <div id="enderecoDropdown" class="absolute hidden bg-gray-900 border border-indigo-600 rounded-md shadow-lg mt-2 py-2 min-w-[180px] z-50">
            <a href="{{ route('endereco.create', $id) }}" class="block px-4 py-2 text-sm text-white hover:bg-indigo-600/30">Cadastrar Endereço</a>
            <a href="{{ route('usuario.enderecos', $id) }}" class="block px-4 py-2 text-sm text-white hover:bg-indigo-600/30">Listar Endereços</a>
        </div>
      </div>

        @endif
                <!-- Carrinho -->
        <a href="#" class="relative hover:text-gray-300 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13L17 13M7 13H5.4" />
          </svg>
        </a>
      </nav>
    </div>
  </header>

  <!-- Sidebar Mobile -->
  @if (!Auth::guard('usuarios')->check())
    <input type="checkbox" id="menu-toggle" class="hidden peer" />
    <label for="menu-toggle" class="fixed top-4 left-5 z-50 text-white text-2xl p-2 cursor-pointer peer-checked:hidden">☰</label>
    <aside class="fixed top-0 left-0 h-full w-64 bg-black/80 backdrop-blur-md text-white z-50 transform -translate-x-full peer-checked:translate-x-0 transition-transform duration-300 ease-in-out">
      <label for="menu-toggle" class="absolute top-4 right-4 text-white text-2xl cursor-pointer">✕</label>
      <div class="mt-16 px-4 py-6">
        <div class="flex justify-center mb-6">
          <img src="https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg" class="h-10 opacity-80" />
        </div>
        <hr class="border-gray-700 opacity-50 mb-4" />
        <nav class="space-y-3 text-sm">
          <a href="{{ route('admin.login') }}" class="block px-4 py-2 rounded-md bg-gray-800 hover:bg-gray-700 transition">Administrador</a>
          <a href="#" class="block px-4 py-2 rounded-md bg-gray-800 hover:bg-gray-700 transition">Fornecedor</a>
        </nav>
        <hr class="border-gray-700 opacity-50 mt-6" />
        <p class="text-xs text-center text-gray-500 mt-6">
          &copy; 2025 <strong class="text-indigo-400">Hydrax</strong>
        </p>
      </div>
    </aside>
  @endif

  <!-- Conteúdo -->
  <main class="pt-28 max-w-7xl mx-auto px-6">
    <h2 class="text-3xl font-bold mb-10">Destaques Hydrax</h2>

    <div class="grid md:grid-cols-3 gap-6">
      <div class="bg-white text-black rounded-xl p-6 shadow-md hover:shadow-xl hover:scale-[1.03] transition-all duration-300">
        <h3 class="text-xl font-semibold">Administrador</h3>
        <p class="text-sm mt-3 text-gray-600">Controle geral do sistema.</p>
      </div>
      <div class="bg-white text-black rounded-xl p-6 shadow-md hover:shadow-xl hover:scale-[1.03] transition-all duration-300">
        <h3 class="text-xl font-semibold">Usuário</h3>
        <p class="text-sm mt-3 text-gray-600">Acesse funcionalidades de usuário.</p>
      </div>
      <div class="bg-white text-black rounded-xl p-6 shadow-md hover:shadow-xl hover:scale-[1.03] transition-all duration-300">
        <h3 class="text-xl font-semibold">Fornecedor</h3>
        <p class="text-sm mt-3 text-gray-600">Gerencie produtos e entregas.</p>
      </div>
    </div>
  </main>
  <!-- Script -->
<script>
  const btn = document.getElementById('enderecoBtn');
  const dropdown = document.getElementById('enderecoDropdown');
  const wrapper = document.getElementById('enderecoWrapper');

  let timeout;

  wrapper.addEventListener('mouseenter', () => {
    clearTimeout(timeout);
    dropdown.classList.remove('hidden');
  });

  wrapper.addEventListener('mouseleave', () => {
    timeout = setTimeout(() => {
      dropdown.classList.add('hidden');
    }, 200); // tempo suficiente pro mouse alcançar
  });
</script>

<script>
  const userDropdown = document.getElementById('user-dropdown');
  const logoutMenu = document.getElementById('logout-menu');
  let hideTimeout;

  userDropdown.addEventListener('mouseenter', () => {
    clearTimeout(hideTimeout);
    logoutMenu.classList.remove('hidden');
  });

  userDropdown.addEventListener('mouseleave', () => {
    hideTimeout = setTimeout(() => {
      logoutMenu.classList.add('hidden');
    }, 150);
  });
</script>

</body>

</html>