<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
    <title>Finalizar Compra - Hydrax</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-[#211828] via-[#0b282a] to-[#17110d] text-white">

@php
    $usuario = Auth::guard('usuarios')->user();
    $enderecos = $usuario->enderecos ?? collect();
    $carrinho = $carrinho ?? $usuario->carrinhoAtivo;
    $cupons = $cupons ?? collect();

    $subtotal = $carrinho->itens->sum(fn($item) => $item->produto->preco * $item->quantidade);
    $entrega = 15;
    $totalComEntrega = $subtotal + $entrega;

    $cupomAplicado = session('cupom_aplicado') ?? null;
    $desconto = 0;

    if ($cupomAplicado) {
        if ($cupomAplicado['tipo'] === 'percentual') {
            $desconto = $totalComEntrega * ($cupomAplicado['valor']/100);
        } else {
            $desconto = $cupomAplicado['valor'];
        }
        $totalComEntrega -= $desconto;
    }
@endphp

<div class="container mx-auto max-w-6xl grid grid-cols-1 md:grid-cols-3 gap-12 py-10">

    <!-- Coluna esquerda -->
    <div class="md:col-span-2 space-y-10">
        <!-- Voltar -->
        <div class="mb-2">
<a href="{{ route('carrinho.ver') }}"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#117c66]"
   title="Voltar" aria-label="Botão Voltar">
    <div class="flex items-center justify-center w-10 h-10 shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </div>
    <span class="ml-2 w-0 group-hover:w-auto opacity-0 group-hover:opacity-100 overflow-hidden whitespace-nowrap transition-all duration-300 ease-in-out">
        Voltar
    </span>
</a>
        </div>
        @if(session('error'))
            <div class="bg-red-700/40 border border-red-700 text-white p-3 rounded mb-6 shadow-md">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="bg-green-700/40 border border-green-700 text-white p-3 rounded mb-6 shadow-md">{{ session('success') }}</div>
        @endif

        <!-- Endereço -->
        <div class="bg-[#1b1b27] p-6 rounded-2xl shadow-md border border-[#d5891b]/20">
            <h2 class="font-extrabold uppercase mb-4 text-gray-300 border-b border-[#d5891b]/50 w-fit text-lg">Endereço de entrega</h2>
            @if($enderecos->isEmpty())
                <form action="{{ route('usuarios.enderecos.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="rua" placeholder="Rua:" required class="border border-[#d5891b]/30 p-2 rounded w-full bg-[#111]/30 text-white">
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="numero" placeholder="Número:" required class="border border-[#d5891b]/30 p-2 rounded bg-[#111]/30 text-white">
                        <input type="text" name="bairro" placeholder="Bairro:" required class="border border-[#d5891b]/30 p-2 rounded bg-[#111]/30 text-white">
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <input type="text" name="cidade" placeholder="Cidade:" required class="border border-[#d5891b]/30 p-2 rounded bg-[#111]/30 text-white">
                        <select name="estado" required class="border border-[#d5891b]/30 p-2 rounded bg-[#111]/30 text-white">
                            <option value="">Estado</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AP">AP</option>
                            <option value="AM">AM</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MT">MT</option>
                            <option value="MS">MS</option>
                            <option value="MG">MG</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PR">PR</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RS">RS</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="SC">SC</option>
                            <option value="SP">SP</option>
                            <option value="SE">SE</option>
                            <option value="TO">TO</option>
                        </select>
                    </div>
                    <input type="text" name="cep" placeholder="CEP:" required class="border border-[#d5891b]/30 p-2 rounded w-full bg-[#111]/30 text-white">
                    <button type="submit" 
    class="relative w-full rounded px-5 py-3 overflow-hidden group bg-[#14ba88] text-[#0B282A] hover:text-white uppercase font-bold hover:bg-gradient-to-r hover:from-[#14ba88] hover:to-[#0f8a67] hover:ring-2 hover:ring-offset-2 hover:ring-[#14ba88] transition-all ease-out duration-300">
    
    <!-- Brilho deslizante -->
    <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
    
    <!-- Texto -->
    <span class="relative">Salvar Endereço</span>
</button>

                </form>
            @else
                <form action="{{ route('carrinho.processar') }}" method="POST" class="space-y-4">
                    @csrf
                    @foreach($enderecos as $endereco)
                        <label class="flex items-start p-4 border border-[#d5891b]/30 rounded-xl cursor-pointer hover:border-[#d5891b]/50 transition">
                            <input type="radio" name="id_endereco" value="{{ $endereco->id_endereco }}" class="mt-1" required>
                            <div class="ml-3 text-sm leading-6">
                                <p class="font-medium">{{ $endereco->rua }}, {{ $endereco->numero }}</p>
                                <p>{{ $endereco->bairro }} - {{ $endereco->cidade }}/{{ $endereco->estado }}</p>
                                <p>CEP: {{ $endereco->cep }}</p>
                            </div>
                        </label>
                    @endforeach
                                        <button type="submit" 
    class="relative w-full rounded px-5 py-3 overflow-hidden group bg-[#14ba88] text-[#0B282A] hover:text-white uppercase font-bold hover:bg-gradient-to-r hover:from-[#14ba88] hover:to-[#0f8a67] hover:ring-2 hover:ring-offset-2 hover:ring-[#14ba88] transition-all ease-out duration-300">
    
    <!-- Brilho deslizante -->
    <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
    
    <!-- Texto -->
    <span class="relative">Finalizar Compra</span>
</button>
                </form>
            @endif
        </div>

        <!-- Entrega -->
        <div class="bg-[#1b1b27]/30 p-6 rounded-2xl shadow-md border border-[#d5891b]/20">
            <h2 class="font-extrabold uppercase text-gray-300">Opções de entrega</h2>
            <p class="text-sm text-gray-400">Entrega padrão — R$15,00</p>
        </div>

        <!-- Pagamento -->
        <div class="bg-[#1b1b27]/30 p-6 rounded-2xl shadow-md border border-[#d5891b]/20">
            <h2 class="font-extrabold uppercase text-gray-300">Pagamento</h2>
            <p class="text-sm text-gray-400">Será gerada uma chave PIX após finalizar.</p>
        </div>
    </div>

    <!-- Coluna direita -->
    <div class="space-y-6">

        <!-- Cupons -->
        @if($cupons->isNotEmpty())
            <div class="bg-[#1b1b27]/30 mt-10 p-4 rounded-2xl shadow-md border border-[#d5891b]/20">
                <h2 class="font-extrabold uppercase mb-2 text-gray-300 text-sm border-b border-[#d5891b]/80 w-fit">Cupons disponíveis</h2>
                <ul class="space-y-2 text-sm text-gray-300">
                    @foreach($cupons as $cupom)
                        <li class="flex justify-between items-center border border-[#d5891b]/20 p-2 rounded-lg">
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
    <button type="submit" 
        class="relative rounded px-3 py-1 overflow-hidden group bg-[#14ba88] text-[#0B282A] hover:text-white uppercase font-bold hover:bg-gradient-to-r hover:from-[#14ba88] hover:to-[#117c66] hover:ring-2 hover:ring-offset-2 hover:ring-[#14ba88] transition-all ease-out duration-300">
        
        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
        
        <span class="relative">Aplicar</span>
    </button>
</form>

                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Resumo do pedido -->
        <div class="bg-[#1b1b27]/30 p-6 rounded-2xl shadow-md border border-[#d5891b]/20">
            <h2 class="font-extrabold uppercase mb-6 text-gray-300 border-b border-[#d5891b]/80 w-fit">Seu Pedido</h2>

            @foreach($carrinho->itens as $item)
                @php
                    $itemSubtotal = $item->produto->preco * $item->quantidade;
                @endphp
                <div class="flex items-center justify-between border-b border-[#d5891b]/10 py-3">
                    <div class="flex items-center space-x-3">
                        @php
                            $foto = is_array(json_decode($item->produto->fotos, true)) 
                                ? json_decode($item->produto->fotos, true)[0] 
                                : $item->produto->fotos;
                        @endphp
                        <img src="{{ asset('storage/' . $foto) }}" alt="{{ $item->produto->nome }}" class="w-16 h-16 object-cover rounded">
                        <span>{{ $item->produto->nome }} ({{ $item->quantidade }})</span>
                    </div>
                    <span>R$ {{ number_format($itemSubtotal, 2, ',', '.') }}</span>
                </div>
            @endforeach

            <div class="flex justify-between mt-2 text-sm border-t border-[#d5891b]/10 pt-3">
                <span>Subtotal</span>
                <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
            </div>

            <div class="flex justify-between mt-1 text-sm">
                <span>Entrega</span>
                <span>R$ {{ number_format($entrega, 2, ',', '.') }}</span>
            </div>

            @if($desconto > 0)
                <div class="flex justify-between mt-1 text-sm text-green-600">
                    <span>Cupom ({{ $cupomAplicado['codigo'] }})</span>
                    <span>- R$ {{ number_format($desconto, 2, ',', '.') }}</span>
                </div>
            @endif

            <div class="flex justify-between mt-2 text-lg font-bold">
                <span>Total</span>
                <span>R$ {{ number_format($totalComEntrega, 2, ',', '.') }}</span>
            </div>
        </div>

    </div>
</div>

@include('usuarios.partials.footer')
</body>
</html>
