<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
  <title>Hydrax - Cadastro Usuário</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
      background: linear-gradient(45deg, #211828, #0b282a, #17110d);
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
<a href="{{ url()->previous() }}"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#117c66]"
   title="Voltar" aria-label="Botão Voltar">
    <div class="flex items-center justify-center w-10 h-10 shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </div>
    <span class="ml-2 w-0 group-hover:w-auto opacity-0 group-hover:opacity-100 overflow-hidden whitespace-nowrap transition-all duration-300 ease-in-out">
        Voltar
    </span>
</a>

  <!-- Texto invisível até o hover, mas com espaço reservado -->
  <span class="ml-2 w-0 group-hover:w-auto opacity-0 group-hover:opacity-100 overflow-hidden whitespace-nowrap transition-all duration-300 ease-in-out">
    Voltar
  </span>
</a>

  <!-- Partículas -->
  <div id="particles-js"></div>

  <main class="flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-2xl bg-black/30 border border-[#d5891b]/25 rounded-2xl shadow-[0_0_30px_rgba(139,92,246,0.05)] p-8">

      <h1
        class="text-3xl font-semibold text-center text-transparent bg-clip-text bg-gradient-to-r from-[#d5891b] via-[#7f3a0e] to-[#d5891b] bg-[length:200%_200%] bg-left hover:bg-right transition-all duration-700 ease-in-out drop-shadow-2xl mb-6">
        Cadastro de Usuário
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
      <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">

       @csrf

        <div class="grid grid-cols-2 gap-4">
<!-- Nome completo -->
<div>
  <label for="nome_completo"
    class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">Nome Completo</label>
  <input id="nome_completo" type="text" name="nome_completo" value="{{ old('nome_completo') }}" required minlength="3" maxlength="255"
    class="w-full mt-1 px-4 py-2 bg-gray-900/80 text-white/30 focus:text-white hover:text-white border border-[#D5891B] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5891B] focus:bg-[#2a2a2a]" />
</div>

<!-- Sexo -->
<div class="w-full relative" id="custom-select-sexo" style="max-width: 320px;">
  <label for="custom-select-button" class="block text-sm font-medium text-gray-300 mb-1 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">Sexo</label>

  <button
    type="button"
    id="custom-select-button"
    aria-haspopup="listbox"
    aria-expanded="false"
    class="w-full bg-gray-900/80 text-white/90 py-2 px-4 rounded-lg border border-[#D5891B] focus:outline-none focus:ring-2 focus:ring-[#D5891B] focus:bg-[#2a2a2a] flex justify-between items-center"
  >
    <span id="custom-select-selected">Selecione seu sexo</span>
    <svg class="w-5 h-5 text-[#D5891B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
      stroke-linecap="round" stroke-linejoin="round">
      <path d="M6 9l6 6 6-6" />
    </svg>
  </button>

  <ul
    id="custom-select-options"
    role="listbox"
    tabindex="-1"
    class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-gray-900/95 border border-[#D5891B] text-white shadow-lg hidden"
  >
    <li
      role="option"
      data-value="masculino"
      class="cursor-pointer px-4 py-2 bg-gray-800 hover:bg-[#14ba88] hover:text-white"
      tabindex="0"
    >Masculino</li>
    <li
      role="option"
      data-value="feminino"
      class="cursor-pointer px-4 py-2 bg-gray-800 hover:bg-[#14ba88] hover:text-white"
      tabindex="0"
    >Feminino</li>
    <li
      role="option"
      data-value="outro"
      class="cursor-pointer px-4 py-2 bg-gray-800 hover:bg-[#14ba88] hover:text-white"
      tabindex="0"
    >Outro</li>
  </ul>

  <input type="hidden" name="sexo" id="custom-select-input" value="" />
</div>

<script>
  (function() {
    const selectButton = document.getElementById('custom-select-button');
    const optionsList = document.getElementById('custom-select-options');
    const selectedSpan = document.getElementById('custom-select-selected');
    const hiddenInput = document.getElementById('custom-select-input');
    let isOpen = false;

    function toggleDropdown() {
      isOpen = !isOpen;
      optionsList.style.display = isOpen ? 'block' : 'none';
      selectButton.setAttribute('aria-expanded', isOpen);
    }

    function closeDropdown() {
      isOpen = false;
      optionsList.style.display = 'none';
      selectButton.setAttribute('aria-expanded', false);
    }

    selectButton.addEventListener('click', () => {
      toggleDropdown();
    });

    // Fecha dropdown se clicar fora
    document.addEventListener('click', (e) => {
      if (!document.getElementById('custom-select-sexo').contains(e.target)) {
        closeDropdown();
      }
    });

    // Selecionar opção
    optionsList.querySelectorAll('li').forEach(option => {
      option.addEventListener('click', () => {
        const value = option.getAttribute('data-value');
        const label = option.textContent;

        hiddenInput.value = value;
        selectedSpan.textContent = label;
        closeDropdown();
      });

      // Seleção via teclado (Enter ou Espaço)
      option.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          option.click();
          selectButton.focus();
        }
      });
    });

    // Acessibilidade básica para abrir/fechar dropdown com teclado
    selectButton.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
        e.preventDefault();
        if (!isOpen) {
          toggleDropdown();
          optionsList.querySelector('li').focus();
        }
      } else if (e.key === 'Escape') {
        closeDropdown();
        selectButton.focus();
      }
    });
  })();
</script>

<!-- Data de nascimento -->
<div>
  <label for="data_nascimento"
    class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">Data de Nascimento</label>
  <input id="data_nascimento" type="date" name="data_nascimento" value="{{ old('data_nascimento') }}" required
    class="w-full mt-1 px-4 py-2 bg-gray-900/80 text-white/30 hover:text-white border border-[#D5891B] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5891B] focus:bg-[#2a2a2a] focus:text-white" />
</div>

<!-- Email -->
<div>
  <label for="email"
    class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">E-mail</label>
  <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="255"
    class="w-full mt-1 px-4 py-2 bg-gray-900/80 text-white/30 hover:text-white focus:text-white border border-[#D5891B] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5891B] focus:bg-[#2a2a2a]" />
</div>

<!-- Senha -->
<div class="relative">
  <label for="password"
    class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">Senha</label>
  <input id="password" type="password" name="password" required minlength="6"
    class="w-full mt-1 px-4 py-2 pr-10 bg-gray-900/80 text-white/30 hover:text-white focus:text-white border border-[#D5891B] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5891B] focus:bg-[#2a2a2a]" />
  <button type="button" onclick="togglepassword('password')" class="absolute right-3 top-[33px] w-6 h-6">
    <img src="/imagens/Post Jif 2025.png" alt="Mostrar senha" id="eye-icon" class="w-6 h-6 opacity-40 hover:opacity-80 transition-opacity">
  </button>
</div>

<!-- Telefone -->
<div>
  <label for="telefone"
    class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">Telefone</label>
  <input id="telefone" type="text" name="telefone" value="{{ old('telefone') }}" required maxlength="11"
    class="w-full mt-1 px-4 py-2 bg-gray-900/80 text-white/30 hover:text-white focus:text-white border border-[#D5891B] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5891B] focus:bg-[#2a2a2a]" />
</div>

<!-- CPF -->
<div>
  <label for="cpf"
    class="block text-sm font-medium text-gray-300 drop-shadow-[0_0_2px_rgba(139,92,246,0.4)]">CPF</label>
  <input id="cpf" type="text" name="cpf" value="{{ old('cpf') }}" required minlength="11" maxlength="11"
    class="w-full mt-1 px-4 py-2 bg-gray-900/80 text-white/30 hover:text-white focus:text-white border border-[#D5891B] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D5891B] focus:bg-[#2a2a2a]" />
</div>


        <!-- Botão de envio -->
        <button type="submit"
          class="relative w-full mt-4 py-3 inline-flex items-center justify-center text-lg font-medium bg-black/20 text-[#14ba88] border-2 border-[#14ba88] rounded-full hover:text-white group overflow-hidden">
          <span class="absolute left-0 block w-full h-0 transition-all bg-[#14ba88] opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-400 ease"></span>
          <span class="absolute right-0 flex items-center justify-start w-10 h-10 duration-300 transform translate-x-full group-hover:translate-x-0 ease">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
          </span>
          <span class="relative">Cadastrar</span>
        </button>
      </form>
    </div>
    <footer class="mt-6 flex justify-center text-xs text-gray-500">
  <p class="text-center">&copy; 2025 <strong>Hydrax</strong>. Todos os direitos reservados.</p>
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