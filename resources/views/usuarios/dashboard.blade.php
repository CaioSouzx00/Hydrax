<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hydrax</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
</head>

<body class="bg-black text-white font-[Poppins]">
  <!-- Navbar -->
  <header
    class="fixed top-0 left-0 w-full z-50 backdrop-blur-lg bg-black/90 border-b border-gray-800 shadow-sm"
  >
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img
          src="https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg"
          alt="Hydrax Logo"
          class="h-8"
        />
        <h1 class="text-xl font-[Orbitron] tracking-wide text-white">Hydrax</h1>
      </div>

      <!-- Menu principal -->
  <nav class="hidden md:flex items-center gap-5 text-sm">
  <!-- Barra de busca -->
  <div class="relative flex items-center bg-gray-100 rounded-md px-2 py-1 text-black">
    <input
      type="text"
      placeholder="Procurar"
      class="bg-transparent outline-none text-sm placeholder-gray-600 w-28 focus:w-44 transition-all duration-300"
    />
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="w-4 h-4 ml-1"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
    >
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
    </svg>
  </div>

  <!-- Links principais -->
  <a href="#" class="hover:text-gray-300 transition">Início</a>
  <a href="#" class="hover:text-gray-300 transition">Lançamentos</a>
  <a href="#" class="hover:text-gray-300 transition">Ofertas</a>
  <a href="#" class="hover:text-gray-300 transition">Contato</a>

@if(Auth::guard('usuarios')->check())
  @php $id = Auth::guard('usuarios')->id(); @endphp
  <div class="relative group">
    <button class="hover:text-gray-300 transition">Endereço ▾</button>
    <div
      class="absolute hidden group-hover:block bg-black border border-gray-700 rounded-md mt-2 shadow-lg py-2 min-w-[180px] z-50"
    >
      <a href="{{ route('endereco.create', $id) }}" class="block px-4 py-2 text-sm hover:bg-gray-800">
        Cadastrar Endereço
      </a>
      <a href="{{ route('usuario.enderecos', $id) }}" class="block px-4 py-2 text-sm hover:bg-gray-800">
        Listar Endereços
      </a>
    </div>
  </div>
@endif


  <!-- Ícone do carrinho -->
  <a href="#" class="relative hover:text-gray-300 transition">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="w-5 h-5 inline-block"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13L17 13M7 13H5.4"
      />
    </svg>
  </a>
  @if (!Auth::guard('usuarios')->check())
    <a href="{{ route('usuarios.create') }}" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700 transition">
      Cadastrar
    </a>
    <a href="{{ route('login.form') }}" class="bg-black px-4 py-2 rounded hover:bg-gray-800 transition ml-2">
      Entrar
    </a>
@else
    <span class="mr-4">Olá, {{ Auth::guard('usuarios')->user()->nome_completo }}</span>
    <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="inline">
      @csrf
      <button type="submit" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700 transition">
        Sair
      </button>
    </form>
@endif

</nav>

    </div>
  </header>

  <!-- Sidebar -->
  @if (!Auth::guard('usuarios')->check())
    <input type="checkbox" id="menu-toggle" class="hidden peer" />
    <label
      for="menu-toggle"
      class="fixed top-4 left-5 z-50 text-white text-2xl p-2 cursor-pointer peer-checked:hidden"
      >☰</label
    >
    <aside
      class="fixed top-0 left-0 h-full w-64 bg-black/90 text-white z-50 transform -translate-x-full peer-checked:translate-x-0 transition-transform duration-300 ease-in-out border-r border-gray-700"
    >
      <label for="menu-toggle" class="absolute top-4 right-4 text-white text-2xl cursor-pointer"
        >✕</label
      >
      <div class="mt-16 px-4 py-6">
        <div class="flex justify-center mb-6">
          <img
            src="https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg"
            class="h-10 opacity-80"
          />
        </div>
        <hr class="border-gray-700 opacity-50 mb-4" />
        <nav class="space-y-3 text-sm">
          <a href="{{ route('admin.login') }}" class="block px-4 py-2 rounded-md bg-gray-800 hover:bg-gray-700 transition"
            >Administrador</a
          >
          <a href="#" class="block px-4 py-2 rounded-md bg-gray-800 hover:bg-gray-700 transition"
            >Fornecedor</a>
        </nav>
        <hr class="border-gray-700 opacity-50 mt-6" />
        <p class="text-xs text-center text-gray-500 mt-6">
          &copy; 2025 <strong class="text-indigo-400">Hydrax</strong>
        </p>
      </div>
    </aside>
  @endif

  <!-- Conteúdo -->
  <main class="pt-24 max-w-7xl mx-auto px-6">
    <h2 class="text-3xl font-bold mb-8">Destaques Hydrax</h2>
    
    <div class="grid md:grid-cols-3 gap-6">
      <div
        class="bg-white text-black rounded-lg p-6 hover:scale-105 transition"
      >
        <h3 class="text-lg font-semibold">Administrador</h3>
        <p class="text-sm mt-2 text-gray-700">Controle geral do sistema.</p>
      </div>
      <div
        class="bg-white text-black rounded-lg p-6 hover:scale-105 transition"
      >
        <h3 class="text-lg font-semibold">Usuário</h3>
        <p class="text-sm mt-2 text-gray-700">Acesse funcionalidades de usuário.</p>
      </div>
      <div
        class="bg-white text-black rounded-lg p-6 hover:scale-105 transition"
      >
        <h3 class="text-lg font-semibold">Fornecedor</h3>
        <p class="text-sm mt-2 text-gray-700">Gerencie produtos e entregas.</p>
      </div>
    </div>
  </main>
</body>
</html>