<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Hydrax</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-[#211828] via-[#0b282a] to-[#17110d] text-white">

@php
    $usuario = Auth::guard('usuarios')->user();
    $enderecos = $usuario->enderecos ?? collect();
    $carrinho = $carrinho ?? $usuario->carrinhoAtivo;
    $cupons = $cupons ?? collect();
    $cupomAplicado = session('cupom') ?? null;

    $total = 0;
    $entrega = 15;
    $desconto = 0;
@endphp

<div class="container mx-auto max-w-6xl grid grid-cols-1 md:grid-cols-3 gap-12 py-10">

    <!-- Coluna esquerda -->
    <div class="md:col-span-2 space-y-10">
        <!-- Voltar -->
        <div class="mb-2">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-[#14ba88] inline-block">
                &larr; Voltar à Tela Inicial
            </a>
        </div>
        @if(session('error'))
            <div class="bg-red-700 text-white p-3 rounded mb-6 shadow-md">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="bg-green-700 text-white p-3 rounded mb-6 shadow-md">{{ session('success') }}</div>
        @endif

        <!-- Endereço -->
        <div class="bg-[#1b1b27] p-6 rounded-2xl shadow-md border border-[#14ba88]/20">
            <h2 class="font-extrabold uppercase mb-4 text-[#14ba88] text-lg">Endereço de entrega</h2>

            @if($enderecos->isEmpty())
                <form action="{{ route('usuarios.enderecos.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="rua" placeholder="Rua *" required class="border border-[#7f3a0e]/50 p-2 rounded w-full bg-[#111] text-white">
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="numero" placeholder="Número *" required class="border border-[#7f3a0e]/50 p-2 rounded bg-[#111] text-white">
                        <input type="text" name="bairro" placeholder="Bairro *" required class="border border-[#7f3a0e]/50 p-2 rounded bg-[#111] text-white">
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <input type="text" name="cidade" placeholder="Cidade *" required class="border border-[#7f3a0e]/50 p-2 rounded bg-[#111] text-white">
                        <select name="estado" required class="border border-[#7f3a0e]/50 p-2 rounded bg-[#111] text-white">
                            <option value="">Estado</option>
                            <option value="SP">SP</option>
                            <option value="RJ">RJ</option>
                        </select>
                    </div>
                    <input type="text" name="cep" placeholder="CEP *" required class="border border-[#7f3a0e]/50 p-2 rounded w-full mt-2 bg-[#111] text-white">
                    <button type="submit" class="w-full bg-[#14ba88] text-black font-bold py-3 rounded-lg mt-4 uppercase hover:bg-[#0f8a67] transition">Salvar Endereço</button>
                </form>
            @else
                <form action="{{ route('carrinho.processar') }}" method="POST" class="space-y-4">
                    @csrf
                    @foreach($enderecos as $endereco)
                        <label class="flex items-start p-4 border border-[#14ba88]/30 rounded-xl cursor-pointer hover:border-[#14ba88] transition">
                            <input type="radio" name="id_endereco" value="{{ $endereco->id_endereco }}" class="mt-1" required>
                            <div class="ml-3 text-sm leading-6">
                                <p class="font-medium">{{ $endereco->rua }}, {{ $endereco->numero }}</p>
                                <p>{{ $endereco->bairro }} - {{ $endereco->cidade }}/{{ $endereco->estado }}</p>
                                <p>CEP: {{ $endereco->cep }}</p>
                            </div>
                        </label>
                    @endforeach
                    <button type="submit" class="w-full bg-[#14ba88] text-black font-bold py-4 mt-6 uppercase rounded-xl hover:bg-[#0f8a67] transition">Finalizar Compra</button>
                </form>
            @endif
        </div>

        <!-- Entrega -->
        <div class="bg-[#1b1b27]/30 p-6 rounded-2xl shadow-md border border-[#14ba88]/20">
            <h2 class="font-extrabold uppercase text-[#14ba88]">Opções de entrega</h2>
            <p class="text-sm text-gray-400">Entrega padrão — R$15,00</p>
        </div>

        <!-- Pagamento -->
        <div class="bg-[#1b1b27]/30 p-6 rounded-2xl shadow-md border border-[#14ba88]/20">
            <h2 class="font-extrabold uppercase text-[#14ba88]">Pagamento</h2>
            <p class="text-sm text-gray-400">Será gerada uma chave PIX após finalizar.</p>
        </div>
    </div>

    <!-- Coluna direita -->
    <div class="space-y-6">

        <!-- Cupons -->
        @if($cupons->isNotEmpty())
            <div class="bg-[#1b1b27]/30 p-4 rounded-2xl shadow-md border border-[#14ba88]/20">
                <h2 class="font-extrabold uppercase mb-2 text-[#14ba88] text-sm">Cupons disponíveis</h2>
                <ul class="space-y-2 text-sm text-gray-300">
                    @foreach($cupons as $cupom)
                        <li class="flex justify-between items-center border border-[#14ba88]/10 p-2 rounded-lg">
                            <span>{{ $cupom->codigo }} - 
                                @if($cupom->tipo === 'percentual')
                                    {{ $cupom->valor }}% off
                                @else
                                    R$ {{ number_format($cupom->valor, 2, ',', '.') }} off
                                @endif
                            </span>
                            <form action="{{ route('carrinho.aplicarCupom') }}" method="POST">
                                @csrf
                                <input type="hidden" name="codigo_cupom" value="{{ $cupom->codigo }}">
                                <button type="submit" class="bg-[#14ba88] text-black px-3 py-1 rounded uppercase hover:bg-[#0f8a67] transition">
                                    Aplicar
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Resumo do pedido -->
        <div class="bg-[#1b1b27]/30 p-6 rounded-2xl shadow-md border border-[#14ba88]/20">
            <h2 class="font-extrabold uppercase mb-6 text-[#14ba88]">Seu Pedido</h2>

            @foreach($carrinho->itens as $item)
                @if($item->produto)
                    @php
                        $subtotal = $item->quantidade * $item->produto->preco;
                        $total += $subtotal;
                        $foto = is_array(json_decode($item->produto->fotos, true)) 
                            ? json_decode($item->produto->fotos, true)[0] 
                            : $item->produto->fotos;
                    @endphp
                    <div class="flex items-center justify-between border-b border-[#14ba88]/10 py-3">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('storage/' . $foto) }}" 
                                 alt="{{ $item->produto->nome }}" 
                                 class="w-16 h-16 object-cover rounded">
                            <span>{{ $item->produto->nome }} ({{ $item->quantidade }})</span>
                        </div>
                        <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                    </div>
                @endif
            @endforeach

            @php
                $totalComEntrega = $total + $entrega;
                if($cupomAplicado) {
                    if($cupomAplicado['tipo'] === 'percentual'){
                        $desconto = $totalComEntrega * ($cupomAplicado['valor']/100);
                    } else {
                        $desconto = $cupomAplicado['valor'];
                    }
                    $totalComEntrega -= $desconto;
                }
            @endphp

            <div class="flex justify-between mt-4 text-sm text-gray-300">
                <span>Entrega</span>
                <span>R$ {{ number_format($entrega, 2, ',', '.') }}</span>
            </div>

            @if($cupomAplicado)
                <div class="flex justify-between mt-2 text-sm text-green-400 font-bold">
                    <span>Desconto ({{ $cupomAplicado['codigo'] }})</span>
                    <span>- R$ {{ number_format($desconto, 2, ',', '.') }}</span>
                </div>
            @endif

            <div class="flex justify-between mt-2 text-lg font-bold border-t border-[#14ba88]/30 pt-3">
                <span>Total</span>
                <span>R$ {{ number_format($totalComEntrega, 2, ',', '.') }}</span>
            </div>
        </div>

    </div>
</div>
@include('usuarios.partials.footer')
</body>
</html>
