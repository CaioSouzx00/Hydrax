<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
    <title>Histórico de Compras - {{ $usuario->nome_completo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] text-white min-h-screen p-6">

    <!-- Botão voltar redondo -->
    <a href="{{ route('admin.clientes') }}"
       class="inline-flex items-center justify-center w-10 h-10 rounded-full 
              bg-gray-700 text-white hover:bg-gray-600 transition-colors duration-300 mb-6">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </a>

    <h1 class="text-3xl font-bold mb-6">Histórico de Compras de {{ $usuario->nome_completo }}</h1>

    @if($pedidos->count() > 0)
        @foreach($pedidos as $pedido)
            @if($pedido->itens->count() > 0) <!-- só mostra se tiver itens -->
                <div class="bg-[#1a1a1a]/10 backdrop-blur-sm border border-gray-700 rounded-xl p-4 mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <p class="text-gray-300 font-semibold">Pedido #{{ $pedido->id }}</p>
                        <p class="text-gray-400 text-sm">Data: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-800/70 text-gray-300">
                                    <th class="px-4 py-2 text-left">Produto</th>
                                    <th class="px-4 py-2 text-center">Quantidade</th>
                                    <th class="px-4 py-2 text-center">Preço Unitário</th>
                                    <th class="px-4 py-2 text-center">Imagem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedido->itens as $item)
                                    @php 
                                        $fotos = json_decode($item->produto->fotos ?? '[]', true); 
                                        $foto = $fotos[0] ?? null; 
                                    @endphp
                                    <tr class="border-t border-gray-700 hover:bg-gray-800/40 transition">
                                        <td class="px-4 py-2 font-medium text-gray-200">{{ $item->produto->nome }}</td>
                                        <td class="px-4 py-2 text-center">{{ $item->quantidade }}</td>
                                        <td class="px-4 py-2 text-center">R$ {{ number_format($item->produto->preco,2,',','.') }}</td>
                                        <td class="px-4 py-2 flex justify-center">
                                            <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/60' }}" 
                                                 class="w-14 h-14 object-cover rounded border border-gray-700">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <p class="text-gray-400">Nenhum pedido encontrado para este usuário.</p>
    @endif

</body>
</html>
