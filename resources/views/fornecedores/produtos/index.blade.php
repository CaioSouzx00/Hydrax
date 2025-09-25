<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Produtos - Fornecedor</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="/imagens/hydrax/lcf.png" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    /* Overlay */
    #overlay {
      position: fixed;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.5);
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
      z-index: 40;
    }

    #overlay.active {
      opacity: 0.5;
      pointer-events: auto;
    }

    /* Modais centralizados */
    .modal {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    .modal-content {
      background: #1f1f1f;
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
      max-width: 700px;
      width: 100%;
      padding: 2rem;
      color: white;
      transform: translateY(0);
      transition: transform 0.3s ease;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-white flex min-h-screen">


  <!-- Overlay para dropdown usuário -->
  <div id="overlay"></div>

  <!-- Sidebar -->
  <aside class="w-64 h-screen bg-black/40 backdrop-blur-md shadow-2xl border-r border-[#d5891b]/30 fixed z-50">
    <div class="h-40 border-b border-[#d5891b]/40 flex items-center justify-center">
      <img src="/imagens/hydrax/HYDRAX - LOGO1.png" alt="Hydrax Logo" class="h-32 hover:opacity-90 transition" />
    </div>

    <div class="p-4 space-y-4 text-sm">
      <a href="#"
        data-url="{{ route('fornecedores.produtos.create') }}"
        class="link-ajax block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#2d4e50] transition shadow-md text-center">
        Cadastrar Produto
      </a>

      <a href="#"
        data-url="{{ route('fornecedores.produtos.listar') }}"
        class="link-ajax block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#2d4e50] transition shadow-md text-center">
        Produtos Cadastrados
      </a>
    </div>
  </aside>

  <!-- Conteúdo Principal -->
  <div class="ml-64 flex-1 flex flex-col min-h-screen">

    <!-- Navbar -->
    <header class="bg-black/40 backdrop-blur-md border-b border-[#d5891b] fixed top-0 left-64 right-0 z-40 h-16 flex items-center justify-between px-6">
      <h2 class="text-xl font-semibold">Produtos <span class="text-[#d5891b]">| Fornecedor</span></h2>

      <div id="user-dropdown" class="relative group flex items-center space-x-2 cursor-pointer">
        <div class="w-10 h-10 rounded-full flex items-center justify-center transition-colors">
<button 
    onclick="window.history.back()" 
    class="group fixed top-3 right-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#117c66]"
    title="Voltar" aria-label="Botão Voltar">
    
    <div class="flex items-center justify-center w-10 h-10 shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </div>
    <span class="ml-2 w-0 group-hover:w-auto opacity-0 group-hover:opacity-100 overflow-hidden whitespace-nowrap transition-all duration-300 ease-in-out">
        Voltar
    </span>
</button>
        </div>
        <form method="POST" action="{{ route('fornecedores.logout') }}">
          @csrf
        </form>
      </div>
    </header>

    <!-- Modal Exclusão -->
    <div id="modal-excluir" class="modal hidden">
      <div class="modal-content">
        <h2 class="text-red-600 text-3xl font-bold mb-4">Atenção: Exclusão de Produto</h2>
        <p class="mb-4 text-lg">
          Você está prestes a excluir um produto do sistema. Esta ação é
          <span class="text-red-400 font-bold">irreversível</span>.
        </p>
        <ul class="list-disc pl-6 mb-6 text-gray-300 space-y-2">
          <li>Perda permanente de todas as imagens associadas.</li>
          <li>Remoção de preço, tamanhos e estoque.</li>
          <li>Impacto financeiro se o produto estiver ativo na loja.</li>
        </ul>
        <form id="form-excluir-produto" method="POST" action="">
          @csrf
          @method('DELETE')
          <div class="flex justify-end gap-4">
            <button type="button" id="btn-cancelar-exclusao" class="px-5 py-2 bg-gray-600 rounded hover:bg-gray-700 transition">Cancelar</button>
            <button type="submit" class="px-5 py-2 bg-red-600 rounded hover:bg-red-700 transition">Confirmar Exclusão</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Ativar/Desativar -->
    <div id="modal-toggle" class="modal hidden">
      <div class="modal-content">
        <h2 id="modal-toggle-titulo" class="text-yellow-500 text-3xl font-bold mb-4">Confirmar ação</h2>
        <p id="modal-toggle-texto" class="mb-8 text-lg">Tem certeza que deseja alterar o status deste produto?</p>
        <form id="form-toggle-produto" method="POST" action="">
          @csrf
          @method('PATCH')
          <div class="flex justify-end gap-4">
            <button type="button" id="btn-cancelar-toggle" class="px-5 py-2 bg-gray-600 rounded hover:bg-gray-700 transition">Cancelar</button>
            <button type="submit" class="px-5 py-2 bg-yellow-500 rounded hover:bg-yellow-600 transition text-black">Confirmar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Conteúdo Dinâmico -->
    <main class="pt-20 px-8 flex-1 overflow-y-auto" id="main-content">
      <div id="conteudo-dinamico">
        <div id="conteudo-dinamico" 
     class="flex flex-col items-center justify-center text-center mt-24">
       
  <!-- Ícone -->
  <div class="w-16 h-16 flex items-center justify-center rounded-full bg-[#d5891b]/10 border border-[#d5891b]/40 mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" 
         class="h-8 w-8 text-[#d5891b]" 
         fill="none" 
         viewBox="0 0 24 24" 
         stroke="currentColor">
      <path stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </div>

  <!-- Texto -->
  <h2 class="text-2xl font-bold text-white">Bem-vindo ao painel</h2>
  <p class="text-gray-400 mt-3 max-w-xl">
    Use o menu lateral para <span class="text-[#d5891b] font-semibold">cadastrar</span>, 
    <span class="text-[#d5891b] font-semibold">editar</span> ou 
    <span class="text-[#d5891b] font-semibold">gerenciar</span> seus produtos.
  </p>
</div>

      </div>
    </main>

  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    const overlay = document.getElementById('overlay');

    // ---------- MODAL EXCLUIR ----------
    $(document).on('click', '.btn-excluir-produto', function() {
      const id = $(this).data('id');
      $('#form-excluir-produto').attr('action', '/fornecedores/produtos/' + id);
      $('#modal-excluir').removeClass('hidden').fadeIn();
      overlay.classList.add('active');
    });

    $('#btn-cancelar-exclusao').click(function() {
      $('#modal-excluir').fadeOut(function() {
        $(this).addClass('hidden');
      });
      overlay.classList.remove('active');
    });

    // ---------- MODAL ATIVAR/DESATIVAR ----------
    $(document).on('click', '.toggle-form button', function() {
      const form = $(this).closest('form');
      const ativo = $(this).text().trim() === 'Desativar';

      $('#modal-toggle-titulo').text(ativo ? 'Ativar Produto' : 'Destivar Produto');
      $('#modal-toggle-texto').text(
        ativo ?
        'Você está prestes a desativar este produto. Ele ficará indisponível na loja.' :
        'Você está prestes a ativar este produto. Ele ficará disponível na loja.'
      );

      $('#form-toggle-produto').attr('action', form.attr('action'));

      $('#modal-toggle').removeClass('hidden').fadeIn();
      overlay.classList.add('active');
    });

    $('#btn-cancelar-toggle').click(function() {
      $('#modal-toggle').fadeOut(function() {
        $(this).addClass('hidden');
      });
      overlay.classList.remove('active');
    });

    // Fechar modais clicando no overlay
    overlay.addEventListener('click', () => {
      $('#modal-excluir, #modal-toggle').fadeOut(function() {
        $(this).addClass('hidden');
      });
      overlay.classList.remove('active');
    });

    // Submissão permanece igual
    $('#form-toggle-produto').submit(function() {
      this.submit();
    });
    $('#form-excluir-produto').submit(function() {
      this.submit();
    });

    // AJAX navegação permanece igual
    $(document).on('click', '.link-ajax', function(e) {
      e.preventDefault();
      const url = $(this).data('url');
      $('#conteudo-dinamico').html('<p class="text-gray-300">Carregando...</p>');
      $.get(url, function(data) {
        $('#conteudo-dinamico').html(data);
      }).fail(function() {
        $('#conteudo-dinamico').html('<p class="text-red-500">Erro ao carregar conteúdo.</p>');
      });
    });

    
  </script>

</body>

</html>