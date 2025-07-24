<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Meu Perfil - Hydrax</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<!-- Botão flutuante voltar -->
<a href="http://127.0.0.1:8080/dashboard"
   class="group fixed top-4 left-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#4a8978]"
   title="Voltar para Início" aria-label="Botão Voltar">
  <div class="flex items-center justify-center w-10 h-10 shrink-0">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </div>
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
                <div id="submenu-enderecos" class="hidden flex flex-col ml-6 mt-1 text-sm text-gray-700">
                    <a href="#" id="criar-endereco-link" class="py-1 hover:text-orange-600">➕ Create</a>
                </div>
            </li>
            <li>
                <a href="#" data-tab="senha" class="menu-link hover:text-orange-600">🔒 Trocar Senha</a>
            </li>
            <li>
                <a href="#" data-tab="email" class="menu-link hover:text-orange-600">🔒 Trocar Email</a>
            </li>
        </ul>
    </aside>


    <!-- Loader, inicialmente escondido -->
    <div id="loader-main" class="hidden absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center rounded">
        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
    </div>

    <!-- Conteúdo dinâmico -->
    <main id="conteudo-principal" class="flex-1 bg-white rounded-lg shadow ml-8 p-6 overflow-auto relative">

    <!-- Conteúdo inicial -->
    <div class="text-center mt-20">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">👋 Olá! Seja bem-vindo ao seu painel</h2>
        <p class="text-gray-600">Selecione uma opção no menu à esquerda para começar a gerenciar suas informações.</p>
        <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Bem-vindo" class="w-32 mx-auto mt-6 opacity-70" />
    </div>

</main>

</div>

<script>
    // Event delegation para capturar submit do form-verificar-senha dentro do conteúdo dinâmico
    document.getElementById('conteudo-principal').addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'form-verificar-senha') {
            e.preventDefault();

            const formData = new FormData(e.target);

            fetch('/verificar', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': formData.get('_token')
                },
                body: formData
            })
            .then(res => {
                if (res.status === 401) throw new Error('Senha incorreta.');
                if (!res.ok) throw new Error('Erro ao verificar senha.');
                return res.text();
            })
            .then(html => {
                document.getElementById('conteudo-principal').innerHTML = html;
            })
            .catch(err => alert(err.message));
        }
    });

    // Função para adicionar listeners nos botões de editar endereço (quando conteúdo é carregado)
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


document.addEventListener('DOMContentLoaded', function () {
    const principal = document.getElementById('conteudo-principal');
    const loader = document.getElementById('loader-main');

    principal.addEventListener('click', function (e) {
        const el = e.target;
        if (el && el.id === 'link-nao-sei-senha') {
    e.preventDefault();

    loader.classList.remove('hidden');  // mostra loader

    const start = Date.now(); // marca o tempo

    fetch('/usuarios/senha/verificar-codigo', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('Erro ao carregar formulário de verificação');
        return res.text();
    })
    .then(html => {
        const elapsed = Date.now() - start;
        const delay = Math.max(1000 - elapsed, 0); // garante ao menos 1s de loading visual
        setTimeout(() => {
            loader.classList.add('hidden');  // esconde loader
            principal.innerHTML = html;
        }, delay);
    })
    .catch(err => {
        loader.classList.add('hidden');  // esconde loader em erro
        alert(err.message);
    });
}

    });
});





document.getElementById('conteudo-principal').addEventListener('submit', function(e) {
    if (e.target && e.target.id === 'form-verificar-codigo') {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token')
            },
            body: formData
        })
        .then(res => {
            if (res.status === 401) throw new Error('Código incorreto.');
            if (!res.ok) throw new Error('Erro ao verificar código.');
            return res.text();
        })
        .then(html => {
            document.getElementById('conteudo-principal').innerHTML = html;
        })
        .catch(err => alert(err.message));
    }
});



document.getElementById('conteudo-principal').addEventListener('submit', function(e) {
  if (e.target && e.target.id === 'form-trocar-senha') {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.sucesso) {
        alert(data.sucesso);
        document.getElementById('conteudo-principal').innerHTML = '';
      } else {
        alert('Erro ao trocar senha.');
      }
    })
    .catch(() => alert('Erro ao trocar senha.'));
  }
});






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

            } else if (tab === 'email') {
                submenu.classList.add('hidden');
                fetch('/usuarios/email', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao carregar tela de troca de e-mail');
                    return response.text();
                })
                .then(html => {
                    document.getElementById('conteudo-principal').innerHTML = html;
                })
                .catch(() => {
                    document.getElementById('conteudo-principal').innerHTML = '<p class="text-red-600">Erro ao carregar conteúdo.</p>';
                });

            } else if (tab === 'senha') {
                submenu.classList.add('hidden');
                fetch('/verificar', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao carregar verificação de senha');
                    return response.text();
                })
                .then(html => {
                    document.getElementById('conteudo-principal').innerHTML = html;
                })
                .catch(() => {
                    document.getElementById('conteudo-principal').innerHTML = '<p class="text-red-600">Erro ao carregar conteúdo.</p>';
                });
            } else {
                submenu.classList.add('hidden');
                document.getElementById('conteudo-principal').innerHTML = '';
            }
        });
    });

    // Botão "Create" dos endereços
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



<!-- Rodapé estilo Nike -->
<footer class="bg-black text-gray-400 mt-8">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-2 md:grid-cols-4 gap-8 text-sm">
        <div>
            <h3 class="text-white font-semibold mb-4">Ajuda</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-white transition">Status do pedido</a></li>
                <li><a href="#" class="hover:text-white transition">Envio e Entrega</a></li>
                <li><a href="#" class="hover:text-white transition">Devoluções</a></li>
                <li><a href="#" class="hover:text-white transition">Opções de Pagamento</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-white font-semibold mb-4">Sobre a Hydrax</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-white transition">Quem Somos</a></li>
                <li><a href="#" class="hover:text-white transition">Sustentabilidade</a></li>
                <li><a href="#" class="hover:text-white transition">Trabalhe Conosco</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-white font-semibold mb-4">Redes Sociais</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-white transition">Instagram</a></li>
                <li><a href="#" class="hover:text-white transition">Facebook</a></li>
                <li><a href="#" class="hover:text-white transition">Twitter</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-white font-semibold mb-4">Legal</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-white transition">Termos de Uso</a></li>
                <li><a href="#" class="hover:text-white transition">Política de Privacidade</a></li>
                <li><a href="#" class="hover:text-white transition">Cookies</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-gray-700">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
            <span>&copy; {{ date('Y') }} Hydrax. Todos os direitos reservados.</span>
            <span class="mt-2 md:mt-0">Feito com 💧 por Caio Daniel</span>
        </div>
    </div>
</footer>

</body>
</html>