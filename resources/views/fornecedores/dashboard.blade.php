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
      overflow: hidden;
    }
    #overlay.active {
      pointer-events: auto;
      opacity: 1;
    }
  </style>
</head>
<body class="bg-gray-900 text-white flex">

  <!-- Overlay para dropdown -->
  <div id="overlay" class="fixed inset-0 z-30 pointer-events-none opacity-0 transition-opacity duration-300"></div>

  <!-- Sidebar -->
  <aside class="w-64 h-screen bg-gray-950 fixed shadow-md flex flex-col justify-between">
    <div class="h-40 border-b border-indigo-800 flex items-center justify-center">
      <img src="/imagens/Post Jif 2025 (8).png" alt="Hydrax Logo" class="h-40" />
    </div>

    <div class="flex-1 p-4 border-b border-indigo-800 overflow-auto">
      <nav class="flex flex-col gap-4">
        <a class="text-left px-4 py-2 rounded hover:bg-indigo-700 transition" href="{{ route('fornecedores.produtos.index') }}">Gerencia de Produtos</a>
      </nav>
    </div>

    <div class="h-16"></div>
  </aside>

  <!-- Conteúdo Principal -->
  <div class="ml-64 flex flex-col flex-1 h-screen">
    <header class="bg-gray-950/80 backdrop-blur-md shadow px-6 py-4 flex items-center justify-between border-b border-indigo-800 fixed top-0 left-64 right-0 z-40 h-16">
      <h2 class="text-xl font-semibold">Dashboard<span class="text-indigo-600"> | Fornecedor</span></h2>
      <div class="relative group flex items-center gap-3">

        <!-- Usuário logado -->
        <div class="relative inline-block text-left" id="user-dropdown">
          <div id="user-name" class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center hover:bg-indigo-500 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M9 8h6M9 12h6M9 16h6M4 21V5a1 1 0 011-1h3v4h8V4h3a1 1 0 011 1v16" />
              </svg>
            </div>

            @php
              $fornecedor = Auth::guard('fornecedores')->user();
            @endphp

            <div class="relative group inline-block text-left">
              <button type="button" class="flex items-center space-x-2 focus:outline-none">
                <img 
                  src="{{ $fornecedor->profile_photo ? asset('storage/' . $fornecedor->profile_photo) : asset('images/default-avatar.png') }}" 
                  alt="Foto de Perfil" 
                  class="w-8 h-8 rounded-full object-cover border border-white"
                >
                <span class="text-white font-semibold hover:text-indigo-400 transition-colors">
                  Olá, {{ \Illuminate\Support\Str::limit($fornecedor->nome_empresa, 15, '...') }} ▾
                </span>
              </button>
            </div>
          </div>

          <!-- Menu logout -->
          <div id="logout-menu" class="absolute right-0 hidden bg-gray-900 border border-indigo-600 rounded-md shadow-lg mt-2 py-2 min-w-[140px] z-50">
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
      </div>
    </header>

    <main class="pt-16 px-8 bg-gray-900 flex-1 overflow-hidden">
      {{-- MENSAGEM DE SUCESSO --}}
      @if(session('success'))
        <div id="success-message" class="bg-green-600 text-white p-2 rounded mb-4 w-full max-w-md transition-opacity duration-500">
          {{ session('success') }}
        </div>
      @endif
    </main>
  </div>

  <script>
    const overlay = document.getElementById('overlay');
    const userDropdown = document.getElementById('user-dropdown');
    const logoutMenu = document.getElementById('logout-menu');

    let userTimeout;

    function showOverlay() {
      overlay.classList.add('active');
    }

    function hideOverlay() {
      overlay.classList.remove('active');
    }

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

    document.addEventListener("DOMContentLoaded", function () {
      const successMessage = document.getElementById("success-message");

      if (successMessage) {
        setTimeout(() => {
          successMessage.classList.add("opacity-0");
          setTimeout(() => successMessage.remove(), 500);
        }, 3000);
      }
    });
  </script>
</body>
</html>
