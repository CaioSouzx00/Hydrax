<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
<body class="bg-gradient-to-br from-indigo-950 via-purple-950 to-indigo-950 min-h-screen text-white font-sans">

  <!-- Botão voltar -->
  <a href="{{ route('admin.dashboard') }}"
     class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-indigo-600 hover:bg-purple-700 transition-colors duration-300 shadow-[0_4px_20px_rgba(102,51,153,0.5)]"
     title="Voltar para o painel">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

  <!-- Navbar -->
  <nav class="w-full bg-black/40 backdrop-blur border-b border-purple-800/20 shadow-md z-10">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-center">
      <h1 class="text-xl sm:text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-indigo-200 drop-shadow">
        Fornecedores Pendentes
      </h1>
      <div class="w-[60px]"></div>
    </div>
  </nav>

  <!-- Conteúdo -->
  <div class="max-w-4xl mx-auto mt-8 px-4">
    @forelse ($pendentes as $fornecedor)
      <div class="bg-black/30 border border-purple-700/25 rounded-xl p-6 mb-6 shadow-md">
        <p><strong>Empresa:</strong> {{ $fornecedor->nome_empresa }}</p>
        <p><strong>CNPJ:</strong> {{ $fornecedor->cnpj }}</p>
        <p><strong>Email:</strong> {{ $fornecedor->email }}</p>
        <p><strong>Telefone:</strong> {{ $fornecedor->telefone }}</p>

        <div class="mt-4 flex gap-4">
       @if ($fornecedor->id_fornecedores)
  <form method="POST" action="{{ route('fornecedores.aprovar', ['id' => $fornecedor->id_fornecedores]) }}">
    @csrf
    <button type="submit">Aprovar</button>
  </form>

  <form method="POST" action="{{ route('fornecedores.rejeitar', ['id' => $fornecedor->id_fornecedores]) }}">
    @csrf
    <button class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition text-white">
      Rejeitar
    </button>
  </form>
@else
  <p class="text-red-400">Erro: Fornecedor sem ID válido</p>
@endif


        </div>
      </div>
    @empty
    <div class="flex flex-col items-center justify-center gap-6 bg-gradient-to-br from-gray-900/70 via-gray-800/60 to-indigo-950/70 border border-purple-500/20 rounded-2xl p-10 shadow-2xl text-center">
  <!-- Texto com destaque -->
  <h2 class="text-2xl sm:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-300 via-indigo-400 to-purple-300 animate-pulse drop-shadow-lg">
    Ops! Nenhum fornecedor pendente no momento.
  </h2>

  <!-- Ilustração animada (Tailwind + SVG) -->
  <div class="w-40 h-40 animate-bounce-slow">
    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
      <circle cx="100" cy="100" r="80" fill="url(#grad)" />
      <path d="M70 85 Q100 110 130 85" stroke="#fff" stroke-width="5" fill="none" />
      <circle cx="75" cy="75" r="8" fill="#fff" />
      <circle cx="125" cy="75" r="8" fill="#fff" />
      <defs>
        <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" stop-color="#7c3aed" />
          <stop offset="100%" stop-color="#9333ea" />
        </linearGradient>
      </defs>
    </svg>
  </div>

  <!-- Mensagem secundária -->
  <p class="text-purple-100 text-sm sm:text-base">Aguardando novos cadastros para revisão...</p>
</div>
    @endforelse
  </div>

</body>
</html>