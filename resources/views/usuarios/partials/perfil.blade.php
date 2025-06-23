<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div>
    <h2 class="text-2xl font-bold mb-4">Meu Perfil</h2>

    <form action="{{ route('usuario.perfil.atualizar') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Nome completo - editável -->
        <div>
            <label class="block text-sm font-medium mb-1" for="nome_completo">Nome completo</label>
            <input
                type="text"
                id="nome_completo"
                name="nome_completo"
                value="{{ old('nome_completo', $usuario->nome_completo) }}"
                class="border rounded px-3 py-2 w-full"
                required
            >
            @error('nome_completo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Data nascimento - só mostrar -->
        <div>
            <label class="block text-sm font-medium mb-1">Data de nascimento</label>
            <p class="text-gray-700">
                {{ \Carbon\Carbon::parse($usuario->data_nascimento)->format('d/m/Y') }}
            </p>
        </div>

        <!-- Email - só mostrar -->
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <p class="text-gray-700">{{ $usuario->email }}</p>
        </div>

        <!-- Telefone - só mostrar -->
        <div>
            <label class="block text-sm font-medium mb-1">Telefone</label>
            <p class="text-gray-700">{{ $usuario->telefone }}</p>
        </div>

        <!-- CPF - só mostrar parcialmente -->
        <div>
            <label class="block text-sm font-medium mb-1">CPF</label>
            <p class="text-gray-700">***.***.***{{ substr($usuario->cpf, -3) }}</p>
        </div>

        <button
            type="submit"
            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded font-semibold"
        >
            Gravar
        </button>
    </form>
</div>

</body>
</html>