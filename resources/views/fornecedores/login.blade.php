<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/imagens/hydrax/hydrax-perfil.png" type="image/png" />
  <title>Hydrax - Login Fornecedor</title>
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

<div class="flex items-center justify-center w-full h-full">
  <main class="flex w-full max-w-7xl h-[90%] bg-black/30 rounded-md border border-[#542409] p-8 relative backdrop-blur-md shadow-[0_4px_20px_#54240988]">

    <!-- Área de Login -->
    <div class="w-1/2 bg-black/10 rounded-md flex items-center justify-center p-8 shadow-[0_4px_30px_#54240988]">
      <section class="p-8 rounded-3xl w-full max-w-sm text-left">

        <div class="text-center max-w-md mx-auto space-y-3">
          <h2 class="text-2xl font-[Orbitron] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#D5891B] via-[#7F3A0E] to-[#D5891B] bg-[length:200%_200%] bg-left hover:bg-right transition-all duration-700 ease-in-out drop-shadow-2xl">
            Olá, Fornecedor
          </h2>
          <h2 class="text-sm text-[#D5891B]">Seja bem-vindo à</h2>
          <h1 class="text-4xl font-[Orbitron] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#D5891B] via-[#7F3A0E] to-[#D5891B] bg-[length:200%_200%] bg-left hover:bg-right transition-all duration-700 ease-in-out drop-shadow-2xl">
            Hydrax
          </h1>
          <h3 class="text-sm text-gray-300">
            Gerencie seus produtos, acompanhe pedidos e mantenha seu catálogo sempre atualizado com facilidade e agilidade.
          </h3>
        </div>

        <div class="h-5"></div>

        @if ($errors->any())
        <div class="text-center bg-[#7F3A0E]/50 text-white p-4 mb-6 rounded border-2 border-[#D5891B]">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('fornecedores.login.submit') }}" class="space-y-4 mt-6">
          @csrf

          <div class="flex items-center space-x-3">
            <img src="/imagens/Post Jif 2025/4.png" alt="Ícone de e-mail" class="w-5 h-5">
            <input type="email" name="email" required placeholder="E-mail"
                   class="h-11 px-4 rounded-md border border-[#D5891B] bg-gray-900/60 text-white placeholder-gray-300 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#D5891B]">
          </div>

          <div class="flex items-center space-x-3 relative">
            <img src="/imagens/Post Jif 2025/5.png" alt="Ícone de senha" class="w-5 h-5">
            <input type="password" name="password" id="password" required placeholder="password"
                   class="h-11 px-4 pr-10 rounded-md border border-[#D5891B] bg-gray-900/60 text-white placeholder-gray-300 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#D5891B]">
            <button type="button" onclick="togglepassword()" class="absolute right-3 top-2 w-6 h-7">
              <img src="/imagens/Post Jif 2025.png" alt="Mostrar senha" id="eye-icon" class="w-6 h-6 opacity-40 hover:opacity-80 transition-opacity">
            </button>
          </div>

          <div class="flex justify-between items-center text-sm">
            <a href="{{ route('fornecedores.senha.form') }}" class="text-[#D5891B] hover:text-[#7F3A0E] transition">
              Esqueceu a senha?
            </a>
            <button type="submit"
                    class="relative px-5 py-2 border-2 border-[#7F3A0E] text-[#D5891B] rounded-xl hover:text-white hover:bg-[#542409] transition-all duration-300">
              Entrar
            </button>
          </div>

          <div class="mt-4 text-sm text-center">
            <p>Não possui conta?
              <a href="{{ route('fornecedores.create') }}" class="text-[#D5891B] hover:text-[#7F3A0E] transition">Cadastrar</a>
            </p>
          </div>
        </form>

        <footer class="mt-16 text-center text-xs text-white/60 hover:text-[#D5891B] transition duration-300">
          &copy; 2025 <strong>Hydrax</strong> - Todos os direitos reservados
        </footer>

      </section>
    </div>

<!-- Imagem Direita -->
<div class="w-1/2 relative flex items-center justify-center rounded-md bg-cover bg-center shadow-[0_4px_20px_rgba(84,36,9,0.3)]" style="background-image: url('/imagens/hydrax/kd17.jpeg');">
  <img src="/imagens/hydrax/HYDRA’x.png" alt="Logo Hydrax"
       class="absolute bottom-2 left-6 w-52 h-auto select-none pointer-events-none drop-shadow-[0_2px_4px_rgba(0,0,0,0.9)]" />
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
