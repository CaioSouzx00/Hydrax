<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
    <title>Produtos - {{ $fornecedor->nome_empresa }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#111] text-white min-h-screen p-6">

<a href="{{ route('admin.fornecedores') }}" class="text-gray-400 hover:text-white inline-block mb-6">
    &larr; Voltar à Lista de Fornecedores
</a>

<h1 class="text-3xl font-bold mb-6">Produtos do fornecedor {{ $fornecedor->nome_empresa }}</h1>

@if($produtos->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($produtos as $produto)
            @php
                $fotos = json_decode($produto->fotos ?? '[]', true);
                $foto = $fotos[0] ?? null;
            @endphp
            <div class="bg-[#1a1a1a] border border-gray-700 rounded-xl shadow p-4 flex flex-col">
                <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/150' }}" 
                     class="w-full h-40 object-cover rounded mb-4">
                
                <h2 class="font-bold text-lg mb-1">{{ $produto->nome }}</h2>
                <p class="text-gray-400 text-sm mb-1">Preço: R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                <p class="text-gray-400 text-sm mb-1">Característica: {{ $produto->caracteristica_produto }}</p>
                <p class="text-gray-400 text-sm mb-1">Descrição: {{ $produto->descricao }}</p>
                <p class="text-gray-400 text-sm mb-1">História: {{ $produto->historia }}</p>

                <span class="mt-auto text-sm font-semibold text-green-400">
                    {{ $produto->ativo ? 'Ativo' : 'Inativo' }}
                </span>
            </div>
        @endforeach
    </div>
@else
    <p class="text-gray-400">Nenhum produto cadastrado para este fornecedor.</p>
@endif

</body>
</html>
