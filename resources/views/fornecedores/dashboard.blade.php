<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="/imagens/hydrax/hydrax-perfil.png" type="image/png" />
  <title>Dashboard - Fornecedor</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom right, #211828, #0b282a, #17110d);
      height: 100vh;
      overflow: hidden;
    }

    /* Overlay */
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

    /* Cards */
    .card-glass {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(213, 137, 27, 0.3);
      border-radius: 0.5rem;
    }

    /* Form fields */
    .field-label {
      color: #d5891b;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 1px;
    }
    .field-value {
      color: #ffffff;
      font-size: 1rem;
      margin-top: 0.25rem;
    }

    /* Status badges */
    .status-badge {
      display: inline-flex;
      align-items: center;
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
    }
    .status-ativo {
      background-color: rgba(34, 197, 94, 0.2);
      color: #22c55e;
      border: 1px solid #22c55e;
    }
    .status-inativo {
      background-color: rgba(239, 68, 68, 0.2);
      color: #ef4444;
      border: 1px solid #ef4444;
    }

    /* Perfil */
    #perfil-section { display: none; }
    #perfil-section.show { display: block; }
  </style>
</head>
<body class="text-white flex min-h-screen">

  <!-- Overlay -->
  <div id="overlay"></div>

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

  <!-- Main content -->
  <div class="ml-64 flex flex-col flex-1 min-h-screen">
    <!-- Header -->
    <header class="bg-black/50 backdrop-blur-md border-b border-[#d5891b] fixed top-0 left-64 right-0 z-50 h-16 flex items-center justify-between px-6">
      <h2 class="text-xl font-semibold">Dashboard<span class="text-[#d5891b]"> | Fornecedor</span></h2>

      <!-- User dropdown -->
      <div id="user-dropdown" class="relative group flex items-center space-x-3 cursor-pointer">
        <div class="w-10 h-10 bg-[#d5891b] rounded-full flex items-center justify-center hover:bg-[#b3731a] transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M9 8h6M9 12h6M9 16h6M4 21V5a1 1 0 011-1h3v4h8V4h3a1 1 0 011 1v16" />
          </svg>
        </div>

        @php $fornecedor = Auth::guard('fornecedores')->user(); @endphp

        <button type="button" class="flex items-center space-x-2 focus:outline-none text-white font-semibold hover:text-[#d5891b] transition-colors">
          <span>Olá, {{ \Illuminate\Support\Str::limit($fornecedor->nome_empresa, 15, '...') }} ▾</span>        </button>
        <!-- Logout menu -->
        <div id="logout-menu" class="absolute right-0 hidden mt-14 bg-[#211828]/90 border border-[#d5891b] rounded shadow-lg py-2 min-w-[140px] z-50">
          <button id="btn-perfil" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-[#d5891b]/30 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.779.755 6.879 2.041M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Perfil</span>
          </button>
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

    <!-- Main -->
    <main class="pt-16 px-8 bg-transparent flex-1 overflow-auto">
      <!-- Success message -->
      @if(session('success'))
        <div id="success-message" class="bg-green-600 text-white p-2 rounded mb-4 w-full max-w-md transition-opacity duration-500">
          {{ session('success') }}
        </div>
      @endif

      <!-- Dashboard content -->
      <div id="dashboard-content">
        <h1 class="text-2xl font-bold mb-6">Bem-vindo ao Dashboard</h1>
        <p class="text-gray-300">Clique em "Perfil" no menu acima para ver suas informações.</p>
      </div>

      <!-- Perfil Section -->
      <div id="perfil-section" class="max-w-4xl mx-auto">
        <!-- Perfil Card -->
        <div class="card-glass p-6 mb-6">
          <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-white flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-[#d5891b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.779.755 6.879 2.041M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              Meu Perfil
            </h1>
            <button id="btn-fechar-perfil" class="text-gray-400 hover:text-white transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="flex items-center space-x-6">
            <img src="{{ $fornecedor->foto ? asset('storage/' . $fornecedor->foto) : asset('images/default-avatar.png') }}" alt="Foto da Empresa" class="w-24 h-24 rounded-full border-4 border-[#d5891b] shadow-lg">
            <div class="flex-1">
              <h2 class="text-xl font-bold text-white mb-2">{{ $fornecedor->nome_empresa }}</h2>
              <p class="text-gray-300 mb-2">CNPJ: {{ $fornecedor->cnpj }}</p>
              <span class="status-badge {{ $fornecedor->status === 'ATIVO' ? 'status-ativo' : 'status-inativo' }}">
                {{ $fornecedor->status }}
              </span>
            </div>
          </div>
        </div>

        <!-- Grid de informações -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Empresa info -->
          <div class="card-glass p-6">
            <h3 class="text-lg font-semibold text-[#d5891b] mb-4 flex items-center">Informações da Empresa</h3>
            <div class="space-y-4">
              <div><label class="field-label">Nome da Empresa</label><p class="field-value">{{ $fornecedor->nome_empresa }}</p></div>
              <div><label class="field-label">CNPJ</label><p class="field-value">{{ $fornecedor->cnpj }}</p></div>
              <div><label class="field-label">Status da Conta</label>
                <span class="status-badge {{ $fornecedor->status === 'ATIVO' ? 'status-ativo' : 'status-inativo' }}">{{ $fornecedor->status }}</span>
              </div>
            </div>
          </div>

          <!-- Contato -->
          <div class="card-glass p-6">
            <h3 class="text-lg font-semibold text-[#d5891b] mb-4 flex items-center">Informações de Contato</h3>
            <div class="space-y-4">
              <div><label class="field-label">E-mail</label><p class="field-value">{{ $fornecedor->email }}</p></div>
              <div><label class="field-label">Telefone</label><p class="field-value">{{ $fornecedor->telefone }}</p></div>
            </div>
          </div>

          <!-- Sistema info -->
          <div class="card-glass p-6">
            <h3 class="text-lg font-semibold text-[#d5891b] mb-4 flex items-center">Informações do Sistema</h3>
            <div class="space-y-4">
              <div><label class="field-label">Data de Cadastro</label><p class="field-value">{{ $fornecedor->created_at?->format('d/m/Y H:i:s') ?? 'Não informado' }}</p></div>
              <div><label class="field-label">Última Atualização</label><p class="field-value">{{ $fornecedor->updated_at?->format('d/m/Y H:i:s') ?? 'Nunca atualizado' }}</p></div>
            </div>
          </div>

          <!-- Foto da empresa -->
          <div class="card-glass p-6 text-center">
            <h3 class="text-lg font-semibold text-[#d5891b] mb-4">Foto da Empresa</h3>
            <img src="{{ $fornecedor->foto ? asset('storage/' . $fornecedor->foto) : asset('images/default-avatar.png') }}" alt="Foto da Empresa" class="w-32 h-32 mx-auto rounded-lg border-2 border-[#d5891b] shadow-lg">
            <p class="field-value mt-2 text-sm">{{ $fornecedor->foto ? 'Foto da Empresa' : 'Nenhuma foto cadastrada' }}</p>
          </div>

          <!-- Segurança -->
          <div class="card-glass p-6 mt-6 lg:col-span-2">
            <h3 class="text-lg font-semibold text-[#d5891b] mb-4 flex items-center">Segurança da Conta</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="field-label">Senha</label>
                <p class="field-value">••••••••••••</p>
                <p class="text-xs text-gray-400 mt-1">Última alteração: {{ $fornecedor->updated_at?->format('d/m/Y') ?? 'Não informado' }}</p>
              </div>
              <div class="flex items-end">
              </div>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>

  <!-- Scripts -->
  <script>
    const overlay = document.getElementById('overlay');
    const userDropdown = document.getElementById('user-dropdown');
    const logoutMenu = document.getElementById('logout-menu');
    const btnPerfil = document.getElementById('btn-perfil');
    const btnFecharPerfil = document.getElementById('btn-fechar-perfil');
    const perfilSection = document.getElementById('perfil-section');
    const dashboardContent = document.getElementById('dashboard-content');

    let userTimeout;

    // Overlay functions
    const showOverlay = () => overlay.classList.add('active');
    const hideOverlay = () => overlay.classList.remove('active');

    // Dropdown hover
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

    // Mostrar perfil
    btnPerfil.addEventListener('click', () => {
      dashboardContent.style.display = 'none';
      perfilSection.classList.add('show');
      logoutMenu.classList.add('hidden');
      hideOverlay();
    });

    // Fechar perfil
    btnFecharPerfil.addEventListener('click', () => {
      perfilSection.classList.remove('show');
      dashboardContent.style.display = 'block';
    });

    // Mensagem de sucesso
    document.addEventListener("DOMContentLoaded", () => {
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
