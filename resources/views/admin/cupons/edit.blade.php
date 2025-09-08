<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Cupom - Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900">
  <div class="max-w-2xl mx-auto p-6">
    <h1 class="text-3xl font-extrabold tracking-tight mb-6 uppercase">Editar Cupom</h1>

    @if($errors->any())
      <div class="mb-6 p-4 bg-red-100 text-red-700 border border-red-300">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $erro)
            <li>{{ $erro }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.cupons.update', $cupom->id_cupom) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-sm font-semibold mb-1 uppercase">Código</label>
        <input type="text" name="codigo" value="{{ old('codigo', $cupom->codigo) }}" 
               class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black" required>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1 uppercase">Tipo</label>
        <select name="tipo" 
                class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black" required>
          <option value="percentual" {{ old('tipo', $cupom->tipo)=='percentual' ? 'selected' : '' }}>Percentual</option>
          <option value="valor" {{ old('tipo', $cupom->tipo)=='valor' ? 'selected' : '' }}>Valor Fixo</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1 uppercase">Valor</label>
        <input type="number" step="0.01" name="valor" value="{{ old('valor', $cupom->valor) }}" 
               class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black" required>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1 uppercase">Validade</label>
        <input type="date" name="validade" value="{{ old('validade', $cupom->validade) }}" 
               class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black">
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1 uppercase">Uso Máximo</label>
        <input type="number" name="uso_maximo" value="{{ old('uso_maximo', $cupom->uso_maximo) }}" 
               class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black">
      </div>

      <div class="flex items-center space-x-2">
        <input type="checkbox" name="ativo" value="1" {{ old('ativo', $cupom->ativo) ? 'checked' : '' }} 
               class="w-4 h-4 border-gray-400">
        <label class="text-sm font-semibold uppercase">Ativo</label>
      </div>

      <button type="submit" 
              class="w-full bg-black text-white font-bold py-3 text-lg hover:bg-gray-800 transition">
        Atualizar Cupom
      </button>
    </form>
  </div>
</body>
</html>
