<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="/imagens/hydrax/hydrax-perfil.png" type="image/png" />
  <title>Dashboard - Fornecedor</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      /* Fundo degradê conforme o segundo código */
      background: linear-gradient(to bottom right, #211828, #0b282a, #17110d);
      height: 100vh;
      overflow: hidden;
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
<body class="text-white flex min-h-screen">

  <!-- Overlay para dropdown -->
  <div id="overlay" class="fixed inset-0 z-40 pointer-events-none opacity-0 transition-opacity duration-300"></div>

  <!-- Sidebar -->
  <aside class="w-64 h-screen fixed z-50 bg-black/70 backdrop-blur-md shadow-2xl border-r border-[#d5891b]/30 flex flex-col justify-between">
    <div class="h-40 border-b border-[#d5891b]/40 flex items-center justify-center">
      <img src="/imagens/hydrax/HYDRAX - LOGO1.png" alt="Hydrax Logo" class="h-32 hover:opacity-90 transition" />
    </div>

    <div class="flex-1 p-4 border-b border-[#d5891b]/40 overflow-auto">
      <nav class="flex flex-col gap-4 text-sm">
        <a class="block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#2d4e50] transition shadow-md text-center" href="{{ route('fornecedores.produtos.index') }}">
          Gerencia de Produtos
        </a>
      </nav>
    </div>

    <div class="h-16"></div>
  </aside>

  <!-- Conteúdo Principal -->
  <div class="ml-64 flex flex-col flex-1 min-h-screen">

    <header class="bg-black/50 backdrop-blur-md border-b border-[#d5891b] fixed top-0 left-64 right-0 z-50 h-16 flex items-center justify-between px-6">
      <h2 class="text-xl font-semibold">
        Dashboard<span class="text-[#d5891b]"> | Fornecedor</span>
      </h2>

      <div id="user-dropdown" class="relative group flex items-center space-x-3 cursor-pointer">
        <div class="w-10 h-10 bg-[#d5891b] rounded-full flex items-center justify-center hover:bg-[#b3731a] transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M9 8h6M9 12h6M9 16h6M4 21V5a1 1 0 011-1h3v4h8V4h3a1 1 0 011 1v16" />
          </svg>
        </div>

        @php
          $fornecedor = Auth::guard('fornecedores')->user();
        @endphp

        <button type="button" class="flex items-center space-x-2 focus:outline-none text-white font-semibold hover:text-[#d5891b] transition-colors">
          <img 
            src="{{ $fornecedor->profile_photo ? asset('storage/' . $fornecedor->profile_photo) : asset('images/default-avatar.png') }}" 
            alt="Foto de Perfil" 
            class="w-8 h-8 rounded-full object-cover border border-white"
          >
          <span>
            Olá, {{ \Illuminate\Support\Str::limit($fornecedor->nome_empresa, 15, '...') }} ▾
          </span>
        </button>

        <!-- Menu logout -->
        <div id="logout-menu" class="absolute right-0 hidden mt-14 bg-[#211828]/90 border border-[#d5891b] rounded shadow-lg py-2 min-w-[140px] z-50">
          <a href="#"
            class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-[#d5891b]/30 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.779.755 6.879 2.041M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Perfil</span>
          </a>
          <form id="logoutForm" method="POST" action="{{ route('fornecedores.logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm hover:bg-[#d5891b]/30 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
              </svg>
              <span>Sair</span>
            </button>
          </form>
        </div>
      </div>
    </header>

    <main class="pt-16 px-8 bg-transparent flex-1 overflow-hidden">
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

    // Fechar dropdown clicando fora
    overlay.addEventListener('click', () => {
      logoutMenu.classList.add('hidden');
      hideOverlay();
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
