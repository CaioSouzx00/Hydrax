<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/imagens/hydrax/hydrax-perfil.png" type="image/png" />
  <title>Verificar Código</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
</head>
<body class="h-screen overflow-hidden text-white bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] animate-[moveBackground_20s_linear_infinite]">

  <!-- Botão voltar -->
<a href="{{ route('password.esqueciSenhaForm') }}"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#117c66]"
   title="Voltar para recuperação de senha" aria-label="Botão Voltar">
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

      <!-- Lado esquerdo - Formulário -->
      <div class="w-1/2 bg-black/20 rounded-md flex items-center justify-center p-8">
        <section class="p-6 w-full max-w-sm space-y-4">
          <div class="text-center mb-6">
            <h2 class="text-3xl font-[Orbitron] text-[#14ba88]/80 mb-2">Verificar Código</h2>
            <p class="text-sm text-gray-400">Digite o código enviado para o seu e-mail</p>
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

          <!-- Formulário de verificação -->
          <form method="POST" action="{{ route('password.verificarCodigo') }}" class="space-y-4">
            @csrf

            <input type="email" name="email" value="{{ old('email', $email) }}" required readonly
                   class="h-11 px-4 rounded-md border border-[#14ba88]/30 bg-[#1a1a1a]/70 text-white placeholder-gray-400 text-sm w-full focus:outline-none focus:ring-1 focus:ring-[#14ba88]/60">

            <input type="text" name="token" required placeholder="Digite o código"
                   class="h-11 px-4 rounded-md border border-[#14ba88]/30 bg-[#1a1a1a]/70 text-white placeholder-gray-400 text-sm w-full focus:outline-none focus:ring-1 focus:ring-[#14ba88]/60">

            <button type="submit"
                    class="relative w-full rounded px-5 py-2.5 overflow-hidden group bg-[#14ba88] hover:bg-gradient-to-r hover:from-[#14ba88] hover:to-[#6ee7c8] text-white hover:ring-2 hover:ring-offset-2 hover:ring-[#6ee7c8] transition-all ease-out duration-300">
              <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
              <span class="relative">Verificar Código</span>
            </button>
          </form>

          <footer class="mt-12 text-center text-xs text-white/40 hover:text-[#14ba88]/70 transition duration-300">
            &copy; 2025 <strong>Hydrax</strong> - Todos os direitos reservados
          </footer>
        </section>
      </div>

      <!-- Lado direito - Imagem -->
      <div class="w-1/2 flex items-center justify-center rounded-md bg-cover bg-center bg-black/20 shadow-[0_4px_20px_rgba(20,186,136,0.2)]"
           style="background-image: url('/imagens/hydrax/RcSenha.png');">
      </div>
    </main>
  </div>

</body>
</html>
