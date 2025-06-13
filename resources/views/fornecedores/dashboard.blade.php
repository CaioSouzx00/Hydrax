<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - Fornecedor</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      overflow: hidden; /* evita scroll na página toda */
    }
  </style>
</head>
<body class="bg-gray-900 text-white flex">

  <!-- Sidebar -->
  <aside class="w-64 h-screen bg-gray-950 fixed shadow-md flex flex-col justify-between">
    <!-- Logo -->
    <div class="h-40 border-b border-indigo-800 flex items-center justify-center">
      <h1 class="text-indigo-600 text-3xl font-bold">Hydrax</h1>

    </div>

    <!-- Menu de Funções -->
    <div class="flex-1 p-4 border-b border-indigo-800 overflow-auto">
      <nav class="flex flex-col gap-4">
        <button class="text-left px-4 py-2 rounded hover:bg-indigo-700 transition"><a href="{{ route('fornecedores.produtos.create') }}"
   class="text-left px-4 py-2 rounded hover:bg-indigo-700 transition bg-indigo-600 text-white">
   Cadastrar Produto
</a>
</button>
        <button class="text-left px-4 py-2 rounded hover:bg-indigo-700 transition">Ações Futuras</button>
        <button class="text-left px-4 py-2 rounded hover:bg-indigo-700 transition">Ações Futuras</button>
        <button class="text-left px-4 py-2 rounded hover:bg-indigo-700 transition">Ações Futuras</button>
      </nav>
    </div>

    <!-- Espaço em branco para evitar scroll da sidebar -->
    <div class="h-16"></div>
  </aside>

  <!-- Conteúdo Principal -->
  <div class="ml-64 flex flex-col flex-1 h-screen">
    <!-- Navbar -->
    <header class="bg-gray-950/80 backdrop-blur-md shadow px-6 py-4 flex items-center justify-between border-b border-indigo-800 fixed top-0 left-64 right-0 z-40 h-16">
      <h2 class="text-xl font-semibold">Dashboard<span class="text-indigo-600"> | Fornecedor</span> </h2>
      <div class="flex items-center gap-3 relative">

        <!-- Botão Avatar para abrir o menu -->
        <button id="userMenuBtn" class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center hover:bg-indigo-500 transition-colors" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="logout-menu">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M3 21h18M9 8h6M9 12h6M9 16h6M4 21V5a1 1 0 011-1h3v4h8V4h3a1 1 0 011 1v16" />
          </svg>
        </button>

        <span class="font-medium">Olá, {{ Auth::guard('fornecedores')->user()->nome_empresa }}</span>

        <!-- Menu Dropdown do logout -->
        <div id="logout-menu" class="absolute right-0 top-12 hidden bg-gray-900 border border-indigo-600 rounded-md shadow-lg py-2 min-w-[140px] z-50">
          <form id="logoutForm" method="POST" action="{{ route('fornecedores.logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-indigo-600/30 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
              </svg>
              <span>Sair</span>
            </button>
          </form>
        </div>

      </div>
    </header>

    <!-- Conteúdo abaixo da navbar -->
    <main class="pt-16 px-8 bg-gray-900 flex-1 overflow-hidden">

    </main>
  </div>

  <script>
    // Toggle do menu de logout
    const userMenuBtn = document.getElementById('userMenuBtn');
    const logoutMenu = document.getElementById('logout-menu');

    userMenuBtn.addEventListener('click', () => {
      logoutMenu.classList.toggle('hidden');
      // Atualiza aria-expanded para acessibilidade
      const expanded = userMenuBtn.getAttribute('aria-expanded') === 'true';
      userMenuBtn.setAttribute('aria-expanded', String(!expanded));
    });

    // Fecha o menu se clicar fora
    document.addEventListener('click', (e) => {
      if (!userMenuBtn.contains(e.target) && !logoutMenu.contains(e.target)) {
        logoutMenu.classList.add('hidden');
        userMenuBtn.setAttribute('aria-expanded', 'false');
      }
    });
  </script>

</body>
</html>
