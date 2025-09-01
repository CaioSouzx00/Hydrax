<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="/imagens/hydrax/hydrax-perfil.png" type="image/png" />
    <title>Meu Perfil - Hydrax</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] font-sans text-white">

<a href="{{ url()->previous() }}"
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


<div class="flex min-h-screen p-8 gap-8">

<aside class="w-1/4 bg-[#1a1a1a]/50 rounded-lg shadow-lg p-5 border border-[#2c2c2c]">
  <div class="text-center mb-6">
    <div class="w-20 h-20 rounded-full bg-[#0aa174] text-white flex items-center justify-center text-3xl font-bold select-none mx-auto">
      {{ collect(explode(' ', $usuario->nome_completo))->map(fn($p) => strtoupper(substr($p, 0, 1)))->join('') }}
    </div>
    <p class="mt-2 font-semibold text-white">{{ $usuario->nome_completo }}</p>
  </div>

  <ul class="text-sm space-y-4 text-gray-300">
    <li class="flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-white" viewBox="0 0 24 24">
        <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
      </svg>
      <a href="#" data-tab="perfil" class="menu-link hover:text-[#D5891B]">Perfil</a>
    </li>

    <li class="relative flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-white" viewBox="0 0 24 24">
        <path d="M12 2L2 7v15h20V7L12 2zm0 2.18L18.6 7 12 11.82 5.4 7 12 4.18zM4 9.27l8 5.45 8-5.45V20H4V9.27z"/>
      </svg>
      <a href="#" data-tab="enderecos" class="menu-link hover:text-[#D5891B] block">Endereços</a>
    </li>

    <div id="submenu-enderecos" class="hidden flex flex-col ml-7 mt-1 text-sm text-gray-400">
      <a href="#" id="criar-endereco-link" class="py-1 hover:text-[#D5891B]">+ Create</a>
    </div>

    <li class="flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-white" viewBox="0 0 24 24">
        <path d="M12 17a2 2 0 100-4 2 2 0 000 4zm6-6V9a6 6 0 00-12 0v2H4v10h16V11h-2zm-8-2a4 4 0 118 0v2H10V9z"/>
      </svg>
      <a href="#" data-tab="senha" class="menu-link hover:text-[#D5891B]">Trocar Senha</a>
    </li>

    <li class="flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-white" viewBox="0 0 24 24">
        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
      </svg>
      <a href="#" data-tab="email" class="menu-link hover:text-[#D5891B]">Trocar Email</a>
    </li>

    <li class="flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-white" viewBox="0 0 24 24">
        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 2.18L18.6 7 12 11.82 5.4 7 12 3.18zM12 13l6-4.2V11c0 4.2-2.64 8.16-6 9.75C8.64 19.16 6 15.2 6 11V8.8L12 13z"/>
      </svg>
      <a href="#" data-tab="privacidade" class="menu-link hover:text-[#D5891B]">Config. de Privacidade</a>
    </li>
  </ul>
</aside>

<!-- Script para trocar a cor ativa -->
<script>
  document.querySelectorAll('.menu-link').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();

      // Remove estilos ativos de todos
      document.querySelectorAll('.menu-link').forEach(l => {
        l.classList.remove('text-[#14BA88]', 'font-bold');
        l.classList.add('text-gray-300');
      });

      // Aplica ao clicado
      this.classList.remove('text-gray-300');
      this.classList.add('text-[#14BA88]', 'font-bold');
    });
  });
</script>



    <!-- Loader -->
    <div id="loader-main" class="hidden absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center rounded">
        <svg class="animate-spin h-8 w-8 text-[#d5891b]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
    </div>

    <!-- Conteúdo -->
    <main id="conteudo-principal" class="flex-1 bg-[#1a1a1a]/50 rounded-lg shadow-lg p-6 relative border border-[#2c2c2c]">

<div class="max-w-xl mx-auto mt-20 px-6 py-10 rounded-3xl text-center">
  <h2 class="text-3xl font-semibold text-white mb-3 leading-tight">
    Olá, seja bem-vindo ao seu painel
  </h2>
  <p class="text-gray-400 text-base max-w-md mx-auto mb-8">
    Use o menu à esquerda para gerenciar suas informações com segurança e eficiência.
  </p>
  <img 
    src="https://cdn-icons-png.flaticon.com/512/747/747376.png" 
    alt="Bem-vindo" 
    class="mx-auto w-24 opacity-60"
    style="filter: grayscale(40%) contrast(90%)"
  />
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


    document.getElementById('conteudo-principal').addEventListener('submit', function (e) {
        if (e.target && e.target.id === 'form-solicitar-exclusao') {
            e.preventDefault();

            const form = e.target;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(form)
            })
            .then(res => res.json())
            .then(data => {
                alert(data.mensagem);

                // Opcional: esvaziar ou atualizar o conteúdo principal após exclusão
                document.getElementById('conteudo-principal').innerHTML = `
                    <div class="text-center py-12">
                        <h2 class="text-2xl font-bold text-red-600 mb-4">Conta marcada para exclusão</h2>
                        <p class="text-gray-700">Você receberá um e-mail com instruções caso deseje cancelar.</p>
                    </div>
                `;
            })
            .catch(() => alert('Erro ao solicitar exclusão.'));
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
        }  else if (tab === 'privacidade') {
    submenu.classList.add('hidden');

    const loader = document.getElementById('loader-main');
    const principal = document.getElementById('conteudo-principal');

    loader.classList.remove('hidden');

    const start = Date.now();

    fetch('/privacidade', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => {
        if (!response.ok) throw new Error('Erro ao carregar configurações de privacidade');
        return response.text();
    })
    .then(html => {
        const elapsed = Date.now() - start;
        const delay = Math.max(1000 - elapsed, 0);

        setTimeout(() => {
            loader.classList.add('hidden');
            principal.innerHTML = html;
        }, delay);
    })
    .catch(() => {
        loader.classList.add('hidden');
        principal.innerHTML = '<p class="text-red-600">Erro ao carregar configurações de privacidade.</p>';
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
