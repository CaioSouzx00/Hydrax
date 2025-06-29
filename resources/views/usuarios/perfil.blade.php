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
            <img src="https://via.placeholder.com/80" alt="Foto do usuário" class="w-20 h-20 rounded-full mx-auto object-cover" />
            <p class="mt-2 font-semibold"></p>
        </div>

        <ul class="text-sm space-y-3 text-gray-700">
            <li>
                <a href="#" data-tab="perfil" class="menu-link text-orange-500 font-semibold hover:text-orange-600">👤 Perfil</a>
            </li>
            <li class="relative">
                <a href="#" data-tab="enderecos" class="menu-link hover:text-orange-600 block">🏠 Endereços</a>
                <!-- Submenu de Endereços -->
                <div id="submenu-enderecos" class="hidden flex flex-col ml-6 mt-1 text-sm text-gray-700">
                    <a href="#" class="py-1 hover:text-orange-600">➕ Create</a>
                    <a href="#" class="py-1 hover:text-orange-600">✏️ Update</a>
                    <a href="#" class="py-1 hover:text-red-600">🗑️ Delete</a>
                </div>
            </li>
            <li>
                <a href="#" class="menu-link hover:text-orange-600">💳 Cartões / Contas Bancárias</a>
            </li>
            <li>
                <a href="#" class="menu-link hover:text-orange-600">🔒 Trocar Senha</a>
            </li>
            <li>
                <a href="#" class="menu-link hover:text-orange-600">🔐 Configurações de Privacidade</a>
            </li>
        </ul>
    </aside>

    <!-- Conteúdo dinâmico -->
    <main id="conteudo-principal" class="flex-1 bg-white rounded-lg shadow ml-8 p-6 overflow-auto">

    </main>
</div>

<!-- JS para troca de abas e menus -->
<script>
    document.querySelectorAll('.menu-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const tab = this.dataset.tab;

            const submenu = document.getElementById('submenu-enderecos');
            if (tab === 'enderecos') {
                submenu.classList.remove('hidden');
            } else {
                submenu.classList.add('hidden');
            }

            let url = '';
            if (tab === 'perfil') {
                url = '/usuarios/perfil';
            } else {
                return;
            }

            // AQUI VOCÊ SUBSTITUI ESSA PARTE:
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Erro na resposta');
                return response.text();
            })
            .then(html => {
                document.getElementById('conteudo-principal').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('conteudo-principal').innerHTML = '<p class="text-red-600">Erro ao carregar conteúdo.</p>';
            });

        });
    });
</script>




</body>
</html>
