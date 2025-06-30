<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Meu Perfil - Hydrax</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<a href="http://127.0.0.1:8080/dashboard"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#4a8978]"
   title="Voltar para Início" aria-label="Botão Voltar">

  <!-- Ícone sempre visível e centralizado -->
  <div class="flex items-center justify-center w-10 h-10 shrink-0">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </div>

  <!-- Texto invisível até o hover, mas com espaço reservado -->
  <span class="ml-2 w-0 group-hover:w-auto opacity-0 group-hover:opacity-100 overflow-hidden whitespace-nowrap transition-all duration-300 ease-in-out">
    Voltar
  </span>
</a>


<div class="flex min-h-screen p-8">

    <!-- Menu lateral -->
    <aside class="w-1/4 bg-white rounded-lg shadow p-5">
        <div class="text-center mb-6">
            <div class="w-20 h-20 rounded-full bg-orange-500 text-white flex items-center justify-center text-3xl font-bold select-none mx-auto">
                {{ collect(explode(' ', $usuario->nome_completo))->map(fn($p) => strtoupper(substr($p, 0, 1)))->join('') }}
            </div>
            <p class="mt-2 font-semibold text-gray-800">{{ $usuario->nome_completo }}</p>
        </div>

        <ul class="text-sm space-y-3 text-gray-700">
            <li>
                <a href="#" data-tab="perfil" class="menu-link text-orange-500 font-semibold hover:text-orange-600">👤 Perfil</a>
            </li>
            <li class="relative">
                <a href="#" data-tab="enderecos" class="menu-link hover:text-orange-600 block">🏠 Endereços</a>
                <!-- Submenu de Endereços -->
                <div id="submenu-enderecos" class="hidden flex flex-col ml-6 mt-1 text-sm text-gray-700">
                    <a href="#" id="criar-endereco-link" class="py-1 hover:text-orange-600">➕ Create</a>
                </div>
            </li>
            <li>
                <a href="#" data-tab="cartoes" class="menu-link hover:text-orange-600">💳 Cartões / Contas Bancárias</a>
            </li>
            <li>
                <a href="#" data-tab="senha" class="menu-link hover:text-orange-600">🔒 Trocar Senha</a>
            </li>
            <li>
                <a href="#" data-tab="privacidade" class="menu-link hover:text-orange-600">🔐 Configurações de Privacidade</a>
            </li>
        </ul>
    </aside>

    <!-- Conteúdo dinâmico -->
    <main id="conteudo-principal" class="flex-1 bg-white rounded-lg shadow ml-8 p-6 overflow-auto">
        <div class="text-center mt-20">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">👋 Olá! Seja bem-vindo ao seu painel</h2>
            <p class="text-gray-600">Selecione uma opção no menu à esquerda para começar a gerenciar suas informações.</p>
            <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Bem-vindo" class="w-32 mx-auto mt-6 opacity-70" />
        </div>
    </main>
</div>

<script>
    // Função para adicionar event listeners nos botões de editar dentro da lista de endereços
    function adicionarListenersEditarEnderecos() {
        document.querySelectorAll('.editar-endereco').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const enderecoId = this.dataset.id;

                fetch(`/usuarios/enderecos/${enderecoId}/edit`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Erro ao carregar formulário de edição');
                    return res.text();
                })
                .then(formHtml => {
                    document.getElementById('conteudo-principal').innerHTML = formHtml;
                })
                .catch(() => alert('Erro ao carregar formulário de edição'));
            });
        });
    }

    // Clique nos links do menu lateral
    document.querySelectorAll('.menu-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const tab = this.dataset.tab;
            const submenu = document.getElementById('submenu-enderecos');

            if (tab === 'enderecos') {
                submenu.classList.remove('hidden');
                fetch('/usuarios/enderecos', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao carregar lista de endereços');
                    return response.text();
                })
                .then(html => {
                    document.getElementById('conteudo-principal').innerHTML = html;
                    adicionarListenersEditarEnderecos();
                })
                .catch(() => {
                    document.getElementById('conteudo-principal').innerHTML = '<p class="text-red-600">Erro ao carregar conteúdo.</p>';
                });

            } else if (tab === 'perfil') {
                submenu.classList.add('hidden');
                fetch('/usuarios/perfil', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao carregar perfil');
                    return response.text();
                })
                .then(html => {
                    document.getElementById('conteudo-principal').innerHTML = html;
                })
                .catch(() => {
                    document.getElementById('conteudo-principal').innerHTML = '<p class="text-red-600">Erro ao carregar perfil.</p>';
                });

            } else {
                submenu.classList.add('hidden');
                document.getElementById('conteudo-principal').innerHTML = '';
            }
        });
    });

    // Listener para o botão Create do submenu Endereços
    document.getElementById('criar-endereco-link').addEventListener('click', function(e) {
        e.preventDefault();

        fetch('/usuarios/enderecos/create', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) throw new Error('Erro ao carregar formulário de criação');
            return response.text();
        })
        .then(html => {
            document.getElementById('conteudo-principal').innerHTML = html;
        })
        .catch(() => {
            document.getElementById('conteudo-principal').innerHTML = '<p class="text-red-600">Erro ao carregar conteúdo.</p>';
        });
    });
</script>

</body>
</html>
