<div class="max-w-3xl mx-auto p-8 bg-white rounded-xl shadow-md">
    <h2 class="text-3xl font-bold mb-8 text-gray-800">Meu Perfil</h2>

    <form action="{{ route('usuario.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nome -->
        <div>
            <label class="block text-base font-semibold text-gray-700 mb-1">Nome completo</label>
            <input type="text" name="nome_completo" value="{{ old('nome_completo', $usuario->nome_completo) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                required>
            @error('nome_completo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="block text-base font-semibold text-gray-700 mb-1">Email</label>
            <p class="text-gray-800 text-sm bg-gray-100 rounded px-4 py-2">{{ $usuario->email }}</p>
        </div>

        <!-- Telefone -->
        <div>
            <label class="block text-base font-semibold text-gray-700 mb-1">Número de telefone</label>
            <p class="text-gray-800 text-sm bg-gray-100 rounded px-4 py-2">{{ $usuario->telefone }}</p>
        </div>

        <!-- Sexo -->
        <div>
            <label class="block text-base font-semibold text-gray-700 mb-1">Sexo</label>
            <p class="text-gray-800 text-sm bg-gray-100 rounded px-4 py-2 capitalize">{{ $usuario->sexo }}</p>
        </div>

        <!-- CPF -->
        <div>
            <label class="block text-base font-semibold text-gray-700 mb-1">CPF</label>
            <p class="text-gray-800 text-sm bg-gray-100 rounded px-4 py-2">{{ $usuario->cpf }}</p>
        </div>

        <!-- Data de nascimento -->
        <div>
            <label class="block text-base font-semibold text-gray-700 mb-1">Data de nascimento</label>
            <p class="text-gray-800 text-sm bg-gray-100 rounded px-4 py-2">
                {{ \Carbon\Carbon::parse($usuario->data_nascimento)->format('d/m/Y') }}
            </p>
        </div>

        <!-- Botão -->
        <div class="pt-4">
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-6 py-3 rounded-lg transition duration-200 shadow">
                Gravar
            </button>
        </div>
    </form>
</div>