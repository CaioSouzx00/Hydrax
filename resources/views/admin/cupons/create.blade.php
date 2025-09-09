<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Cupom - Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f0f0f] text-gray-200 font-sans">
  <div class="max-w-2xl mx-auto p-6">
    
    <!-- Título -->
    <h1 class="text-3xl font-extrabold tracking-tight mb-6 uppercase text-white">Criar Novo Cupom</h1>

    <!-- Erros -->
    @if($errors->any())
      <div class="mb-6 p-4 bg-gray-800 text-red-500 border border-gray-700 rounded">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $erro)
            <li>{{ $erro }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Formulário -->
    <form action="{{ route('admin.cupons.store') }}" method="POST" class="space-y-6">
      @csrf
      
      <div>
        <label class="block text-sm font-semibold mb-1 uppercase text-gray-200">Código</label>
        <input type="text" name="codigo" value="{{ old('codigo') }}" 
               class="w-full bg-gray-900 border border-gray-700 px-3 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-600 rounded" required>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1 uppercase text-gray-200">Tipo</label>
        <select name="tipo" 
                class="w-full bg-gray-900 border border-gray-700 px-3 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-600 rounded" required>
          <option value="percentual" {{ old('tipo')=='percentual' ? 'selected' : '' }}>Percentual</option>
          <option value="valor" {{ old('tipo')=='valor' ? 'selected' : '' }}>Valor Fixo</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1 uppercase text-gray-200">Valor</label>
        <input type="number" step="0.01" name="valor" value="{{ old('valor') }}" 
               class="w-full bg-gray-900 border border-gray-700 px-3 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-600 rounded" required>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1 uppercase text-gray-200">Validade</label>
        <input type="date" name="validade" value="{{ old('validade') }}" 
               class="w-full bg-gray-900 border border-gray-700 px-3 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-600 rounded">
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1 uppercase text-gray-200">Uso Máximo</label>
        <input type="number" name="uso_maximo" value="{{ old('uso_maximo') }}" 
               class="w-full bg-gray-900 border border-gray-700 px-3 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-600 rounded">
      </div>

      <div class="flex items-center space-x-2">
        <input type="checkbox" name="ativo" value="1" {{ old('ativo',1) ? 'checked' : '' }} 
               class="w-4 h-4 border-gray-500 bg-gray-800 text-gray-200">
        <label class="text-sm font-semibold uppercase text-gray-200">Ativo</label>
      </div>

      <!-- Botão -->
      <button type="submit" 
              class="w-full bg-gray-900 text-gray-200 font-bold py-3 text-lg hover:bg-gray-700 transition rounded">
        Criar Cupom
      </button>
    </form>
  </div>
</body>
</html>
