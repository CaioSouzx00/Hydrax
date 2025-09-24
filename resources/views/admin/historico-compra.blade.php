<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
    <title>Histórico de Compras - {{ $usuario->nome_completo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#111] text-white min-h-screen p-6">

<a href="{{ route('admin.clientes') }}" class="text-gray-400 hover:text-white inline-block mb-6">
    &larr; Voltar à Lista de Clientes
</a>

<h1 class="text-3xl font-bold mb-6">Histórico de Compras de {{ $usuario->nome_completo }}</h1>

@if($pedidos->count() > 0)
    @foreach($pedidos as $pedido)
        <div class="bg-[#1a1a1a] border border-gray-700 rounded-xl shadow p-4 mb-4">
            <p class="text-gray-400 mb-2">ID do Pedido: {{ $pedido->id }}</p>
            <p class="text-gray-400 mb-2">Data: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>

            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($pedido->itens as $item)
                    @php $fotos = json_decode($item->produto->fotos ?? '[]', true); $foto = $fotos[0] ?? null; @endphp
                    <div class="flex items-center gap-4 bg-gray-800 rounded p-2">
                        <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/60' }}" 
                             class="w-16 h-16 object-cover rounded">
                        <div>
                            <p class="font-semibold">{{ $item->produto->nome }}</p>
                            <p class="text-gray-400 text-sm">Qtd: {{ $item->quantidade }}</p>
                            <p class="text-gray-400 text-sm">Preço unit: R$ {{ number_format($item->produto->preco,2,',','.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@else
    <p class="text-gray-400">Nenhum pedido encontrado para este usuário.</p>
@endif

</body>
</html>
