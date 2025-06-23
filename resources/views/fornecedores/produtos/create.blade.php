<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cadastro de Produto</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
  <style>
    @keyframes moveBackground {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    body {
      background: linear-gradient(45deg, rgb(23, 2, 28), rgb(28, 5, 53), #000000);
      background-size: 400% 400%;
      animation: moveBackground 15s ease infinite;
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
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
  </style>
</head>
<body class="min-h-screen overflow-x-hidden relative">
      <!-- Botão voltar -->
  <a href="{{route('fornecedores.dashboard')}}"
    class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-indigo-600 hover:bg-purple-700 transition-colors duration-300 shadow-[0_4px_20px_rgba(102,51,153,0.5)]"
    title="Voltar para o Dashboard">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

  <div id="particles-js"></div>

  <main class="flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-5xl bg-black/30 border border-purple-700/30 rounded-2xl shadow-[0_0_30px_rgba(139,92,246,0.1)] p-10">

      <h1 class="text-3xl font-semibold text-center text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-200 mb-10 tracking-widest">
        Cadastro de Produto
      </h1>

      @if(session('success'))
        <div class="bg-green-700 text-green-300 p-4 rounded mb-6 text-center font-semibold">{{ session('success') }}</div>
      @endif

<form action="{{ route('fornecedores.produtos.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
  @csrf

  <input type="text" name="nome" placeholder="Nome"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <input type="text" name="descricao" placeholder="Descrição"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <input type="number" name="preco" placeholder="Preço"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <input type="text" name="estoque_imagem" placeholder="Estoque Imagem"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <input type="text" name="caracteristicas" placeholder="Características"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <input type="text" name="historico_modelos" placeholder="Histórico de Modelos"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <input type="text" name="tamanhos_disponiveis" placeholder="Tamanhos Disponíveis"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <input type="text" name="genero" placeholder="Gênero"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <input type="text" name="categoria" placeholder="Categoria"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <input type="text" name="fotos" placeholder="Fotos (separadas por vírgula)"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <input type="number" name="id_fornecedores" placeholder="ID do Fornecedor"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition" />

  <select name="ativo"
    class="w-full px-4 py-3 bg-gray-900/40 text-white/70 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition">
    <option value="1">Ativo</option>
    <option value="0">Inativo</option>
  </select>

  <div class="md:col-span-2 mt-4">
    <button type="submit"
      class="relative w-full py-3 inline-flex items-center justify-center text-lg font-medium bg-black/20 text-indigo-600 border-2 border-indigo-600 rounded-full hover:text-white group overflow-hidden">
      <span
        class="absolute left-0 block w-full h-0 transition-all bg-indigo-600 opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-400 ease"></span>
      <span
        class="absolute right-0 flex items-center justify-start w-10 h-10 duration-300 transform translate-x-full group-hover:translate-x-0 ease">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
        </svg>
      </span>
      <span class="relative">Cadastrar</span>
    </button>
  </div>
</form>


      <footer class="mt-10 text-center text-gray-400 text-sm">
        &copy; 2025 <strong>Hydrax</strong>. Todos os direitos reservados.
      </footer>
    </div>
  </main>

  <script>
    particlesJS("particles-js", {
      particles: {
        number: { value: 60, density: { enable: true, value_area: 800 } },
        color: { value: "#000" },
        shape: { type: "polygon", polygon: { nb_sides: 5 } },
        opacity: { value: 0.5 },
        size: { value: 4, random: true, anim: { enable: true, speed: 5, size_min: 0.3 } },
        line_linked: { enable: false },
        move: {
          enable: true,
          speed: 1.5,
          direction: "bottom",
          out_mode: "out"
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

  <style>
    .input-style {
      @apply px-4 py-3 bg-gray-900/40 text-white/70 placeholder-white/30 hover:text-white focus:text-white border border-indigo-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900/40 transition;
    }
  </style>
</body>
</html>
