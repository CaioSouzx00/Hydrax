<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
  <title>Hydrax - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="h-screen overflow-hidden m-0 p-0 text-white font-sans bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] animate-[moveBackground_20s_linear_infinite]">


<a href="{{ route('home') }}"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#4a8978]"
   title="Voltar para Início" aria-label="Botão Voltar">

  <!-- Ícone sempre visível e centralizado -->
  <div class="flex items-center justify-center w-10 h-10 shrink-0">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </div>

  <!-- Texto invisível até o hover, mas com espaço reservado -->
  <span class="ml-2 w-0 group-hover:w-auto opacity-0 group-hover:opacity-100 overflow-hidden whitespace-nowrap transition-all duration-300 ease-in-out">
    Voltar
  </span>
</a>



  <!-- Container Principal -->
<div class="flex items-center justify-center w-full h-full px-4">
  <main class="flex flex-col lg:flex-row w-full max-w-7xl h-auto lg:h-[90%] bg-black/30 rounded-md border border-gray-800 p-4 lg:p-8 relative backdrop-blur-md shadow-[0_4px_20px_rgba(84,36,9,0.4)] overflow-hidden">

    <!-- Imagem -->
    <div class="hidden lg:flex w-1/2 items-center justify-center rounded-md bg-cover bg-center shadow-[0_4px_20px_rgba(84,36,9,0.3)] relative"
         style="background-image: url('/imagens/hydrax/lebronn20.jpeg');">
      <img src="/imagens/hydrax/HYDRA’x.png" alt="Logo Hydrax"
           class="absolute top-2 left-2 w-52 h-auto select-none pointer-events-none" />
    </div>

    <!-- Área de Login -->
    <div class="w-full lg:w-1/2 bg-black/20 rounded-md flex items-center justify-center p-6 sm:p-8 shadow-[0_4px_30px_rgba(84,36,9,0.4)]">
      <section class="p-4 sm:p-8 rounded-3xl w-full max-w-sm text-left">

        <div class="text-center max-w-md mx-auto space-y-3">
          <h2 class="text-sm text-[#f4b864]">Seja bem-vindo à</h2>
          <h1 class="text-3xl sm:text-4xl font-[Orbitron] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#d5891b] via-[#7f3a0e] to-white bg-[length:200%_200%] bg-left hover:bg-right transition-all duration-700 ease-in-out drop-shadow-2xl">
            Hydrax
          </h1>
          <h3 class="text-xs sm:text-sm text-gray-300">
            Acompanhe lançamentos em tempo real e descubra os tênis esportivos mais desejados do mercado.
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

        <form method="POST" action="{{ route('login.process') }}" class="space-y-4 mt-6">
          @csrf
          <div class="flex items-center space-x-3">
            <img src="/imagens/Post Jif 2025/4.png" alt="Ícone de e-mail" class="w-5 h-5">
            <input type="email" name="email" required placeholder="E-mail"
                   class="h-11 px-4 rounded-md border border-[#7f3a0e] bg-[#17110d]/40 text-white placeholder-gray-300 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#e29b37]">
          </div>

          <div class="flex items-center space-x-3 relative">
            <img src="/imagens/Post Jif 2025/5.png" alt="Ícone de senha" class="w-5 h-5">
            <input type="password" name="password" id="password" required placeholder="password"
                   class="h-11 px-4 pr-10 rounded-md border border-[#7f3a0e] bg-[#17110d]/40 text-white placeholder-gray-300 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#e29b37]">
            <button type="button" onclick="togglepassword()" class="absolute right-3 top-2 w-6 h-7">
              <img src="/imagens/Post Jif 2025.png" alt="Mostrar password" id="eye-icon" class="w-6 h-6 opacity-40 hover:opacity-80 transition-opacity">
            </button>
          </div>

          <div class="flex flex-col sm:flex-row justify-between items-center text-sm gap-2">
            <a href="{{ route('password.esqueciSenhaForm') }}" class="text-[#d5891b] hover:text-[#7f3a0e] transition">Esqueceu sua senha?</a>
            <button type="submit"
                    class="relative px-5 py-2 border-2 border-[#d5891b] text-[#e29b37] rounded-xl hover:text-white hover:bg-[#7f3a0e] hover:border-[#7f3a0e] transition-all duration-300">
              Entrar
            </button>
          </div>
        </form>

        <div class="mt-4 text-sm text-center">
          <p>Não possui conta?
            <a href="{{ route('usuarios.create') }}" class="text-[#d5891b] hover:text-[#7f3a0e] transition">Cadastrar</a>
          </p>
        </div>

        <footer class="mt-16 text-center text-xs text-white/60 hover:text-indigo-300 transition duration-300">
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