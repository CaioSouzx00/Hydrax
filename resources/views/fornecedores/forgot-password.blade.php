<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hydrax - Recuperação de Senha</title>

  <!-- Tailwind CSS e Fonte -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">

  <!-- Estilos personalizados -->
  <style>
    @keyframes moveBackground {
      0%, 100% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
    }

    @keyframes particleMovement {
      0%, 100% { transform: translate(-50%, -50%) scale(0.8); }
      50% { transform: translate(50%, 50%) scale(1.5); }
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(155, 89, 255, 0.08);
      box-shadow: 0 0 15px rgba(150, 90, 255, 0.2);
      opacity: 0.7;
      pointer-events: none;
      animation: particleMovement 5s ease-in-out infinite;
    }

    .particle1 { width: 100px; height: 100px; top: 10%; left: 25%; animation-duration: 6s; }
    .particle2 { width: 120px; height: 120px; top: 50%; left: 60%; animation-duration: 7s; }
    .particle3 { width: 80px; height: 80px; top: 70%; left: 30%; animation-duration: 8s; }
    .particle4 { width: 150px; height: 150px; top: 20%; left: 75%; animation-duration: 9s; }
    .particle5 { width: 90px; height: 90px; top: 40%; left: 10%; animation-duration: 10s; }

    .line {
      position: absolute;
      background-color: rgba(155, 89, 255, 0.08);
      height: 2px;
      animation: lineMovement 10s infinite ease-in-out;
      box-shadow: 0 0 8px rgba(155, 89, 255, 0.3);
    }

    @keyframes lineMovement {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    .line1 { width: 50vw; top: 20%; left: 5%; animation-duration: 12s; }
    .line2 { width: 60vw; top: 50%; left: 10%; animation-duration: 15s; }
    .line3 { width: 70vw; top: 70%; left: 15%; animation-duration: 18s; }
  </style>
</head>

<body class="h-screen overflow-hidden text-white bg-gradient-to-br from-[#1b1444] via-[#3b0f70] to-[#1c1a6e] animate-[moveBackground_20s_linear_infinite]">

  <!-- Partículas -->
  <div class="particle particle1"></div>
  <div class="particle particle2"></div>
  <div class="particle particle3"></div>
  <div class="particle particle4"></div>
  <div class="particle particle5"></div>

  <!-- Linhas decorativas -->
  <div class="line line1"></div>
  <div class="line line2"></div>
  <div class="line line3"></div>

  <!-- Botão voltar -->
  <a href="{{ route('fornecedores.login') }}"
     class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-indigo-600 hover:bg-purple-700 transition-colors duration-300 shadow-[0_4px_20px_rgba(102,51,153,0.5)]"
     title="Voltar para o login">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

  <!-- Container principal -->
  <div class="flex items-center justify-center w-full h-full px-4">
    <main class="flex w-full max-w-6xl h-[90%] bg-black/30 rounded-md border border-purple-800 p-8 relative backdrop-blur-md shadow-[0_4px_20px_rgba(128,0,128,0.4)]">
      
      <!-- Lado esquerdo: Formulário -->
      <div class="w-1/2 bg-black/20 rounded-md flex items-center justify-center p-8">
        <section class="p-6 w-full max-w-sm space-y-4">
          
          <!-- Título -->
          <div class="text-center mb-6">
            <h2 class="text-3xl font-[Orbitron] text-indigo-400 mb-2">Recuperação de Senha</h2>
            <p class="text-sm text-gray-300">Informe seu e-mail para receber o código</p>
          </div>

          <!-- Mensagens de retorno -->
          @if(session('success'))
            <div class="text-center bg-green-500/50 text-white p-4 mb-6 rounded border-2 border-green-500">
              {{ session('success') }}
            </div>
          @elseif($errors->any())
            <div class="text-center bg-red-500/50 text-white p-4 mb-6 rounded border-2 border-red-500">
              @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif

          <!-- Formulário -->
          <form method="POST" action="{{ route('fornecedores.senha.enviar') }}" class="space-y-4">

            @csrf
            <input type="email" name="email" required placeholder="Digite seu e-mail"
              class="h-11 px-4 rounded-md border border-purple-500 bg-gray-900/60 text-white placeholder-gray-400 text-sm w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">

            <button type="submit"
              class="relative w-full rounded px-5 py-2.5 overflow-hidden group bg-indigo-500 hover:bg-gradient-to-r hover:from-indigo-500 hover:to-indigo-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-indigo-400 transition-all ease-out duration-300">
              <span
                class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease">
              </span>
              <span class="relative">Enviar Código</span>
            </button>
          </form>

          <!-- Rodapé -->
          <footer class="mt-12 text-center text-xs text-white/60 hover:text-indigo-300 transition duration-300">
            &copy; 2025 <strong>Hydrax</strong> - Todos os direitos reservados
          </footer>
        </section>
      </div>

      <!-- Lado direito: Imagem -->
      <div class="w-1/2 flex items-center justify-center rounded-md bg-cover bg-center shadow-[0_4px_20px_rgba(100,0,255,0.3)]"
           style="background-image: url('/imagens/Post Jif 2025 (6).png');">
      </div>

    </main>
  </div>

</body>
</html>