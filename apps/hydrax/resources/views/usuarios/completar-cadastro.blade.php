<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hydrax - Completar Cadastro</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    @keyframes moveBackground {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    body {
      background: linear-gradient(45deg, #211828, #0b282a, #17110d);
      background-size: 400% 400%;
      animation: moveBackground 15s ease infinite;
      font-family: 'Poppins', sans-serif;
      position: relative;
    }

    body::before {
      content: "";
      position: absolute;
      inset: 0;
      z-index: -2;
      background: linear-gradient(to top, rgba(0,0,0,0.6), transparent 60%);
    }

    #particles-js {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
  </style>
</head>

<body class="min-h-screen overflow-hidden">

<!-- Botão Voltar -->
<a href="{{ url()->previous() }}"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 hover:w-28 hover:bg-[#117c66]">
    <div class="flex items-center justify-center w-10 h-10">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </div>
    <span class="ml-2 opacity-0 group-hover:opacity-100 whitespace-nowrap transition-all duration-300">
        Voltar
    </span>
</a>

<div id="particles-js"></div>

<main class="flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-xl bg-black/30 border border-[#d5891b]/25 rounded-2xl shadow-[0_0_30px_rgba(139,92,246,0.05)] p-8">

        <h1 class="text-3xl font-semibold text-center text-transparent bg-clip-text bg-gradient-to-r from-[#d5891b] via-[#7f3a0e] to-[#d5891b] bg-[length:200%_200%] bg-left hover:bg-right transition-all duration-700 drop-shadow-2xl mb-6">
            Complete seu Cadastro
        </h1>

        <!-- Erros -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-6 rounded-lg">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="/completar-cadastro" class="space-y-6">
            @csrf

            <!-- SEXO -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Sexo</label>

                <select name="sexo"
                    class="w-full px-4 py-2 bg-gray-900/80 text-white border border-[#D5891B] rounded-lg 
                    focus:outline-none focus:ring-2 focus:ring-[#D5891B] hover:bg-[#2a2a2a]">
                    <option value="">Selecione</option>
                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                    <option value="O" {{ old('sexo') == 'O' ? 'selected' : '' }}>Outro</option>
                </select>
            </div>

            <!-- CPF -->
            <div>
                <label class="block text-sm font-medium text-gray-300">CPF</label>
                <input type="text" name="cpf" maxlength="11"
                    value="{{ old('cpf') }}"
                    class="w-full mt-1 px-4 py-2 bg-gray-900/80 text-white/80 border border-[#D5891B] 
                    rounded-lg hover:bg-[#2a2a2a] focus:outline-none focus:ring-2 focus:ring-[#D5891B]" />
            </div>

            <!-- TELEFONE -->
            <div>
                <label class="block text-sm font-medium text-gray-300">Telefone</label>
                <input type="text" name="telefone" maxlength="11"
                    value="{{ old('telefone') }}"
                    class="w-full mt-1 px-4 py-2 bg-gray-900/80 text-white/80 border border-[#D5891B] 
                    rounded-lg hover:bg-[#2a2a2a] focus:outline-none focus:ring-2 focus:ring-[#D5891B]" />
            </div>

            <!-- DATA NASCIMENTO -->
            <div>
                <label class="block text-sm font-medium text-gray-300">Data de nascimento</label>
                <input type="date" name="data_nascimento"
                    value="{{ old('data_nascimento') }}"
                    class="w-full mt-1 px-4 py-2 bg-gray-900/80 text-white/80 border border-[#D5891B] 
                    rounded-lg hover:bg-[#2a2a2a] focus:outline-none focus:ring-2 focus:ring-[#D5891B]" />
            </div>

            <!-- BOTÃO -->
            <button type="submit"
                class="relative w-full py-3 inline-flex items-center justify-center text-lg font-medium 
                bg-black/20 text-[#14ba88] border-2 border-[#14ba88] rounded-full hover:text-white 
                group overflow-hidden">
                <span class="absolute left-0 w-full h-0 bg-[#14ba88] opacity-100 group-hover:h-full top-1/2 
                group-hover:top-0 transition-all duration-300"></span>

                <span class="absolute right-0 flex items-center justify-start w-10 h-10 
                transform translate-x-full group-hover:translate-x-0 duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7-7 7M21 12H3"/>
                    </svg>
                </span>

                <span class="relative">Salvar</span>
            </button>
        </form>

    </div>
</main>

<footer class="mt-6 flex justify-center text-xs text-gray-500">
  <p class="text-center">&copy; 2025 <strong>Hydrax</strong>. Todos os direitos reservados.</p>
</footer>

<script>
particlesJS("particles-js", {
  particles: {
    number: { value: 60, density: { enable: true, value_area: 800 } },
    color: { value: "#000" },
    shape: { type: "polygon", polygon: { nb_sides: 5 } },
    opacity: { value: 0.5 },
    size: { value: 4, random: true, anim: { enable: true, speed: 5, size_min: 0.3 }},
    line_linked: { enable: false },
    move: { enable: true, speed: 1.5, direction: "bottom", out_mode: "out" }
  },
  interactivity: {
    events: { onhover: { enable: true, mode: "repulse" }, onclick: { enable: true, mode: "repulse" }},
    modes: { repulse: { distance: 100, duration: 0.4 }}
  }
});
</script>

</body>
</html>
