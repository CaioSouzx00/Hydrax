<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hydrax - Cadastro de Fornecedor</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
</head>
<style>
  @keyframes moveBackground {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  body {
    background: linear-gradient(45deg,rgb(23, 2, 28),rgb(28, 5, 53), #000000);
    background-size: 400% 400%;
    animation: moveBackground 15s ease infinite;
    position: relative;
    z-index: 1; /* Garante que o conteúdo esteja por cima do fundo */
  }

  body::before {
      content: "";
      position: absolute;
      inset: 0;
      z-index: -2;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent 60%);
    }

  #particles-js {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1; /* Faz com que o fundo de partículas fique atrás do conteúdo */
  }
</style>
<body class="min-h-screen overflow-hidden">

  <!-- Botão voltar -->
  <a href="{{ route('fornecedores.login') }} "
     class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-indigo-600 hover:bg-purple-700 transition-colors duration-300 shadow-[0_4px_20px_rgba(102,51,153,0.5)]"
     title="Voltar para o login">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

  <!-- Container -->
  <div class="flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-2xl bg-black/30 border border-purple-700/25 rounded-2xl shadow-xl p-8">

      <!-- Título -->
      <h1 class="text-3xl font-semibold text-center text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-500 to-indigo-200 mb-6">
        Cadastro de Fornecedor
      </h1>

      <!-- Mensagens -->
      @if (session('success'))
        <div class="bg-green-500/20 border border-green-500 text-green-200 px-4 py-2 rounded mb-4 text-sm">
          {{ session('success') }}
        </div>
      @endif

      @if (session('error'))
        <div class="bg-red-500/20 border border-red-500 text-red-200 px-4 py-2 rounded mb-4 text-sm">
          {{ session('error') }}
        </div>
      @endif

      
@if ($errors->any())
  <div class="bg-red-500/20 border border-red-500 text-red-200 px-4 py-2 rounded mb-4 text-sm">
    <ul class="list-disc list-inside">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

      <!-- Formulário -->
      <form method="POST" action="{{ route('fornecedores.store') }}" class="space-y-4">
        @csrf

        <div class="relative">
          <label class="block text-sm font-medium text-gray-300">Nome da Empresa</label>
          <input type="text" name="nome_empresa" required maxlength="50" class="w-full mt-1 px-4 py-2 pr-10 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40"/>
        </div>

        <div class="relative">
          <label class="block text-sm font-medium text-gray-300">E-mail</label>
          <input type="email" name="email" required maxlength="60" class="w-full mt-1 px-4 py-2 pr-10 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40"/>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="relative">
            <label class="block text-sm font-medium text-gray-300">Telefone</label>
            <input type="text" name="telefone" required minlength="10" maxlength="15" class="w-full mt-1 px-4 py-2 pr-10 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40"/>
          </div>
          <div class="relative">
            <label class="block text-sm font-medium text-gray-300">CNPJ</label>
            <input type="text" name="cnpj" required minlength="14" maxlength="14" class="w-full mt-1 px-4 py-2 pr-10 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40"/>
          </div>
        </div>

        <div class="relative">
          <label class="block text-sm font-medium text-gray-300">Senha</label>
          <input id="password" type="password" name="password" required minlength="6" class="w-full mt-1 px-4 py-2 pr-10 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40" />
          <div class="relative">
          <label class="block text-sm font-medium text-gray-300">Confirme a Senha</label>
          <input id="password_confirmation" type="password" name="password_confirmation" required minlength="6" class="w-full mt-1 px-4 py-2 pr-10 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40" />
          </div>

          
          <!-- Botão de alternar senha -->
          <button type="button" onclick="togglepassword('password')" class="absolute right-3 top-[33px] w-6 h-6">
            <img src="/imagens/Post Jif 2025.png" alt="Mostrar senha" id="eye-icon" class="w-6 h-6 opacity-40 hover:opacity-80 transition-opacity">
          </button>
        </div>
        <!-- Botão de envio -->
        <button type="submit"
          class="relative w-full mt-4 py-3 inline-flex items-center justify-center text-lg font-medium bg-black/20 text-indigo-600 border-2 border-indigo-600 rounded-full hover:text-white group overflow-hidden">
          <span class="absolute left-0 block w-full h-0 transition-all bg-indigo-600 opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-400 ease"></span>
          <span class="absolute right-0 flex items-center justify-start w-10 h-10 duration-300 transform translate-x-full group-hover:translate-x-0 ease">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
          </span>
          <span class="relative">Cadastrar</span>
        </button>

      </form>

      <p class="text-xs text-center text-gray-400 mt-6">
        Após o cadastro, você receberá um e-mail com a aprovação para vender na plataforma.
      </p>

      <footer class="mt-6 text-center text-xs text-gray-500">
        &copy; 2025 <strong>Hydrax</strong>. Todos os direitos reservados.
      </footer>
    </div>
  </div>
  <div id="particles-js"></div>

  <script>
    particlesJS("particles-js", {
      particles: {
        number: { value: 60, density: { enable: true, value_area: 800 } },
        color: { value: "#000" },
        shape: { type: "polygon", polygon: { nb_sides: 5 } },
        opacity: { value: 0.5, random: false },
        size: {
          value: 4,
          random: true,
          anim: { enable: true, speed: 5, size_min: 0.3, sync: false }
        },
        line_linked: { enable: false },
        move: {
          enable: true,
          speed: 1.5,
          direction: "bottom",
          random: false,
          straight: false,
          out_mode: "out",
          bounce: false
        }
      },
      interactivity: {
        detect_on: "canvas",
        events: {
          onhover: { enable: true, mode: "repulse" },
          onclick: { enable: true, mode: "repulse" },
          resize: true
        },
        modes: { repulse: { distance: 100, duration: 0.4 } }
      },
      retina_detect: true
    });
  </script>
      <!-- Script -->
      <script>
    function togglepassword(inputId) {
      const input = document.getElementById(inputId);
      const icon = input.nextElementSibling.querySelector("img");

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