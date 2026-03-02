<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
  <title>Fornecedores Pendentes</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<style>
@keyframes bounce-slow {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-12px); }
}
.animate-bounce-slow {
  animation: bounce-slow 3s infinite;
}
</style>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] min-h-screen text-white font-sans">

  <!-- Botão voltar -->
  <a href="{{ route('admin.dashboard') }}"
     class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300 shadow-[0_4px_20px_rgba(0,0,0,0.5)]"
     title="Voltar para o painel">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

  <!-- Navbar -->
  <nav class="w-full bg-black/40 backdrop-blur border-b border-gray-700/30 shadow-md z-10">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-center">
      <h1 class="text-xl sm:text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-gray-200 to-gray-400 drop-shadow">
        Fornecedores Pendentes
      </h1>
      <div class="w-[60px]"></div>
    </div>
  </nav>

  <!-- Conteúdo -->
  <div class="max-w-4xl mx-auto mt-8 px-4">
    @forelse ($pendentes as $fornecedor)
      <div class="bg-black/30 border border-gray-700/25 rounded-xl p-6 mb-6 shadow-md">
        <p><strong>Empresa:</strong> {{ $fornecedor->nome_empresa }}</p>
        <p><strong>CNPJ:</strong> {{ $fornecedor->cnpj }}</p>
        <p><strong>Email:</strong> {{ $fornecedor->email }}</p>
        <p><strong>Telefone:</strong> {{ $fornecedor->telefone }}</p>

        <div class="mt-4 flex gap-4">
       @if ($fornecedor->id_fornecedores)
  <form method="POST" action="{{ route('fornecedores.aprovar', ['id' => $fornecedor->id_fornecedores]) }}">
    @csrf
    <button type="submit" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition text-white">Aprovar</button>
  </form>

  <form method="POST" action="{{ route('fornecedores.rejeitar', ['id' => $fornecedor->id_fornecedores]) }}">
    @csrf
    <button class="px-4 py-2 bg-gray-500 hover:bg-gray-400 rounded-lg transition text-white">
      Rejeitar
    </button>
  </form>
@else
  <p class="text-gray-400">Erro: Fornecedor sem ID válido</p>
@endif
        </div>
      </div>
    @empty
    <div class="flex flex-col items-center justify-center gap-6 bg-gradient-to-br from-[#000000]/70 via-[#211828] to-[#17110D]/70 border border-gray-500/20 rounded-2xl p-10 shadow-2xl text-center">
  <!-- Texto com destaque -->
  <h2 class="text-2xl sm:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200 animate-pulse drop-shadow-lg">
    Ops! Nenhum fornecedor pendente no momento.
  </h2>

  <!-- Ilustração animada (Preto, Cinza, Branco) -->
  <div class="w-40 h-40 animate-bounce-slow">
    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
      <circle cx="100" cy="100" r="80" fill="url(#grad)" />
      <path d="M70 85 Q100 110 130 85" stroke="#fff" stroke-width="5" fill="none" />
      <circle cx="75" cy="75" r="8" fill="#fff" />
      <circle cx="125" cy="75" r="8" fill="#fff" />
      <defs>
        <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" stop-color="#555" />
          <stop offset="100%" stop-color="#222" />
        </linearGradient>
      </defs>
    </svg>
  </div>

  <!-- Mensagem secundária -->
  <p class="text-gray-300 text-sm sm:text-base">Aguardando novos cadastros para revisão...</p>
</div>
    @endforelse
  </div>

</body>
</html>
