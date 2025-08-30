<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Hydrax</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900">

@php
    $enderecos = Auth::guard('usuarios')->user()->enderecos ?? collect();
@endphp

<form action="{{ $enderecos->isEmpty() ? route('usuarios.enderecos.store') : route('carrinho.finalizar') }}" method="POST">
    @csrf

    <div class="container mx-auto max-w-6xl grid grid-cols-1 md:grid-cols-3 gap-12 py-10">

        <!-- Coluna esquerda -->
        <div class="md:col-span-2 space-y-10">

            <!-- Mensagem de erro -->
            @if(session('error'))
                <div class="bg-red-600 text-white p-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Validações -->
            @if($errors->any())
                <div class="bg-red-600 text-white p-3 rounded mb-6 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Endereço -->
            <div>
                <h2 class="font-extrabold uppercase mb-4">Endereço de entrega</h2>

                @if($enderecos->isEmpty())
                    {{-- Formulário de cadastro --}}
                    <div class="space-y-4">
                        <input type="text" name="rua" placeholder="Rua *" required class="border p-2 rounded w-full">
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" name="numero" placeholder="Número *" required class="border p-2 rounded">
                            <input type="text" name="bairro" placeholder="Bairro *" required class="border p-2 rounded">
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <input type="text" name="cidade" placeholder="Cidade *" required class="border p-2 rounded">
                            <select name="estado" required class="border p-2 rounded">
                                <option value="">Estado</option>
                                <option value="SP">SP</option>
                                <option value="RJ">RJ</option>
                                <!-- TODO: listar todos os estados -->
                            </select>
                        </div>
                        <input type="text" name="cep" placeholder="CEP *" required class="border p-2 rounded w-full mt-2">

                        <button type="submit" class="w-full bg-black text-white font-bold py-3 rounded-lg mt-4 uppercase hover:bg-gray-800 transition">
                            Salvar Endereço
                        </button>
                    </div>
                @else
                    {{-- Lista de endereços --}}
                    <div class="space-y-4">
                        @foreach($enderecos as $endereco)
                        <label class="flex items-start border border-gray-300 p-4 cursor-pointer hover:border-black rounded-lg">
                            <input type="radio" name="id_endereco" value="{{ $endereco->id_endereco }}" class="mt-1" required>
                            <div class="ml-3 text-sm leading-6">
                                <p class="font-medium">{{ $endereco->rua }}, {{ $endereco->numero }}</p>
                                <p>{{ $endereco->bairro }} - {{ $endereco->cidade }}/{{ $endereco->estado }}</p>
                                <p>CEP: {{ $endereco->cep }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Opções de entrega -->
            <div>
                <h2 class="font-extrabold uppercase mb-4">Opções de entrega</h2>
                <p class="text-sm text-gray-600">Entrega padrão — R$15,00</p>
            </div>

            <!-- Pagamento -->
            <div>
                <h2 class="font-extrabold uppercase mb-4">Pagamento</h2>
                <p class="text-sm text-gray-600">Será gerada uma chave PIX após finalizar.</p>
            </div>
        </div>

        <!-- Coluna direita: resumo pedido -->
        <div class="border-l border-gray-300 pl-8">
            <h2 class="font-extrabold uppercase mb-6">Seu Pedido</h2>

            @php $total = 0; @endphp
            @foreach($carrinho->itens as $item)
                @php 
                    $subtotal = $item->quantidade * $item->produto->preco;
                    $total += $subtotal;
                    $fotos = json_decode($item->produto->fotos ?? '[]', true);
                    $foto = $fotos[0] ?? null;
                @endphp

                <div class="flex items-center justify-between border-b border-gray-200 py-4">
                    <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/80' }}" 
                         alt="{{ $item->produto->nome }}" 
                         class="w-20 h-20 object-cover rounded">

                    <div class="flex-1 ml-4">
                        <p class="text-sm font-semibold">{{ $item->produto->nome }}</p>
                        <p class="text-xs text-gray-500">Tam: {{ $item->tamanho }} | Qtd: {{ $item->quantidade }}</p>
                        <p class="text-sm font-medium mt-1">R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
                    </div>

                    <a href="{{ route('carrinho.ver') }}" class="text-xs font-semibold uppercase text-gray-700 hover:underline">
                        Editar
                    </a>
                </div>
            @endforeach

            <div class="flex justify-between mt-4 text-sm">
                <span>Entrega</span>
                <span>R$ 15,00</span>
            </div>

            <div class="flex justify-between mt-2 text-lg font-bold border-t border-gray-300 pt-3">
                <span>Total</span>
                <span>R$ {{ number_format($total + 15, 2, ',', '.') }}</span>
            </div>

            @if(!$enderecos->isEmpty())
            <button type="submit" 
                    class="w-full bg-black text-white font-bold py-4 mt-6 uppercase hover:bg-gray-800 transition">
                Finalizar Compra
            </button>
            @endif
        </div>
    </div>
</form>

</body>
</html>
