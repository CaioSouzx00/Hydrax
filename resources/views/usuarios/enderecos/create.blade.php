<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SURA - Endereço</title>
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
      overflow: hidden;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
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
  <!-- Partículas e Linhas -->
  <div class="particle particle1"></div>
  <div class="particle particle2"></div>
  <div class="particle particle3"></div>
  <div class="particle particle4"></div>
  <div class="particle particle5"></div>

  <div class="line line1"></div>
  <div class="line line2"></div>
  <div class="line line3"></div>

  <!-- Botão de Voltar -->
  <a href="{{ route('dashboard') }}"
    class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-indigo-700 hover:bg-purple-600 transition-colors duration-300 shadow-md">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

  <!-- Formulário -->
  <main class="flex flex-col items-center justify-center w-full h-full">
    <section class="bg-black bg-opacity-50 backdrop-blur-md p-8 rounded-3xl shadow-2xl w-full max-w-lg text-white border border-gray-800">
      <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-white bg-[length:200%_200%] bg-left hover:bg-right transition-all duration-700 ease-in-out drop-shadow-xl mb-6 text-center">
        Cadastro de Endereço
      </h1>

      <!-- MENSAGENS -->
      @if (session('success'))
          <div class="bg-green-600 text-white p-4 mb-6 rounded shadow-md text-center font-semibold">
              {{ session('success') }}
          </div>
      @endif

      @if ($errors->has('limite'))
          <div class="bg-yellow-500 text-white p-4 mb-6 rounded shadow-md text-center font-semibold">
              ⚠️ {{ $errors->first('limite') }}
          </div>
      @endif

      @if ($errors->any() && !$errors->has('limite'))
          <div class="bg-red-600 text-white p-4 mb-6 rounded shadow-md">
              <ul class="list-disc list-inside">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      
        <form action="{{ route('endereco.store', ['id' => $usuario->id_usuarios]) }}" method="POST">

        @csrf
        <input type="hidden" name="id_usuario" value="{{ $usuario->id }}">

        <input type="text" name="cidade" placeholder="Cidade..." required
          class="w-full h-10 px-4 rounded-md border border-gray-700 bg-gray-800 text-white placeholder-gray-400 text-sm">

        <input type="text" name="cep" placeholder="CEP..." required maxlength="8" minlength="8"
          class="w-full h-10 px-4 rounded-md border border-gray-700 bg-gray-800 text-white placeholder-gray-400 text-sm">

        <input type="text" name="bairro" placeholder="Bairro..." required maxlength="50" minlength="2"
          class="w-full h-10 px-4 rounded-md border border-gray-700 bg-gray-800 text-white placeholder-gray-400 text-sm">

        <input type="text" name="estado" placeholder="Estado (UF)" maxlength="2" required maxlength="2" minlength="2"
          class="w-full h-10 px-4 rounded-md border border-gray-700 bg-gray-800 text-white placeholder-gray-400 text-sm">

        <input type="text" name="rua" placeholder="Rua..." required maxlength="50" minlength="2"
          class="w-full h-10 px-4 rounded-md border border-gray-700 bg-gray-800 text-white placeholder-gray-400 text-sm">

        <input type="text" name="numero" placeholder="Número..." required maxlength="12" minlength="1"
          class="w-full h-10 px-4 rounded-md border border-gray-700 bg-gray-800 text-white placeholder-gray-400 text-sm">

        <button type="submit"
          class="relative inline-flex items-center justify-start inline-block px-5 py-3 overflow-hidden font-bold rounded-full group">
          <span class="w-32 h-32 rotate-45 translate-x-12 -translate-y-2 absolute left-0 top-0 bg-white opacity-[3%]"></span>
          <span class="absolute top-0 left-0 w-48 h-48 -mt-1 transition-all duration-500 ease-in-out rotate-45 -translate-x-56 -translate-y-24 bg-white opacity-100 group-hover:-translate-x-8"></span>
          <span class="relative w-full text-left text-white transition-colors duration-200 ease-in-out group-hover:text-gray-900">Salvar</span>
          <span class="absolute inset-0 border-2 border-white rounded-full"></span>
        </button>
      </form>
    </section>

    <footer class="mt-12 text-sm text-gray-500 transition-all duration-700 ease-out hover:text-indigo-600 text-center">
      &copy; 2025 <strong>SURA</strong> - Sistema Unificado de Registro e Administração
    </footer>
  </main>
</body>
</html>