<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pagamento Pix - Hydrax</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center font-sans">


    <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-lg text-center">

        <!-- Título -->
        <h1 class="text-3xl font-extrabold mb-6 tracking-tight text-gray-900">
            Finalize seu pagamento
        </h1>

        <!-- Endereço de entrega -->
        <div class="bg-white border border-gray-200 p-6 rounded-xl mb-6 text-left shadow-sm">
            <h2 class="font-bold mb-2 text-lg">Endereço de entrega</h2>
            <p>{{ $enderecoSelecionado->rua }}, {{ $enderecoSelecionado->numero }}</p>
            <p>{{ $enderecoSelecionado->bairro }} - {{ $enderecoSelecionado->cidade }}/{{ $enderecoSelecionado->estado }}</p>
            <p>CEP: {{ $enderecoSelecionado->cep }}</p>
        </div>

        <!-- Texto -->
        <p class="mb-3 text-gray-700">Use a chave Pix abaixo:</p>

        <!-- Chave Pix -->
        <div class="bg-gray-900 text-white p-4 rounded-lg text-lg font-mono tracking-wider mb-6">
            {{ $chavePix }}
        </div>

        <!-- Valor -->
        <p class="font-bold text-2xl text-gray-900 mb-8">
            Total: R$ {{ number_format($total, 2, ',', '.') }}
        </p>

        <!-- Info -->
        <p class="text-sm text-gray-500 mb-8">
            Essa chave Pix também foi enviada para seu e-mail cadastrado.
        </p>

        <!-- Botão voltar -->
        <a href="{{ route('carrinho.ver') }}" 
           class="inline-block bg-black text-white font-bold py-3 px-8 rounded-full hover:bg-gray-800 transition-all duration-200 shadow-md">
           Voltar para o carrinho
        </a>
    </div>

</body>
</html>