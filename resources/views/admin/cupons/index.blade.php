<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cupons - Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900">
  <div class="max-w-5xl mx-auto p-6">
    
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-extrabold tracking-tight uppercase">Cupons Cadastrados</h1>
      <a href="{{ route('admin.cupons.create') }}" 
         class="bg-black text-white px-5 py-3 font-bold uppercase hover:bg-gray-800 transition">
        Novo Cupom
      </a>
    </div>

    @if(session('success'))
      <div class="mb-6 p-4 bg-green-100 text-green-800 border border-green-300">
        {{ session('success') }}
      </div>
    @endif

    <div class="overflow-x-auto">
      <table class="w-full border border-gray-200 text-left">
        <thead class="bg-gray-100 uppercase text-sm">
          <tr>
            <th class="px-4 py-3 border">Código</th>
            <th class="px-4 py-3 border">Tipo</th>
            <th class="px-4 py-3 border">Valor</th>
            <th class="px-4 py-3 border">Validade</th>
            <th class="px-4 py-3 border">Uso Máximo</th>
            <th class="px-4 py-3 border">Ativo</th>
            <th class="px-4 py-3 border">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cupons as $cupom)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 border">{{ $cupom->codigo }}</td>
            <td class="px-4 py-3 border">{{ ucfirst($cupom->tipo) }}</td>
            <td class="px-4 py-3 border">R$ {{ number_format($cupom->valor, 2, ',', '.') }}</td>
            <td class="px-4 py-3 border">{{ $cupom->validade ?? 'Indefinida' }}</td>
            <td class="px-4 py-3 border">{{ $cupom->uso_maximo ?? 'Ilimitado' }}</td>
            <td class="px-4 py-3 border">{{ $cupom->ativo ? 'Sim' : 'Não' }}</td>
            <td class="px-4 py-3 border flex space-x-3">
              <a href="{{ route('admin.cupons.edit', $cupom->id_cupom) }}" 
                 class="text-blue-600 font-semibold hover:underline">Editar</a>
              <form action="{{ route('admin.cupons.destroy', $cupom->id_cupom) }}" method="POST" 
                    onsubmit="return confirm('Tem certeza que deseja deletar?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 font-semibold hover:underline">Deletar</button>
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
