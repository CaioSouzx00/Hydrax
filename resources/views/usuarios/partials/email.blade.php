<div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-xl p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">🔒 Trocar E-mail</h2>

    <form action="{{ route('usuarios.email.update') }}" method="POST">
        @csrf

        <!-- E-mail atual -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">E-mail atual</label>
            <input type="text" value="{{ $usuario->email }}" readonly
                   class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed" />
        </div>

        <!-- Novo e-mail -->
        <div class="mb-6">
            <label for="novo_email" class="block text-sm font-medium text-gray-700 mb-1">Novo e-mail</label>
            <input type="email" name="novo_email" id="novo_email" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            @error('novo_email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botão -->
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
                Salvar
            </button>
        </div>
    </form>
</div>
