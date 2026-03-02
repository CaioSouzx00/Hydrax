<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
  <title>Cupons - Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] text-white min-h-screen p-6">
  <!-- Botão voltar redondo -->
<a href="{{ route('admin.dashboard') }}"
   class="fixed top-4 left-4 z-50 w-10 h-10 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300 shadow-lg"
   title="Voltar">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
</a>
  <div class="max-w-6xl mx-auto p-8">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-2xl font-extrabold tracking-wide uppercase border-b border-gray-700/80 w-fit text-white">Cupons Cadastrados</h1>
      <a href="{{ route('admin.cupons.create') }}" 
         class="bg-gray-800 text-gray-200 px-6 py-3 font-bold uppercase rounded hover:bg-gray-700 transition">
        Novo Cupom
      </a>
    </div>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
      <div class="mb-6 p-4 bg-gray-900 text-gray-100 border border-gray-700 rounded">
        {{ session('success') }}
      </div>
    @endif

    <!-- Tabela -->
    <div class="overflow-x-auto rounded border border-gray-900">
      <table class="w-full text-left border-collapse">
        <thead class="bg-gray-800 text-gray-300 uppercase text-sm">
          <tr>
            <th class="px-5 py-3 border-b border-gray-900">Código</th>
            <th class="px-5 py-3 border-b border-gray-900">Tipo</th>
            <th class="px-5 py-3 border-b border-gray-900">Valor</th>
            <th class="px-5 py-3 border-b border-gray-900">Validade</th>
            <th class="px-5 py-3 border-b border-gray-900">Uso Máximo</th>
            <th class="px-5 py-3 border-b border-gray-900">Ativo</th>
            <th class="px-5 py-3 border-b border-gray-900">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cupons as $cupom)
          <tr class="hover:bg-gray-800/50 transition">
            <td class="px-5 py-3 border-b border-gray-800">{{ $cupom->codigo }}</td>
            <td class="px-5 py-3 border-b border-gray-800">{{ ucfirst($cupom->tipo) }}</td>
            <td class="px-5 py-3 border-b border-gray-800">
    @if($cupom->tipo === 'percentual')
        {{ $cupom->valor }}%
    @else
        R$ {{ number_format($cupom->valor, 2, ',', '.') }}
    @endif
</td>

            <td class="px-5 py-3 border-b border-gray-800">{{ $cupom->validade ?? 'Indefinida' }}</td>
            <td class="px-5 py-3 border-b border-gray-800">{{ $cupom->uso_maximo ?? 'Ilimitado' }}</td>
            <td class="px-5 py-3 border-b border-gray-800">{{ $cupom->ativo ? 'Sim' : 'Não' }}</td>
            <td class="px-5 py-3 border-b border-gray-800 flex space-x-4">
              <a href="{{ route('admin.cupons.edit', $cupom->id_cupom) }}" 
                 class="hover:underline">Editar</a>
              <form action="{{ route('admin.cupons.destroy', $cupom->id_cupom) }}" method="POST" 
                    onsubmit="return confirm('Tem certeza que deseja deletar?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="hover:underline">Deletar</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
