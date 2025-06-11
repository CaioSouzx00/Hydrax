<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <title>Editar Endereço</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Importar particles.min.js do CDN correto -->
  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
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
      margin: 0;
      min-height: 100vh;
      color: white;
      overflow-x: hidden;
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

<body>

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

  <main
    class="flex flex-col items-center justify-center w-full min-h-screen relative z-10 px-4 py-8">

    <section
      class="bg-black/40 p-8 md:p-12 rounded-3xl shadow-2xl w-full max-w-3xl text-white border border-gray-800">

      <h1
        class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-white bg-[length:200%_200%] bg-left hover:bg-right transition-all duration-700 ease-in-out drop-shadow-xl mb-8 text-center">
        Editar Endereço
      </h1>

      <form action="{{ route('endereco.update', ['id' => $usuario->id_usuarios, 'endereco_id' => $endereco->id_endereco]) }}"
        method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @csrf
        @method('PUT')

        @php
          $inputClasses = 'w-full h-12 px-5 rounded-xl border border-gray-700 bg-gray-900/80 text-white placeholder-gray-400 text-base focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 shadow-inner hover:shadow-[0_0_10px_rgba(99,102,241,0.3)]';
        @endphp

        <input type="text" name="cidade" value="{{ old('cidade', $endereco->cidade) }}" placeholder="Cidade..." required
          class="{{ $inputClasses }}">
        <input type="text" name="estado" maxlength="2" value="{{ old('estado', $endereco->estado) }}"
          placeholder="Estado (UF)" required class="{{ $inputClasses }}">
        <input type="text" name="cep" value="{{ old('cep', $endereco->cep) }}" placeholder="CEP..." required
          class="{{ $inputClasses }}">
        <input type="text" name="rua" value="{{ old('rua', $endereco->rua) }}" placeholder="Rua..." required
          class="{{ $inputClasses }}">
        <input type="text" name="bairro" value="{{ old('bairro', $endereco->bairro) }}" placeholder="Bairro..." required
          class="{{ $inputClasses }}">
        <input type="text" name="numero" value="{{ old('numero', $endereco->numero) }}" placeholder="Número..." required
          class="{{ $inputClasses }}">

        <div class="col-span-1 md:col-span-2 mt-4">
          <button type="submit"
            class="relative inline-flex items-center justify-center w-full px-6 py-3 overflow-hidden font-bold text-white rounded-md shadow-2xl group">
            <span
              class="absolute inset-0 w-full h-full transition duration-300 ease-out opacity-0 bg-gradient-to-br from-indigo-600 via-purple-700 to-blue-400 group-hover:opacity-100"></span>
            <!-- Top glass gradient -->
            <span class="absolute top-0 left-0 w-full bg-gradient-to-b from-white to-transparent opacity-5 h-1/3"></span>
            <!-- Bottom gradient -->
            <span class="absolute bottom-0 left-0 w-full h-1/3 bg-gradient-to-t from-white to-transparent opacity-5"></span>
            <!-- Left gradient -->
            <span class="absolute bottom-0 left-0 w-4 h-full bg-gradient-to-r from-white to-transparent opacity-5"></span>
            <!-- Right gradient -->
            <span class="absolute bottom-0 right-0 w-4 h-full bg-gradient-to-l from-white to-transparent opacity-5"></span>
            <span class="absolute inset-0 w-full h-full border border-white rounded-md opacity-10"></span>
            <span
              class="absolute w-full h-0 transition-all duration-300 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-5"></span>
            <span class="relative">Atualizar</span>
          </button>
        </div>

      </form>
    </section>

  </main>

  <script>
    /* Inicialização do particles.js */
    particlesJS("particles-js", {
      particles: {
        number: {
          value: 60,
          density: {
            enable: true,
            value_area: 800
          }
        },
        color: {
          value: "#000" /* Cor clara para aparecer sobre fundo escuro */
        },
        shape: {
          type: "polygon",
          polygon: {
            nb_sides: 5
          }
        },
        opacity: {
          value: 0.5,
          random: false
        },
        size: {
          value: 4,
          random: true,
          anim: {
            enable: true,
            speed: 5,
            size_min: 0.3,
            sync: false
          }
        },
        line_linked: {
          enable: false
        },
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
          onhover: {
            enable: true,
            mode: "repulse"
          },
          onclick: {
            enable: true,
            mode: "repulse"
          },
          resize: true
        },
        modes: {
          repulse: {
            distance: 100,
            duration: 0.4
          }
        }
      },
      retina_detect: true
    });
  </script>

</body>

</html>
