<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
      <link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
    <title>Pagamento Pix - Hydrax</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-[#211828] via-[#0b282a] to-[#17110d] min-h-screen flex items-center justify-center font-sans text-white">

    <div class="bg-white/5 backdrop-blur-lg border border-white/10 p-10 rounded-2xl shadow-2xl w-full max-w-lg text-center">

        <!-- Título -->
        <h1 class="text-3xl font-extrabold mb-6 tracking-tight text-[#14ba88]">
            Finalize seu pagamento
        </h1>

        <!-- Endereço de entrega -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl mb-6 shadow-md text-left">
            <h2 class="font-bold mb-2 text-lg text-[#14ba88]">Endereço de entrega</h2>
            <p>{{ $enderecoSelecionado->rua }}, {{ $enderecoSelecionado->numero }}</p>
            <p>{{ $enderecoSelecionado->bairro }} - {{ $enderecoSelecionado->cidade }}/{{ $enderecoSelecionado->estado }}</p>
            <p>CEP: {{ $enderecoSelecionado->cep }}</p>
        </div>

        <!-- Texto -->
        <p class="mb-3 text-gray-300">Use a chave Pix abaixo:</p>

        <!-- Chave Pix -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 text-[#14ba88] p-4 rounded-lg text-lg font-mono tracking-wider mb-6">
            {{ $chavePix }}
        </div>

        @if($cupomAplicado)
            <p class="text-green-400 mb-2">Desconto aplicado: R$ {{ number_format($desconto, 2, ',', '.') }}</p>
        @endif

        <p class="font-bold text-2xl text-white mb-8">
            Total: R$ {{ number_format($total, 2, ',', '.') }}
        </p>

        <!-- Info -->
        <p class="text-sm text-gray-400 mb-8">
            Essa chave Pix também foi enviada para seu e-mail cadastrado.
        </p>

        <!-- Botão voltar -->
        <a href="{{ route('carrinho.ver') }}" 
           class="inline-block bg-[#14ba88]/90 text-black font-bold py-3 px-8 rounded-full hover:bg-[#14ba88]/100 transition-all duration-200 shadow-lg backdrop-blur-sm">
           Voltar para o carrinho
        </a>
    </div>

</body>
</html>
