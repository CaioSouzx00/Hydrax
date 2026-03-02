<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
    <title>Pedidos - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] min-h-screen text-gray-200">

<a href="{{ route('admin.dashboard') }}"
   class="fixed top-4 left-4 z-50 w-9 h-9 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300 shadow-[0_4px_20px_rgba(0,0,0,0.5)]"
   title="Voltar para o painel">
  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
  </svg>
</a>

<div class="container mx-auto py-10 px-4 mt-12">
    <h1 class="text-3xl font-bold mb-6 text-white">Pedidos</h1>

    @if(session('success'))
        <div class="mb-6 p-3 bg-green-600/50 border border-green-600 text-white rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <form class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-3">
        <input type="text" name="busca" value="{{ $busca ?? '' }}"
               placeholder="Buscar por ID, nome ou email"
               class="px-4 py-2 rounded-lg bg-[#1a1a1a] border border-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">

        <select name="status" class="px-4 py-2 rounded-lg bg-[#1a1a1a] border border-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
            <option value="">Todos status</option>
            @foreach(['criado','aguardando_pagamento','pago','enviado','entregue','cancelado','reembolsado','finalizado'] as $st)
                <option value="{{ $st }}" {{ ($status ?? '') === $st ? 'selected' : '' }}>{{ strtoupper($st) }}</option>
            @endforeach
        </select>

        <button class="px-4 py-2 rounded-lg bg-[#14ba88] text-black font-semibold hover:bg-[#117c66] transition">
            Filtrar
        </button>
    </form>

    <div class="overflow-x-auto shadow-lg rounded-lg bg-[#1a1a1a] border border-gray-800">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-[#0f0f0f] text-[#14ba88]">
                <tr>
                    <th class="px-4 py-3 border-b border-[#2c2c2c]">ID</th>
                    <th class="px-4 py-3 border-b border-[#2c2c2c]">Cliente</th>
                    <th class="px-4 py-3 border-b border-[#2c2c2c]">Total</th>
                    <th class="px-4 py-3 border-b border-[#2c2c2c]">Status</th>
                    <th class="px-4 py-3 border-b border-[#2c2c2c]">Rastreio</th>
                    <th class="px-4 py-3 border-b border-[#2c2c2c]">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr class="hover:bg-[#2a2a2a]/50 transition">
                        <td class="px-4 py-3 border-b border-[#2c2c2c]">#{{ $pedido->id }}</td>
                        <td class="px-4 py-3 border-b border-[#2c2c2c]">
                            <div class="text-white font-semibold">{{ $pedido->usuario->nome_completo ?? '-' }}</div>
                            <div class="text-gray-400 text-xs">{{ $pedido->usuario->email ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 border-b border-[#2c2c2c]">R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                        <td class="px-4 py-3 border-b border-[#2c2c2c]">{{ strtoupper($pedido->status) }}</td>
                        <td class="px-4 py-3 border-b border-[#2c2c2c]">
                            <div class="text-xs text-gray-300">{{ $pedido->codigo_rastreio ?? '-' }}</div>
                            @if(!empty($pedido->url_rastreio))
                                <a class="underline text-[#e29b37] text-xs" href="{{ $pedido->url_rastreio }}" target="_blank" rel="noopener noreferrer">Link</a>
                            @endif
                        </td>
                        <td class="px-4 py-3 border-b border-[#2c2c2c]">
                            <form method="POST" action="{{ route('admin.pedidos.update', $pedido->id) }}" class="grid grid-cols-1 gap-2">
                                @csrf
                                <select name="status" class="px-3 py-2 rounded bg-black/40 border border-gray-700 text-gray-200">
                                    @foreach(['criado','aguardando_pagamento','pago','enviado','entregue','cancelado','reembolsado','finalizado'] as $st)
                                        <option value="{{ $st }}" {{ $pedido->status === $st ? 'selected' : '' }}>{{ strtoupper($st) }}</option>
                                    @endforeach
                                </select>

                                <input name="codigo_rastreio" value="{{ $pedido->codigo_rastreio }}" placeholder="Código rastreio"
                                       class="px-3 py-2 rounded bg-black/40 border border-gray-700 text-gray-200">

                                <input name="url_rastreio" value="{{ $pedido->url_rastreio }}" placeholder="URL rastreio"
                                       class="px-3 py-2 rounded bg-black/40 border border-gray-700 text-gray-200">

                                <button class="px-3 py-2 rounded bg-[#14ba88] text-black font-semibold hover:bg-[#117c66] transition">
                                    Salvar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $pedidos->links() }}
    </div>
</div>

</body>
</html>
