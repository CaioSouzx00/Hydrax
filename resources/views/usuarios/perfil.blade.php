<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Meu Perfil - Hydrax</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen p-8">

    <!-- Menu lateral -->
    <aside class="w-1/4 bg-white rounded-lg shadow p-5">
        <div class="text-center mb-6">
            <img src="{{ asset('storage/' . $usuario->foto) }}" alt="Foto do usuário" class="w-20 h-20 rounded-full mx-auto object-cover" />
            <p class="mt-2 font-semibold">{{ $usuario->username }}</p>
        </div>

        <ul class="text-sm space-y-3 text-gray-700">
            <li>
                <a href="#" onclick="carregarConteudo('{{ route('usuarios.perfil.conteudo') }}'); return false;" class="text-orange-500 font-semibold block hover:text-orange-600">👤 Perfil</a>
            </li>
            <li>
              <a href="#" onclick="carregarConteudo('{{ route('usuarios.enderecos.conteudo', ['id' => $usuario->id_usuarios]) }}'); return false;">🏠 Endereços</a>
            </li>
            <li><a href="#" class="block hover:text-orange-600">💳 Cartões / Contas Bancárias</a></li>
            <li><a href="#" class="block hover:text-orange-600">🔒 Trocar Senha</a></li>
            <li><a href="#" class="block hover:text-orange-600">🔐 Configurações de Privacidade</a></li>
        </ul>
    </aside>

    <!-- Área do conteúdo que vai mudar -->
    <main id="conteudo-principal" class="flex-1 bg-white rounded-lg shadow ml-8 p-6 overflow-auto">
        {{-- Conteúdo inicial carregado na página --}}
        @include('usuarios.partials.perfil')
    </main>
</div>

<script>
    function carregarConteudo(url) {
        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Erro na requisição');
                return response.text();
            })
            .then(html => {
                document.getElementById('conteudo-principal').innerHTML = html;
            })
            .catch(() => {
                alert('Erro ao carregar conteúdo. Tente novamente.');
            });
            
    }
</script>

</body>
</html>
