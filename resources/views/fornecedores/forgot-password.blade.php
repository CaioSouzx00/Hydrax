<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hydrax - Recuperação de Senha</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">

  <style>
    @keyframes moveBackground {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes particleMovement {
      0% { transform: translate(-50%, -50%) scale(0.8); }
      50% { transform: translate(50%, 50%) scale(1.3); }
      100% { transform: translate(-50%, -50%) scale(0.8); }
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(20, 186, 136, 0.03);
      box-shadow: 0 0 8px rgba(20, 186, 136, 0.08);
      opacity: 0.3;
      pointer-events: none;
      animation: particleMovement 8s ease-in-out infinite;
    }

    .particle1 { width: 80px; height: 80px; top: 10%; left: 25%; animation-duration: 10s; }
    .particle2 { width: 100px; height: 100px; top: 55%; left: 60%; animation-duration: 12s; }
    .particle3 { width: 70px; height: 70px; top: 75%; left: 35%; animation-duration: 13s; }

    .line {
      position: absolute;
      background-color: rgba(20, 186, 136, 0.04);
      height: 1px;
      animation: lineMovement 20s infinite linear;
      box-shadow: 0 0 4px rgba(20, 186, 136, 0.05);
    }

    @keyframes lineMovement {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    .line1 { width: 50vw; top: 25%; left: 5%; animation-duration: 25s; }
    .line2 { width: 60vw; top: 50%; left: 10%; animation-duration: 30s; }
    .line3 { width: 70vw; top: 70%; left: 15%; animation-duration: 35s; }
  </style>
</head>

<body class="h-screen overflow-hidden text-white bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] animate-[moveBackground_30s_linear_infinite]">

<!-- Partículas e linhas decorativas -->
<div class="particle particle1"></div>
<div class="particle particle2"></div>
<div class="particle particle3"></div>
<div class="line line1"></div>
<div class="line line2"></div>
<div class="line line3"></div>

<!-- Botão voltar -->
<a href="{{ route('fornecedores.login') }}"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#117c66]"
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

<!-- Conteúdo principal -->
<div class="flex items-center justify-center w-full h-full px-4">
  <main class="flex w-full max-w-6xl h-[90%] bg-[#111]/40 rounded-md border border-[#14ba88]/20 p-8 relative backdrop-blur-md shadow-[0_2px_10px_rgba(20,186,136,0.1)]">

    <!-- Formulário -->
    <div class="w-1/2 bg-black/20 rounded-md flex items-center justify-center p-8">
      <section class="p-6 w-full max-w-sm space-y-4">

        <div class="text-center mb-6">
          <h2 class="text-3xl font-[Orbitron] text-[#14ba88]/80 mb-2">Recuperação de Senha</h2>
          <p class="text-sm text-gray-400">Informe seu e-mail para receber o código</p>
        </div>

        @if(session('success'))
          <div class="text-center bg-[#14ba88]/10 text-[#14ba88] p-4 mb-6 rounded border border-[#14ba88]/40 text-sm">
            {{ session('success') }}
          </div>
        @elseif($errors->any())
          <div class="text-center bg-red-600/20 text-white p-4 mb-6 rounded border border-red-500/50 text-sm">
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <form method="POST" action="{{ route('fornecedores.senha.enviar') }}" class="space-y-4">
          @csrf
          <input type="email" name="email" required placeholder="Digite seu e-mail"
            class="h-11 px-4 rounded-md border border-[#14ba88]/30 bg-[#1a1a1a]/70 text-white placeholder-gray-400 text-sm w-full focus:outline-none focus:ring-1 focus:ring-[#14ba88]/60">

          <button type="submit"
            class="relative w-full rounded px-5 py-2.5 overflow-hidden group bg-[#14ba88] hover:bg-gradient-to-r hover:from-[#14ba88] hover:to-[#6ee7c8] text-white hover:ring-2 hover:ring-offset-2 hover:ring-[#6ee7c8] transition-all ease-out duration-300">
            <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
            <span class="relative">Enviar Código</span>
          </button>
        </form>

        <footer class="mt-12 text-center text-xs text-white/40 hover:text-[#14ba88]/70 transition duration-300">
          &copy; 2025 <strong>Hydrax</strong> - Todos os direitos reservados
        </footer>
      </section>
    </div>

    <!-- Imagem decorativa -->
    <div class="w-1/2 flex items-center justify-center rounded-md bg-cover bg-center bg-black/20"
         style="background-image: url('/imagens/hydrax/RcSenha.png');">
    </div>

  </main>
</div>

</body>
</html>
