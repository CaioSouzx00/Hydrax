<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Endereços de {{ $usuario->nome_completo }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes moveBackground {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes particleMovement {
      0% { transform: translate(-50%, -50%) scale(0.8); }
      50% { transform: translate(50%, 50%) scale(1.5); }
      100% { transform: translate(-50%, -50%) scale(0.8); }
    }

    body {
      background: linear-gradient(135deg, #0d0d0d, #1a0033, #000c40);
      animation: moveBackground 20s linear infinite;
      overflow-x: hidden;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
      color: white;
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(100, 100, 255, 0.1);
      box-shadow: 0 0 15px rgba(100, 100, 255, 0.2);
      opacity: 0.7;
      pointer-events: none;
      animation: particleMovement 5s ease-in-out infinite;
    }

    .particle1 { width: 80px; height: 80px; top: 10%; left: 25%; animation-duration: 6s; }
    .particle2 { width: 100px; height: 100px; top: 50%; left: 60%; animation-duration: 7s; }
    .particle3 { width: 60px; height: 60px; top: 70%; left: 30%; animation-duration: 8s; }
    .particle4 { width: 120px; height: 120px; top: 20%; left: 75%; animation-duration: 9s; }
    .particle5 { width: 70px; height: 70px; top: 40%; left: 10%; animation-duration: 10s; }

    .line {
      position: absolute;
      background-color: rgba(138, 43, 226, 0.1);
      height: 2px;
      animation: lineMovement 10s infinite ease-in-out;
      box-shadow: 0 0 8px rgba(138, 43, 226, 0.4);
    }

    @keyframes lineMovement {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    .line1 { width: 30vw; top: 20%; left: 5%; animation-duration: 12s; }
    .line2 { width: 40vw; top: 50%; left: 10%; animation-duration: 15s; }
    .line3 { width: 50vw; top: 70%; left: 15%; animation-duration: 18s; }
  </style>
</head>
<body>

  <!-- Partículas e Linhas 
  <div class="particle particle1"></div>
  <div class="particle particle2"></div>
  <div class="particle particle3"></div>
  <div class="particle particle4"></div>
  <div class="particle particle5"></div>
  <div class="line line1"></div>
  <div class="line line2"></div>
  <div class="line line3"></div>
  -->

  <!-- Navbar -->
  <nav class="fixed top-0 left-0 w-full z-50 bg-black/30  border-b border-gray-700 shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
      <div class="text-lg font-semibold text-white tracking-wide">
        <span class="text-indigo-400">HYDRAX</span> | Painel de Endereços
      </div>
      <a href="{{ route('dashboard') }}"
         class="w-9 h-9 flex items-center justify-center rounded-full bg-indigo-600 hover:bg-indigo-700 transition-colors duration-300 shadow">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
    </div>
  </nav>

  <!-- Conteúdo Principal -->
  <div class="relative z-10 pt-28 pb-12 px-4 min-h-screen flex justify-center">
    <div class="bg-black/30 border border-gray-700 shadow-xl rounded-3xl p-8 w-full max-w-6xl">
      <h2 class="text-3xl font-bold text-center mb-6 text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-500 to-white">
        Endereços de {{ $usuario->nome_completo }}
      </h2>

      @if (session('success'))
        <div class="mb-4 text-green-400 font-semibold text-center">
          {{ session('success') }}
        </div>
      @endif

      @if ($usuario->enderecos->isEmpty())
        <p class="text-center text-white">Nenhum endereço cadastrado ainda.</p>
      @else
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left text-white border-collapse">
            <thead class="bg-indigo-800 text-white uppercase text-xs">
              <tr>
                <th class="px-4 py-3">Cidade</th>
                <th class="px-4 py-3">CEP</th>
                <th class="px-4 py-3">Bairro</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3">Rua</th>
                <th class="px-4 py-3">Número</th>
                <th class="px-4 py-3">Ações</th>
              </tr>
            </thead>
            <tbody class="bg-gray-900 bg-opacity-50 border-t border-gray-700">
              @foreach ($usuario->enderecos as $endereco)
                <tr class="hover:bg-gray-800 transition duration-200">
                  <td class="px-4 py-2">{{ $endereco->cidade }}</td>
                  <td class="px-4 py-2">{{ $endereco->cep }}</td>
                  <td class="px-4 py-2">{{ $endereco->bairro }}</td>
                  <td class="px-4 py-2">{{ $endereco->estado }}</td>
                  <td class="px-4 py-2">{{ $endereco->rua }}</td>
                  <td class="px-4 py-2">{{ $endereco->numero }}</td>
                  <td class="px-4 py-2 space-x-2">
                    <a href="{{ route('endereco.edit', ['id' => $usuario->id_usuarios, 'endereco_id' => $endereco->id_endereco]) }}"
                       class="text-blue-400 hover:text-blue-600 font-semibold">Editar</a>
                    <form action="{{ route('endereco.destroy', ['id' => $usuario->id_usuarios, 'endereco_id' => $endereco->id_endereco]) }}"
                          method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="text-red-400 hover:text-red-600 font-semibold ml-2">Excluir</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</body>
</html>
