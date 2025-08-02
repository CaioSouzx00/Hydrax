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
    background: rgba(255, 255, 255, 0.02);
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.05);
    opacity: 0.5;
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
    background-color: rgba(255, 255, 255, 0.03);
    height: 2px;
    animation: lineMovement 10s infinite ease-in-out;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.1);
  }

  @keyframes lineMovement {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
  }

  .line1 { width: 50vw; top: 20%; left: 5%; animation-duration: 12s; }
  .line2 { width: 60vw; top: 50%; left: 10%; animation-duration: 15s; }
  .line3 { width: 70vw; top: 70%; left: 15%; animation-duration: 18s; }
</style>

<body class="h-screen overflow-hidden m-0 p-0 text-white font-sans bg-gradient-to-br from-[#1a1a1a] via-[#101010] to-[#0a0a0a] animate-[moveBackground_20s_linear_infinite]">

<a href="http://127.0.0.1:8080"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-gray-700 text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-gray-500"
   title="Voltar para Início" aria-label="Botão Voltar">
  <div class="flex items-center justify-center w-10 h-10 shrink-0">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </div>
  <span class="ml-2 w-0 group-hover:w-auto opacity-0 group-hover:opacity-100 overflow-hidden whitespace-nowrap transition-all duration-300 ease-in-out">
    Voltar
  </span>
</a>

<div class="flex items-center justify-center w-full h-full">
  <main class="flex w-full max-w-7xl h-[90%] bg-black/30 rounded-md border border-gray-700 p-8 relative backdrop-blur-md shadow-[0_4px_20px_rgba(255,255,255,0.05)]">
    
    <!-- Imagem -->
    <div class="w-1/2 rounded-md flex items-center justify-center bg-cover bg-center shadow-[0_4px_20px_rgba(255,255,255,0.1)]" style="background-image: url('/imagens/hydrax/kobe8.jpeg');">
      <img src="/imagens/hydrax/HYDRA’x.png" alt="Logo Hydrax" class="absolute bottom-10 left-10 w-52 h-auto select-none pointer-events-none drop-shadow-[0_2px_4px_rgba(0,0,0,1)]" />
    </div>

    <!-- Área de Login -->
    <div class="w-1/2 rounded-md bg-black/20 flex items-center justify-center p-8 shadow-[0_4px_30px_rgba(255,255,255,0.1)] bg-cover bg-center">

      <section class="p-8 rounded-3xl w-full max-w-sm text-left">
        <div class="text-center max-w-md mx-auto space-y-3">
          <h2 class="text-2xl font-[Orbitron] font-extrabold text-white drop-shadow-lg">Olá, Administrador</h2>
          <h2 class="text-sm text-gray-400">Seja bem-vindo à</h2>
          <h1 class="text-4xl font-[Orbitron] font-extrabold text-white drop-shadow-2xl">Hydrax</h1>
          <h3 class="text-sm text-gray-400">
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
                   class="h-11 px-4 rounded-md border border-gray-500 bg-[#1a1a1a]/80 text-white placeholder-gray-500 text-sm w-full focus:outline-none focus:ring-2 focus:ring-gray-600">
          </div>

          <div class="flex items-center space-x-3 relative">
            <img src="/imagens/Post Jif 2025/5.png" alt="Ícone de senha" class="w-6 h-6">
            <input type="password" name="password" id="password" required placeholder="Senha"
                   class="h-11 px-4 pr-10 rounded-md border border-gray-500 bg-[#1a1a1a]/80 text-white placeholder-gray-500 text-sm w-full focus:outline-none focus:ring-2 focus:ring-gray-600">
            <button type="button" onclick="togglepassword()" class="absolute right-3 top-[0.625rem] w-6 h-6">
              <img src="/imagens/Post Jif 2025.png" alt="Mostrar senha" id="eye-icon" class="w-6 h-6 opacity-40 hover:opacity-80 transition-opacity">
            </button>
          </div>

          <div class="flex justify-between items-center text-sm">
            <div></div>
            <button type="submit"
                    class="relative px-5 py-2 border-2 border-gray-500 text-white rounded-xl hover:bg-gray-700 hover:border-gray-700 transition-all duration-300">
              Entrar
            </button>
          </div>
        </form>

        <footer class="mt-16 text-center text-xs text-white/40 hover:text-white transition duration-300">
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
