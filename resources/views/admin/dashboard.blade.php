<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/imagens/hydrax/hydrax-perfil.png" type="image/png" />
  <title>Dashboard Adm</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Particles.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    @keyframes moveBackground {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    body {
      background: linear-gradient(45deg,rgb(0, 0, 0),rgb(23, 17, 13), #000000);
      background-size: 400% 400%;
      animation: moveBackground 15s ease infinite;
      position: relative;
      z-index: 1;
    }

    #particles-js {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    nav a.active {
      background-color: #7c3aed;
      color: white !important;
    }

    nav a.active span.opacity-0 {
      opacity: 1 !important;
    }
  </style>
</head>
<body class="min-h-screen overflow-hidden">

<nav class="fixed top-64 right-[calc(100%-12.5rem)] h-[calc(100vh-30rem)] bg-black/25 backdrop-blur-md border border-white/25 shadow-xl text-white z-10 rounded-3xl overflow-hidden group transition-all duration-300 w-14 hover:w-48 flex flex-col justify-between items-start py-4 origin-right">
    
  <div class="flex flex-col space-y-4 w-full px-2">
    <a href="{{ route('admin.relatorios.usuarios') }}" class="flex items-center space-x-3 px-2 py-2 hover:bg-[#211828] rounded-md transition">
      <span class="text-lg"></span>
      <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Relatorios Usuarios</span>
    </a>
    <a href="{{ route('admin.relatorios.fornecedores') }}" class="flex items-center space-x-3 px-2 py-2 hover:bg-[#211828] rounded-md transition">
      <span class="text-lg"></span>
      <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Relatorios Fornecedores/span>
    </a> 
    <a href="{{ route('admin.relatorios.produtos') }}" class="flex items-center space-x-3 px-2 py-2 hover:bg-[#211828] rounded-md transition">
      <span class="text-lg"></span>
      <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Relatorios Pordutos</span>
    </a>
  </div>

  <div class="flex flex-col justify-between space-y-4 w-full px-2">
   <form id="logoutForm" method="POST" action="{{ route('admin.logout') }}" class="w-full">
    @csrf
    <button type="submit" class="flex items-center gap-2 px-2 py-2 hover:bg-[#211828] rounded-md transition text-white w-full">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
      </svg>
      <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Sair</span>
    </button>
   </form>
  </div>
</nav>

<!-- Conteúdo principal -->
<div class="ml-[17.5rem] mt-8 mr-64 h-[calc(7vh-0.5rem)] bg-black/25 backdrop-blur-md border border-white/25 shadow-xl text-white rounded-3xl p-6 flex items-center justify-center"> 
  <div class="h-8 w-[2%] mr-32 bg-black/20 rounded-2xl shadow-inner px-4 flex items-center justify-center">
    <h1 class="flex items-center justify-left">Hx</h1>
  </div>
  <div class="h-8 w-[70%] bg-black/20 rounded-2xl shadow-inner px-4 flex items-center">
    <p class="text-sm md:text-base text-white">
      Bem-vindo, <span class="font-semibold text-white">{{ $admin->nome_usuario }}</span>, ao seu painel de administração.
    </p>
  </div> 
</div>

<!-- Retângulo principal -->
<div class="ml-[13.5rem] mt-5 mr-48 h-[calc(100vh-10rem)] bg-black/25 backdrop-blur-md border border-white/25 shadow-xl text-white rounded-2xl p-6 flex flex-col justify-between">

  <div class="flex justify-between gap-4 mb-4 h-[60%]">
    <div class="w-1/5 bg-black/20 rounded-xl border border-white/10 shadow-inner p-4">
      <h1 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#383838] to-white mb-6 text-center">
        Painel Fornecedor
      </h1>

      <div class="flex flex-col space-y-4">
        <a href="{{ route('fornecedores.pendentes') }}" class="w-full relative inline-flex items-center justify-start px-6 py-3 overflow-hidden font-medium transition-all bg-white rounded hover:bg-white group shadow-[0_4px_20px_rgba(33,24,40,0.5)]">
          <span class="w-48 h-48 rounded rotate-[-40deg] bg-[#211828] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
          <span class="relative w-full text-left text-[#211828] transition-colors duration-300 ease-in-out group-hover:text-white">Fornecedores Pendentes</span>
        </a>
        <a href="{{ route('admin.produtos.listar') }}" class="w-full relative inline-flex items-center justify-start px-6 py-3 overflow-hidden font-medium transition-all bg-white rounded hover:bg-white group shadow-[0_4px_20px_rgba(33,24,40,0.5)]">
        <span class="w-48 h-48 rounded rotate-[-40deg] bg-[#211828] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
        <span class="relative w-full text-left text-[#211828] transition-colors duration-300 ease-in-out group-hover:text-white">Listagem de Produtos</span>
        </a>

        <a href="{{ route('admin.clientes') }}" class="w-full relative inline-flex items-center justify-start px-6 py-3 overflow-hidden font-medium transition-all bg-white rounded hover:bg-white group shadow-[0_4px_20px_rgba(33,24,40,0.5)]">
          <span class="w-48 h-48 rounded rotate-[-40deg] bg-[#211828] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
          <span class="relative w-full text-left text-[#211828] transition-colors duration-300 ease-in-out group-hover:text-white">Gestão de Clientes</span>
        </a>

            <a href="{{ route('admin.fornecedores') }}" class="w-full relative inline-flex items-center justify-start px-6 py-3 overflow-hidden font-medium transition-all bg-white rounded hover:bg-white group shadow-[0_4px_20px_rgba(33,24,40,0.5)]">
          <span class="w-48 h-48 rounded rotate-[-40deg] bg-[#211828] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
          <span class="relative w-full text-left text-[#211828] transition-colors duration-300 ease-in-out group-hover:text-white">Gestão de Fornecedores</span>
        </a>
      </div>
    </div>

    <div class="w-3/4 bg-black/20 rounded-xl border border-white/30 shadow-inner p-4">
      <canvas id="userChart"></canvas>
    </div>
  </div>

  <div class="flex justify-between gap-4 h-[35%]">
    <div class="w-1/5 bg-black/30 rounded-xl border border-white/30 shadow-inner p-4">
      <div class="w-full h-full aspect-square rounded-xl relative overflow-hidden">
        <div class="relative w-full h-full rounded-lg overflow-hidden group">
          <img src="/imagens/hydrax/HYDRAX - LOGO1.png"
               alt="Logo"
               class="h-full w-full object-cover transition-opacity duration-500 group-hover:opacity-0"/>
          <div class="absolute inset-0 bg-gray-900/10 bg-opacity-80 text-white flex flex-col items-center justify-center px-4 text-center opacity-0 transition-opacity duration-500 group-hover:opacity-100">
            <h4 class="text-lg font-bold mb-1 border-b-4 border-[#B0B0B0] inline-block">Hydrax</h4>
            <p class="text-xs leading-tight">Este é o painel de Admins.</p>
            <p class="text-[10px] mt-1 text-gray-300">Gerenciamento de Usuários, Controle de Conteúdo, Acesso a Relatórios, Gerenciamento de Configurações e Monitoramento de Atividades.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="w-3/4 flex gap-4">
      <div class="w-1/4 bg-black/20 rounded-xl border border-white/30 shadow-inner p-4">
        <h1>Usuarios no Sistema</h1>
        <a href="#_" id="btnUsuarios" data-route="{{ route('dashboard.dadosGraficos') }}" class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-[#211828] inline-block">
          <span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-[#211828] group-hover:h-full"></span>
          <span class="relative group-hover:text-white">Usuarios / Fornecedores</span>
        </a>
      </div>
      
      <div class="w-1/4 bg-black/20 rounded-xl border border-white/30 shadow-inner p-4">
        <h1>Produtos no sistema</h1>
        <a href="#_" id="btnProdutos" data-route="{{ route('dashboard.dadosProdutos') }}" class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-[#211828] inline-block">
          <span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-[#211828] group-hover:h-full"></span>
          <span class="relative group-hover:text-white">Produtos</span>
        </a>
      </div>

      <div class="w-1/4 bg-black/20 rounded-xl border border-white/30 shadow-inner p-4">
        <h1>Vendas da Semana</h1>
        <a href="#_" id="btnVendasSemana" data-route="{{ route('dashboard.vendasSemana') }}"
           class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-[#211828] inline-block">
           <span class="absolute top-0 left-0 flex w-full h-0 transition-all duration-200 ease-out bg-[#211828] group-hover:h-full"></span>
           <span class="relative group-hover:text-white">Vendas Semana</span>
        </a>
      </div>

      <div class="w-1/4 bg-black/20 rounded-xl border border-white/30 shadow-inner p-4">
        <h1>Faturamento</h1>
        <a href="#_" id="btnFaturamentoSemana" data-route="{{ route('admin.faturamentoSemana') }}"
        class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-[#211828] inline-block">
        <span class="absolute top-0 left-0 flex w-full h-0 transition-all duration-200 ease-out bg-[#211828] group-hover:h-full"></span>
        <span class="relative group-hover:text-white">Faturamento Semana</span>
        </a>
      </div>
      <div class="w-1/4 bg-black/20 rounded-xl border border-white/30 shadow-inner p-4">
  <h1>Produtos Mais Vendidos</h1>
  <a href="#_" id="btnProdutosVendidos" data-route="{{ route('dashboard.produtosMaisVendidos') }}"
     class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-[#211828] inline-block">
     <span class="absolute top-0 left-0 flex w-full h-0 transition-all duration-200 ease-out bg-[#211828] group-hover:h-full"></span>
     <span class="relative group-hover:text-white">Top Produtos</span>
  </a>
</div>

    </div>
  </div>
</div>

<div id="particles-js"></div>

<script>
const ctx = document.getElementById('userChart').getContext('2d');
let userChart;

function montarGrafico(url, type = 'line') {
  fetch(url)
    .then(res => res.json())
    .then(data => {
      if(userChart) userChart.destroy();

      const datasets = [];

      if(data.usuarios && data.fornecedores){
        datasets.push(
          {
            label: 'Usuarios',
            data: data.usuarios,
            backgroundColor: 'rgba(213,137,27,0.2)',
            borderColor: 'rgba(213,137,27,1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: 'rgba(213,137,27,1)',
          },
          {
            label: 'Fornecedores',
            data: data.fornecedores,
            backgroundColor: 'rgba(20,186,136,0.2)',
            borderColor: 'rgba(20,186,136,1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: 'rgba(20,186,136,1)',
          }
        );
      }

      if(data.produtos){
        datasets.push({
          label: 'Produtos Cadastrados',
          data: data.produtos,
          backgroundColor: 'rgba(255,99,132,0.2)',
          borderColor: 'rgba(255,99,132,1)',
          borderWidth: 2,
          fill: true,
          tension: 0.4,
          pointRadius: 4,
          pointHoverRadius: 6,
          pointBackgroundColor: 'rgba(255,99,132,1)',
        });
      }

      if(data.totais){
        datasets.push({
          label: type === 'bar' ? 'Faturamento (R$)' : 'Produtos vendidos',
          data: data.totais,
          backgroundColor: type === 'bar' ? 'rgba(255,206,86,0.2)' : 'rgba(54,162,235,0.2)',
          borderColor: type === 'bar' ? 'rgba(255,206,86,1)' : 'rgba(54,162,235,1)',
          borderWidth: 2
        });
      }

      const labels = data.labels.map(l => {
        if(typeof l === 'number'){
          return ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'][l-1];
        } else {
          const dias = ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'];
          const date = new Date(l);
          return dias[date.getDay()];
        }
      });

      userChart = new Chart(ctx, {
        type: type,
        data: { labels: labels, datasets: datasets },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true, ticks:{ color:'#ddd' }, grid:{ color:'#444' } },
            x: { ticks:{ color:'#ddd' }, grid:{ color:'#444' } }
          },
          plugins: { legend: { labels: { color:'#ddd' } } }
        }
      });

    })
    .catch(err => console.error('Erro ao carregar gráfico:', err));
}

// Listeners separados
document.getElementById('btnUsuarios').addEventListener('click', () => {
  montarGrafico(document.getElementById('btnUsuarios').dataset.route, 'line');
});

document.getElementById('btnProdutos').addEventListener('click', () => {
  montarGrafico(document.getElementById('btnProdutos').dataset.route, 'line');
});

document.getElementById('btnVendasSemana').addEventListener('click', () => {
  montarGrafico(document.getElementById('btnVendasSemana').dataset.route, 'bar');
});

document.getElementById('btnFaturamentoSemana').addEventListener('click', () => {
  montarGrafico(document.getElementById('btnFaturamentoSemana').dataset.route, 'bar');
});

document.getElementById('btnProdutosVendidos').addEventListener('click', () => {
  montarGrafico(document.getElementById('btnProdutosVendidos').dataset.route, 'bar');
});


// Carrega gráfico inicial
montarGrafico(document.getElementById('btnUsuarios').dataset.route, 'line');
</script>


</body>
</html>
