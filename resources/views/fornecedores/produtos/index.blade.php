<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Produtos - Fornecedor</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="/imagens/hydrax/hydrax-perfil.png" type="image/png" />
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

<body class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-white flex min-h-screen">

<!-- Overlay -->
<div id="overlay"></div>

<!-- Sidebar -->
<aside class="w-64 h-screen bg-black/70 backdrop-blur-md shadow-2xl border-r border-[#d5891b]/30 fixed z-50">
  <div class="h-40 border-b border-[#d5891b]/40 flex items-center justify-center">
    <img src="/imagens/Post Jif 2025 (8).png" alt="Hydrax Logo" class="h-32 hover:opacity-90 transition" />
  </div>

  <div class="p-4 space-y-4 text-sm">
    <a href="#" 
       data-url="{{ route('fornecedores.produtos.create') }}" 
       class="link-ajax block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#0b282a] transition shadow-md text-center">
      + Cadastrar Produto
    </a>

    <a href="#" 
       data-url="{{ route('fornecedores.produtos.listar') }}" 
       class="link-ajax block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#0b282a] transition shadow-md text-center">
      📋 Listar Produtos
    </a>
  </div>
</aside>

<!-- Conteúdo Principal -->
<div class="ml-64 flex-1 flex flex-col min-h-screen">

  <!-- Navbar -->
  <header class="bg-black/50 backdrop-blur-md border-b border-[#d5891b] fixed top-0 left-64 right-0 z-40 h-16 flex items-center justify-between px-6">
    <h2 class="text-xl font-semibold">Produtos <span class="text-[#d5891b]">| Fornecedor</span></h2>
    <div id="user-dropdown" class="relative group flex items-center space-x-2 cursor-pointer">
      <div class="w-10 h-10 bg-[#d5891b] rounded-full flex items-center justify-center hover:bg-[#b3731a] transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M9 8h6M9 12h6M9 16h6M4 21V5a1 1 0 011-1h3v4h8V4h3a1 1 0 011 1v16" />
        </svg>
      </div>
      <span class="font-semibold hover:text-[#d5891b]">
        Olá, {{ Auth::guard('fornecedores')->user()->nome_empresa }} ▾
      </span>

      <!-- Dropdown -->
      <div id="logout-menu" class="absolute right-0 hidden mt-14 bg-[#211828]/90 border border-[#d5891b] rounded shadow-lg py-2 min-w-[140px] z-50">
        <form method="POST" action="{{ route('fornecedores.logout') }}">
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

  <!-- Conteúdo -->
  <main class="pt-20 px-8 flex-1 overflow-y-auto" id="main-content">
    <div id="conteudo-dinamico">
      <p class="text-gray-300">Bem-vindo! Use o menu ao lado para gerenciar seus produtos.</p>
    </div>
  </main>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  const overlay = document.getElementById('overlay');
  const userDropdown = document.getElementById('user-dropdown');
  const logoutMenu = document.getElementById('logout-menu');

  let userTimeout;

  userDropdown.addEventListener('mouseenter', () => {
    clearTimeout(userTimeout);
    logoutMenu.classList.remove('hidden');
    overlay.classList.add('active');
  });

  userDropdown.addEventListener('mouseleave', () => {
    userTimeout = setTimeout(() => {
      logoutMenu.classList.add('hidden');
      overlay.classList.remove('active');
    }, 150);
  });

  overlay.addEventListener('click', () => {
    logoutMenu.classList.add('hidden');
    overlay.classList.remove('active');
  });

  // AJAX navegação
  $(document).on('click', '.link-ajax', function(e) {
    e.preventDefault();
    const url = $(this).data('url');

    $('#conteudo-dinamico').html('<p class="text-gray-300">Carregando...</p>');

    $.get(url, function(data) {
      $('#conteudo-dinamico').html(data);
    }).fail(function() {
      $('#conteudo-dinamico').html('<p class="text-red-500">Erro ao carregar conteúdo.</p>');
    });
  });
</script>

</body>
</html>
