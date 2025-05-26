<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hydrax - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

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

  .particle {
    position: absolute;
    border-radius: 50%;
    background: rgba(113, 113, 253, 0.1);
    box-shadow: 0 0 15px rgba(100, 100, 255, 0.2);
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
    background-color: rgba(138, 43, 226, 0.1);
    height: 2px;
    animation: lineMovement 10s infinite ease-in-out;
    box-shadow: 0 0 8px rgba(138, 43, 226, 0.4);
  }

  @keyframes lineMovement {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
  }

  .line1 { width: 50vw; top: 20%; left: 5%; animation-duration: 12s; }
  .line2 { width: 60vw; top: 50%; left: 10%; animation-duration: 15s; }
  .line3 { width: 70vw; top: 70%; left: 15%; animation-duration: 18s; }
</style>

<body class="h-screen overflow-hidden m-0 p-0 text-white font-sans bg-gradient-to-br from-[#2a2344] via-[#3a276b] to-[#2d2662] animate-[moveBackground_20s_linear_infinite]">
  <!-- Partículas -->
  <div class="particle particle1"></div>
  <div class="particle particle2"></div>
  <div class="particle particle3"></div>
  <div class="particle particle4"></div>
  <div class="particle particle5"></div>

  <!-- Linhas -->
  <div class="line line1"></div>
  <div class="line line2"></div>
  <div class="line line3"></div>

  <!-- Botão voltar -->
  <a href="http://127.0.0.1:8080"
     class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-purple-500 hover:bg-purple-300 transition-colors duration-300 shadow-[0_4px_20px_rgba(30,64,175,0.4)]"
     title="Voltar para o painel">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

  <!-- Container Principal -->
  <div class="flex items-center justify-center w-full h-full">
    <main class="flex w-full max-w-7xl h-[90%] bg-black/30 rounded-md border border-gray-800 p-8 relative backdrop-blur-md shadow-[0_4px_20px_rgba(30,64,175,0.4)]">

      <!-- Imagem -->
      <div class="w-1/2 rounded-md flex items-center justify-center bg-cover bg-center shadow-[0_4px_20px_rgba(30,58,138,0.3)]" style="background-image: url('/imagens/Post Jif 2025 (2).gif');"></div>

      <!-- Área de Login com imagem de fundo -->
      <div class="w-1/2 rounded-md bg-black/20 flex items-center justify-center p-8 shadow-[0_4px_30px_rgba(30,58,138,0.4)] bg-cover bg-center">
        <section class="p-8 rounded-3xl w-full max-w-sm text-left">

          <div class="text-center max-w-md mx-auto space-y-3">
          <h2 class="text-2xl font-[Orbitron] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-500 to-indigo-200 bg-[length:200%_200%] bg-left hover:bg-right transition-all duration-700 ease-in-out drop-shadow-2xl">
              Olá, Administrador
            </h2>
            <h2 class="text-sm text-indigo-300">Seja bem-vindo à</h2>
            <h1 class="text-4xl font-[Orbitron] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-white bg-[length:200%_200%] bg-left hover:bg-right transition-all duration-700 ease-in-out drop-shadow-2xl">
              Hydrax
            </h1>
            <h3 class="text-sm text-gray-300">
            Acesse o painel de controle e gerencie usuários, produtos e estatísticas da plataforma com segurança e eficiência.
            </h3>
          </div>

          <div class="h-5"></div>

          @if ($errors->any())
            <div class="text-center bg-red-500/50 text-white p-4 mb-6 rounded border-2 border-red-500">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('admin.login') }}" class="space-y-4 mt-6">
            @csrf
            <div class="flex items-center space-x-3">
              <img src="/imagens/Post Jif 2025/7.png" alt="Ícone de usuario" class="w-6 h-6">
              <input type="text" name="nome_usuario" value="{{ old('nome_usuario') }}" required placeholder="Nome de Usuário"
                     class="h-11 px-4 rounded-md border border-purple-500 bg-gray-800/60 text-white placeholder-gray-300 text-sm w-full focus:outline-none focus:ring-2 focus:ring-purple-400">
            </div>

            <div class="flex items-center space-x-3 relative">
              <img src="/imagens/Post Jif 2025/5.png" alt="Ícone de senha" class="w-6 h-6">
              <input type="password" name="password" id="password" required placeholder="Senha"
                     class="h-11 px-4 pr-10 rounded-md border border-purple-400 bg-gray-800/60 text-white placeholder-gray-300 text-sm w-full focus:outline-none focus:ring-2 focus:ring-purple-300">
              <button type="button" onclick="togglepassword()" class="absolute right-3 top-2 w-6 h-6">
                <img src="/imagens/Post Jif 2025.png" alt="Mostrar senha" id="eye-icon" class="w-6 h-6 opacity-40 hover:opacity-80 transition-opacity">
              </button>
            </div>

            <div class="flex justify-between items-center text-sm">
              <a href="#" class="text-indigo-400 hover:text-indigo-600 transition"></a>
              <button type="submit"
                      class="relative px-5 py-2 border-2 border-purple-500 text-purple-400 rounded-xl hover:text-white hover:bg-purple-600 transition-all duration-300">
                Entrar
              </button>
            </div>
          </form>
          <footer class="mt-16 text-center text-xs text-white/60 hover:text-purple-300 transition duration-300">
            &copy; 2025 <strong>Hydrax</strong> - Todos os direitos reservados
          </footer>

        </section>
      </div>
    </main>
  </div>

  <script>
    function togglepassword() {
      const input = document.getElementById("password");
      const icon = document.getElementById("eye-icon");

      if (input.type === "password") {
        input.type = "text";
        icon.src = "/imagens/Post Jif 2025 (2).png";
        icon.alt = "Ocultar senha";
      } else {
        input.type = "password";
        icon.src = "/imagens/Post Jif 2025.png";
        icon.alt = "Mostrar senha";
      }
    }
  </script>
</body>
</html>