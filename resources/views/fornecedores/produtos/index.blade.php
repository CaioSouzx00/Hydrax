<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Produtos - Fornecedor</title>
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
      <img src="/imagens/Post Jif 2025 (8).png" alt="Hydrax Logo" class="h-40" />
    </div>

    <!-- Menu de Funções -->
    <div class="flex-1 p-4 border-b border-indigo-800 overflow-auto">
      <nav class="flex flex-col gap-4">
        <a href="{{ route('fornecedores.produtos.create') }}" class="text-left px-4 py-2 rounded hover:bg-indigo-700 transition">
          + Cadastrar Produto
        </a>
      </nav>
    </div>

    <div class="h-16"></div>
  </aside>

  <!-- Conteúdo Principal -->
  <div class="ml-64 flex flex-col flex-1 h-screen">
    <!-- Navbar -->
    <header class="bg-gray-950/80 backdrop-blur-md shadow px-6 py-4 flex items-center justify-between border-b border-indigo-800 fixed top-0 left-64 right-0 z-40 h-16">
      <h2 class="text-xl font-semibold">Produtos <span class="text-indigo-600">| Fornecedor</span></h2>
      <div class="relative group flex items-center gap-3">
        <div class="relative inline-block text-left" id="user-dropdown">
          <div id="user-name" class="flex items-center space-x-2 cursor-pointer">
            <div 
              class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center hover:bg-indigo-500 transition-colors" 
              aria-haspopup="true" aria-expanded="false" aria-controls="logout-menu">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M3 21h18M9 8h6M9 12h6M9 16h6M4 21V5a1 1 0 011-1h3v4h8V4h3a1 1 0 011 1v16" />
              </svg>
            </div>
            <span class="mr-4 font-semibold hover:text-indigo-400 transition-colors">
              Olá, {{ Auth::guard('fornecedores')->user()->nome_empresa }} ▾
            </span>
          </div>

          <div id="logout-menu" class="absolute right-0 hidden bg-gray-900 border border-indigo-600 rounded-md shadow-lg mt-2 py-2 min-w-[140px] z-50">
            <form method="POST" action="{{ route('fornecedores.logout') }}">
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

    <!-- Conteúdo abaixo da navbar -->
    <main class="pt-20 px-8 bg-gray-900 flex-1 overflow-auto">

      <h3 class="text-white text-2xl mb-6 font-semibold">Lista de Produtos</h3>

      @if(session('success'))
        <div class="mb-4 p-4 bg-green-600 rounded text-white">
          {{ session('success') }}
        </div>
      @endif

      @if($produtos->isEmpty())
        <p class="text-gray-400">Nenhum produto cadastrado ainda.</p>
      @else
      <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-800 rounded-lg">
          <thead>
            <tr class="text-left border-b border-indigo-600">
            <th class="px-6 py-3">Imagens</th>
              <th class="px-6 py-3">Nome</th>
              <th class="px-6 py-3">Descrição</th>
              <th class="px-6 py-3">Preço</th>
              <th class="px-6 py-3">Gênero</th>
              <th class="px-6 py-3">Categoria</th>
              <th class="px-6 py-3">Ativo</th>
              <th class="px-6 py-3">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach($produtos as $produto)

            <td class="px-6 py-4">
  @if($produto->fotos)
    @foreach(json_decode($produto->fotos) as $foto)
      <img src="{{ asset('storage/' . $foto) }}" alt="Imagem do produto" class="inline-block w-16 h-16 object-cover rounded mr-1" />
    @endforeach
  @else
    <span class="text-gray-400">Sem imagens</span>
  @endif
</td>

              <tr class="border-b border-indigo-700 hover:bg-indigo-700/30 transition">
                <td class="px-6 py-4">{{ $produto->nome }}</td>
                <td class="px-6 py-4 truncate max-w-xs" title="{{ $produto->descricao }}">{{ $produto->descricao }}</td>
                <td class="px-6 py-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                <td class="px-6 py-4">{{ ucfirst(strtolower($produto->genero)) }}</td>
                <td class="px-6 py-4">{{ ucfirst($produto->categoria) }}</td>
                <td class="px-6 py-4">
                  @if($produto->ativo)
                    <span class="px-2 py-1 bg-green-600 rounded">Sim</span>
                  @else
                    <span class="px-2 py-1 bg-red-600 rounded">Não</span>
                  @endif
                </td>
                <td class="px-6 py-4">
                  <!-- Aqui você pode colocar botões para editar/excluir, por enquanto só um placeholder -->
                  <a href="#" class="text-indigo-400 hover:text-indigo-600">Editar</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif

    </main>
  </div>

<script>
  const userDropdown = document.getElementById('user-dropdown');
  const logoutMenu = document.getElementById('logout-menu');
  let userTimeout;

  userDropdown.addEventListener('mouseenter', () => {
    clearTimeout(userTimeout);
    logoutMenu.classList.remove('hidden');
  });

  userDropdown.addEventListener('mouseleave', () => {
    userTimeout = setTimeout(() => {
      logoutMenu.classList.add('hidden');
    }, 150);
  });
</script>

</body>
</html>
