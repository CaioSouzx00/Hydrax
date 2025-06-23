<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hydrax - Cadastro Endereço</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
  <style>
    @keyframes moveBackground {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    body {
      background: linear-gradient(45deg, rgb(23, 2, 28), rgb(28, 5, 53), #000000);
      background-size: 400% 400%;
      animation: moveBackground 15s ease infinite;
      position: relative;
      font-family: 'Poppins', sans-serif;
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
      z-index: -1;
    }
  </style>
</head>

<body class="min-h-screen overflow-hidden">
  
  <!-- Botão voltar -->
  <a href="{{route('dashboard')}}"
    class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-indigo-600 hover:bg-purple-700 transition-colors duration-300 shadow-[0_4px_20px_rgba(102,51,153,0.5)]"
    title="Voltar para o Dashboard">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

  <!-- Partículas -->
  <div id="particles-js"></div>

  <main class="flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-2xl bg-black/30 border border-purple-700/25 rounded-2xl shadow-[0_0_30px_rgba(139,92,246,0.05)] p-8">

      <h1
        class="text-3xl font-semibold text-center text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-500 to-indigo-200 mb-6">
        Cadastro de Endereço
      </h1>

      <!-- Mensagens de erro ou sucesso -->
      @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-6 rounded">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Formulário -->
      <form action="{{ route('endereco.store', ['id' => $usuario->id_usuarios]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">

       @csrf
      <input type="hidden" name="id_usuario" value="{{ $usuario->id }}">
        <div class="grid grid-cols-2 gap-4">
          <!-- Cidade -->
          <div>
            <label for="cidade"
              class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">Cidade</label>
            <input id="cidade" type="text" name="cidade" value="{{ old('cidade') }}" required minlength="3" maxlength="255"
              class="w-full mt-1 px-4 py-2 bg-gray-900/40 text-white/30 focus:text-white hover:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40" />
          </div>

          <!-- CEP -->
          <div>
            <label for="cep"
              class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">CEP</label>
            <input id="cep" type="cep" name="cep" value="{{ old('cep') }}" required minlength="8" required maxlength="8"
              class="w-full mt-1 px-4 py-2 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40" />
          </div>


          <!-- Bairro -->
          <div>
            <label for="bairro"
              class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">Bairro</label>
            <input id="bairro" type="text" name="bairro" value="{{ old('bairro') }}" required maxlength="15"
              class="w-full mt-1 px-4 py-2 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40" />
          </div>

          <!-- Estado -->
          <div>
            <label for="estado"
              class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">Estado (UF)</label>
            <input id="estado" type="text" name="estado" value="{{ old('estado') }}" required minlength="2" maxlength="2"
              class="w-full mt-1 px-4 py-2 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40" />
          </div>

          <!-- Rua -->
          <div>
            <label for="rua"
              class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">Rua</label>
            <input id="rua" type="text" name="rua" value="{{ old('rua') }}" required minlength="11" maxlength="11"
              class="w-full mt-1 px-4 py-2 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40" />
          </div>

          <!-- Número -->
<div>
  <label for="numero"
    class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">Número</label>
  <input id="numero" type="text" name="numero" value="{{ old('numero') }}" maxlength="255"
    class="w-full mt-1 px-4 py-2 bg-gray-900/40 text-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40" />
</div>
</div> <!-- <- Fecha grid-cols-2 -->

<!-- Botão de envio fora do grid -->
<button type="submit"
  class="relative w-full mt-6 py-3 inline-flex items-center justify-center text-lg font-medium bg-black/20 text-indigo-600 border-2 border-indigo-600 rounded-full hover:text-white group overflow-hidden">
  <span class="absolute left-0 block w-full h-0 transition-all bg-indigo-600 opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-400 ease"></span>
  <span class="absolute right-0 flex items-center justify-start w-10 h-10 duration-300 transform translate-x-full group-hover:translate-x-0 ease">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
    </svg>
  </span>
  <span class="relative">Cadastrar</span>
</button>

      </form>
      <p class="text-center">&copy; 2025 <strong>Hydrax</strong>. Todos os direitos reservados.</p>
    </div>
    <footer class="mt-6 flex justify-center text-xs text-gray-500">

</footer>
  </main>

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