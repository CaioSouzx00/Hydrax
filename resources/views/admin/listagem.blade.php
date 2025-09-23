<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Produtos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] min-h-screen text-gray-200">
      <!-- Botão voltar -->
  <a href="{{ route('admin.dashboard') }}"
     class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300 shadow-[0_4px_20px_rgba(0,0,0,0.5)]"
     title="Voltar para o painel">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>
    <div class="container mx-auto py-10 px-4 mt-12">
        <h1 class="text-3xl font-bold mb-6 text-white">Todos os Produtos</h1>

        @if(session('success'))
            <div class="mb-6 p-3 bg-green-600 text-white rounded shadow">
                {{ session('success') }}
            </div>
        @endif
        
<form class="mb-6 flex items-center space-x-2">
    <input type="text" id="busca" name="busca"
        placeholder="Pesquisar produto ou fornecedor..."
        class="px-4 py-2 rounded-lg bg-[#1a1a1a] border border-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full max-w-md">
</form>

<div id="tabela-produtos" class="overflow-x-auto shadow-lg rounded-lg bg-[#1a1a1a] border border-gray-800">
    @include('admin.partials.tabela-produtos', ['produtos' => $produtos])
</div>


        <div class="mt-6 flex justify-center space-x-2">
            {{ $produtos->links() }}
        </div>
    </div>

<script>
document.getElementById('busca').addEventListener('keyup', function() {
    let termo = this.value;

    fetch(`{{ route('admin.produtos.listar') }}?busca=${termo}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('tabela-produtos').innerHTML = html;
    });
});
</script>

</body>
</html>
