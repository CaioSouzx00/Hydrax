<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="/imagens/hydrax/lch.png" type="image/png" />
<title>{{ $produto->nome }} - Detalhes</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-gray-100 font-sans">
<!-- Navbar -->
  <header class="fixed top-0 left-0 w-full z-50 backdrop-blur-md bg-gradient-to-br from-[#211828]/90 via-[#0b282a]/90 to-[#17110d]/90ss border-b border-[#7f3a0e] shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">

      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="/imagens/hydrax/HYDRA’x.png" alt="Hydrax Logo" class="h-14" />
      </div>

      <!-- Menu principal -->
      <nav class="hidden md:flex items-center gap-6 text-sm">

<style>
@keyframes bounce-subtle {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-3px); }
}
.animate-bounce-subtle {
  animation: bounce-subtle 1s infinite;
}
</style>


      </nav>
    </div>
  </header>
<a href="javascript:history.back()"
   class="group fixed top-5 right-4 z-50 flex h-10 w-10 items-center rounded-full bg-[#14ba88] text-white overflow-hidden transition-all duration-300 ease-in-out hover:w-28 hover:bg-[#117c66]"
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



<div class="max-w-7xl mx-auto p-6 mt-20">

     <div class="grid grid-cols-1 md:grid-cols-2 gap-12 relative">
         
         <div>
             @php
                 $fotos = is_array($produto->fotos) ? $produto->fotos : json_decode($produto->fotos, true) ?? [];
                 $estoqueImagens = is_array($produto->estoque_imagem) ? $produto->estoque_imagem : json_decode($produto->estoque_imagem, true) ?? [];
                 $tamanhos = is_array($produto->tamanhos_disponiveis) ? $produto->tamanhos_disponiveis : json_decode($produto->tamanhos_disponiveis, true) ?? [];
             @endphp

             <img src="{{ asset('storage/' . ($fotos[0] ?? 'sem-imagem.png')) }}"
                  class="w-full h-[480px] object-cover rounded-md border border-[#d5891b]/50 shadow main-image cursor-pointer">
                 
             @if(count($fotos) > 1)
             <div class="flex gap-3 mt-4">
                 @foreach(array_slice($fotos, 1) as $foto)
                     <img src="{{ asset('storage/' . $foto) }}"
                          class="w-20 h-20 rounded-md border border-[#333] cursor-pointer hover:opacity-80"
                          onclick="document.querySelector('.main-image').src=this.src">
                 @endforeach
             </div>
             @endif

             @if($produto->fornecedor)
             <div class="flex items-center gap-3 mt-6">
                 <img src="{{ $produto->fornecedor->foto ? asset('storage/' . $produto->fornecedor->foto) : asset('storage/sem-logo.png') }}" 
                      alt="Logo {{ $produto->fornecedor->nome_empresa }}"
                      class="w-12 h-12 rounded-full object-cover border-2 border-[#d5891b]/50">
                 <div>
                     <h3 class="font-semibold text-lg text-[#e29b37]">{{ $produto->fornecedor->nome_empresa }}</h3>
                     <p class="text-sm text-gray-400">Produto vendido por esta empresa</p>
                 </div>
             </div>
             @endif
         </div>

         <div class="flex flex-col gap-6">
             <h1 class="text-4xl font-bold tracking-tight text-white">{{ $produto->nome }}</h1>
<div class="flex items-center gap-2">
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= floor($notaMedia))
            <span class="text-[#14ba88]">&#9733;</span>
        @elseif ($i - 0.5 <= $notaMedia)
            <span class="text-[#14ba88] opacity-50">&#9733;</span>
        @else
            <span class="text-gray-600">&#9733;</span>
        @endif
    @endfor
    <span class="text-gray-400 text-sm">({{ $totalAvaliadores }} avaliações)</span>
</div>
             <div>
                 <span class="text-3xl font-bold text-white block">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                 <span class="text-sm line-through text-gray-500">R$ {{ number_format($produto->preco * 1.2, 2, ',', '.') }}</span>
                 <span class="text-sm text-[#14ba88]">22% OFF</span>
             </div>

             <div class="mt-4 flex gap-2">
    @foreach($variantes as $variante)
        <img 
            src="{{ asset('storage/' . json_decode($variante->fotos)[0]) }}" 
            alt="{{ $variante->cor }}" 
            class="w-12 h-12 border rounded cursor-pointer hover:border-blue-500"
            onclick="trocarCor('{{ route('produtos.detalhes', $variante->id_produtos) }}')"
        >
    @endforeach
</div>

<script>
function trocarCor(url) {
    window.location.href = url;
}
</script>


             @php
                 $coresComPrincipal = array_merge([$fotos[0] ?? 'sem-imagem.png'], $estoqueImagens);
             @endphp
             @if(count($coresComPrincipal))
             <div>
                 <h3 class="font-semibold text-white">Imagens</h3>
                 <div class="flex gap-3">
                     @foreach($coresComPrincipal as $img)
                         <img src="{{ asset('storage/' . $img) }}"
                              class="w-16 h-16 rounded-md border border-[#333] cursor-pointer hover:opacity-80 transition"
                              onclick="document.querySelector('.main-image').src=this.src">
                     @endforeach
                 </div>
             </div>
             @endif

             @if(count($tamanhos))
             <div class="flex flex-wrap gap-2">
                 @foreach($tamanhos as $tamanho)
                     <button type="button" 
                             class="tamanho-btn-produto px-4 py-2 border border-gray-600 rounded-md hover:bg-[#14ba88]/20 transition"
                             data-tamanho="{{ $tamanho }}">
                         {{ $tamanho }}
                     </button>
                 @endforeach
             </div>
             @else
             <p class="text-gray-500">Nenhum tamanho disponível</p>
             @endif

 <div class="flex items-center gap-4">
     <form action="{{ route('carrinho.adicionar', $produto->id_produtos) }}" method="POST" id="form-carrinho-principal" class="flex-1">
         @csrf
         <input type="hidden" name="tamanho" id="tamanhoSelecionadoPrincipal">
<button type="submit" 
        class="relative w-full px-5 py-3 overflow-hidden font-medium text-gray-600 bg-gray-100 border border-[#14ba88] rounded-lg shadow-inner group text-lg">

    <!-- Top border -->
    <span class="absolute top-0 left-0 w-0 h-0 transition-all duration-200 border-t-2 border-[#14ba88] group-hover:w-full ease"></span>

    <!-- Bottom border -->
    <span class="absolute bottom-0 right-0 w-0 h-0 transition-all duration-200 border-b-2 border-[#14ba88] group-hover:w-full ease"></span>

    <!-- Top fill -->
    <span class="absolute top-0 left-0 w-full h-0 transition-all duration-300 delay-200 bg-[#14ba88]/20 group-hover:h-full ease"></span>

    <!-- Bottom fill -->
    <span class="absolute bottom-0 left-0 w-full h-0 transition-all duration-300 delay-200 bg-[#14ba88]/20 group-hover:h-full ease"></span>

    <!-- Overlay fade -->
    <span class="absolute inset-0 w-full h-full duration-300 delay-300 bg-[#14ba88] opacity-0 group-hover:opacity-100 rounded-lg"></span>

    <!-- Button text -->
    <span class="relative transition-colors duration-300 delay-200 group-hover:text-white ease">Adicionar ao carrinho</span>
</button>

         <p id="erroTamanhoPrincipal" class="text-red-500 mt-2 hidden">
             Por favor, selecione um tamanho antes.
         </p>
     </form>


<form action="{{ route('lista-desejos.store', $produto->id_produtos) }}" method="POST" class="absolute top-[360px] right-0.5 z-50">
    @csrf
    <button type="submit" class="wishlist-btn w-10 h-10 flex items-center justify-center 
                                   bg-black/20 border border-[#d5891b]/50 rounded-lg 
                                   hover:bg-black/30 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#d5891b]" 
             fill="{{ $isDesejado ? '#d5891b' : 'none' }}" 
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 
                      4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 
                      4.5 0 00-6.364 0z" />
        </svg>
    </button>
</form>


<!-- Aviso flutuante -->
<div id="wishlist-toast" 
     class="fixed top-24 right-5 bg-[#d5891b]/70 border border-white/60 text-white/80 px-3 py-1 rounded-md shadow-lg opacity-0 pointer-events-none transition-opacity duration-300 z-50">
</div>

<script>
document.querySelectorAll('.wishlist-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();
        const form = btn.closest('form');
        const heart = btn.querySelector('svg');
        const toast = document.getElementById('wishlist-toast');

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            if(data.success){
                // Atualiza o coração
                heart.setAttribute('fill', data.action === 'adicionado' ? '#d5891b' : 'none');

                // Mostra o toast
                toast.textContent = data.action === 'adicionado' ? 'Adicionado à lista de desejos!' : 'Removido da lista de desejos!';
                toast.classList.remove('opacity-0', 'pointer-events-none');
                toast.classList.add('opacity-100');

                // Esconde o toast após 5 segundos
                setTimeout(() => {
                    toast.classList.remove('opacity-100');
                    toast.classList.add('opacity-0', 'pointer-events-none');
                }, 3000);
            }
        } catch (err) {
            console.error('Erro ao salvar na lista de desejos', err);
            alert('Não foi possível adicionar/remover da lista de desejos.');
        }
    });
});
</script>


 </div>

                 <p id="erroTamanhoPrincipal" class="text-red-500 mt-2 hidden">
                     Por favor, selecione um tamanho antes.
                 </p>
             </form>
         </div>
     </div>

 <hr class="border-t border-[#d5891b]/20 my-12">


 <div class="mt-12 space-y-4">

     <div class="flex flex-col gap-2">

<button id="btn-descricao"
        class="w-full flex items-center justify-between text-white font-bold py-4 transition"
        data-target="descricao">
    <span class="text-left">Descrição</span>
    <svg id="icon-descricao" class="w-5 h-5 transform transition-transform duration-300"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 9l-7 7-7-7"/>
    </svg>
</button>

<script>
    const btnDesc = document.getElementById("btn-descricao");
    const iconDesc = document.getElementById("icon-descricao");

    btnDesc.addEventListener("click", () => {
        iconDesc.classList.toggle("rotate-180");
    });
</script>

<div id="descricao" class="hidden w-full p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <!-- Texto -->
        <div>
            <h2 class="text-xl font-bold text-[#D5891B]/90 border-b border-[#D5891B]/30 pb-1 mb-3">
                {{ $produto->nome }}
            </h2>
            <p class="text-gray-300 text-base leading-relaxed">
                {{ $produto->descricao ?? 'Sem descrição disponível.' }}
            </p>
        </div>

            <!-- Imagem com zoom seguindo o mouse -->
            <div class="flex justify-center">
                <div class="relative overflow-hidden rounded-lg border border-[#D5891B] shadow-lg w-full max-w-sm cursor-zoom-in"> 
                    <img id="zoomimg"
                         src="{{ asset('storage/' . ($fotos[0] ?? 'sem-imagem.png')) }}"
                         alt="{{ $produto->nome }}"
                         class="w-full h-auto object-contain transition-transform duration-300 ease-out">
                </div>
            </div>
    </div>
</div>

<script>
    const zoomImg = document.getElementById("zoomimg");

    zoomImg.addEventListener("mousemove", (e) => {
        const rect = zoomImg.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;

        zoomImg.style.transformOrigin = `${x}% ${y}%`;
        zoomImg.style.transform = "scale(2)";
    });

    zoomImg.addEventListener("mouseleave", () => {
        zoomImg.style.transformOrigin = "center center";
        zoomImg.style.transform = "scale(1)";
    });
</script>


<hr class="border-t border-[#d5891b]/20 my-12">

<button id="btn-avaliacoes"
        class="w-full flex items-center justify-between text-white font-bold py-4 rounded-lg transition"
        data-target="avaliacoes">
    <span class="text-left">Avaliações({{ $totalAvaliadores }})</span>
<h3 class="text-right pl-[1000px]">★ ★ ★ ★ ★</h3>
    <svg id="icon-avaliacoes" class="w-5 h-5 transform transition-transform duration-300"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 9l-7 7-7-7"/>
    </svg>
    
</button>

<script>
    const btn = document.getElementById("btn-avaliacoes");
    const icon = document.getElementById("icon-avaliacoes");

    btn.addEventListener("click", () => {
        icon.classList.toggle("rotate-180");
    });
</script>

         <div id="avaliacoes" class="hidden w-full p-6 rounded-lg max-full overflow-y-auto custom-scroll">
    @if($totalAvaliadores > 0)
        <!-- Resumo geral -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="text-white text-3xl font-bold md:mb-0"></div>
            <div class="flex items-center space-x-2 text-xl md:text-2xl">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($notaMedia))
                        <span class="text-[#14ba88]">&#9733;</span>
                    @elseif ($i - 0.5 <= $notaMedia)
                        <span class="text-[#14ba88] opacity-50">&#9733;</span>
                    @else
                        <span class="text-gray-600">&#9733;</span>
                    @endif
                @endfor
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Nota média -->
            <div class="flex items-center gap-4 mb-12">
                <div class="text-6xl font-extrabold text-[#14ba88]">{{ number_format($notaMedia, 1) }}</div>
                <div class="flex flex-col">
                    <div class="flex text-2xl mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($notaMedia))
                                <span class="text-[#14ba88]">&#9733;</span>
                            @else
                                <span class="text-gray-600">&#9733;</span>
                            @endif
                        @endfor
                    </div>
                    <div class="text-sm text-gray-400">avaliações ({{ $totalAvaliadores }})</div>
                </div>
            </div>

            <!-- Distribuições -->
            <div class="space-y-4">
                @foreach(['Conforto' => $confortoDist, 'Qualidade' => $qualidadeDist, 'Tamanho' => $tamanhoDist, 'Largura' => $larguraDist] as $key => $value)
                    <div>
                        <span class="text-gray-300">{{ $key }}</span>
                        <div class="relative w-full h-2 bg-gray-700 rounded-full mt-1">
                            <div class="h-full bg-[#14ba88] rounded-full" style="width: {{ min(100, ($value / 5) * 100) }}%;"></div>
                        </div>
                        <div class="flex justify-between text-xs mt-1 text-gray-400">
                            @if($key == 'Conforto' || $key == 'Qualidade')
                                <span>Muito Ruim</span><span>Excelente</span>
                            @elseif($key == 'Tamanho' || $key == 'Largura')
                                <span>Muito Pequeno</span><span>Perfeito</span><span>Grande</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <hr class="border-t border-[#14ba88]/20 my-8">

        <!-- Filtros e ordenação -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <div class="flex items-center space-x-2">
                <span class="text-gray-400">Filtrar por avaliações</span>
                <div class="flex space-x-1">
                    @for($i = 5; $i >= 1; $i--)
                        <button class="px-3 py-1 border border-gray-600 rounded-md hover:bg-gray-700 transition" data-nota="{{ $i }}">{{ $i }} ★</button>
                    @endfor
                    <button class="px-3 py-1 border border-gray-600 rounded-md hover:bg-gray-700 transition" data-nota="all">Todos</button>
                </div>
            </div>
            <div>
                <span class="text-gray-400">Ordenar por:</span>
                <select class="bg-[#111] border border-gray-600 rounded-md py-1 px-2 text-white">
                    <option value="mais-recente">Mais recente</option>
                    <option value="maior-nota">Maior nota</option>
                    <option value="menor-nota">Menor nota</option>
                </select>
            </div>
        </div>

        <!-- Lista de avaliações -->
        <div class="space-y-4 avaliacoes-container">
            @foreach($avaliacoes->sortByDesc('created_at') as $avaliacao)
                <div class="p-4 rounded-lg avaliacao-item bg-black/10 rounded"
                     data-nota="{{ $avaliacao->nota }}"
                     data-timestamp="{{ $avaliacao->created_at->timestamp }}">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-[#14ba88]">{{ $avaliacao->usuario->nome_completo }}</span>
                        <span class="text-gray-500 text-sm">{{ $avaliacao->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex text-xl mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $avaliacao->nota)
                                <span class="text-[#14ba88]">&#9733;</span>
                            @else
                                <span class="text-gray-600">&#9733;</span>
                            @endif
                        @endfor
                    </div>
                    @if($avaliacao->comentario)
                        <p class="text-gray-300 mt-2">{{ $avaliacao->comentario }}</p>
                    @endif
                </div>
            @endforeach
        </div>

    @else
        <div class="text-center text-gray-400">
            <p class="text-lg">Nenhuma avaliação para este produto ainda.</p>
            <a href="{{ route('avaliacoes.create', $produto->id_produtos) }}" class="mt-4 inline-block px-4 py-2 rounded-lg bg-[#14ba88] text-black font-semibold hover:bg-[#117c66] transition">
                Seja o primeiro a avaliar!
            </a>
        </div>
    @endif
</div>
<hr class="border-t border-[#d5891b]/20 my-12">
<style>
/* Barra de rolagem dourado escuro e transparente */
.custom-scroll::-webkit-scrollbar {
    width: 10px;
}

.custom-scroll::-webkit-scrollbar-track {
    background: #0b282a;
    border-radius: 10px;
}

.custom-scroll::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, rgba(197,133,41,0.7), rgba(226,155,55,0.7), rgba(127,58,14,0.7));
    border-radius: 10px;
    border: 2px solid #0b282a;
}

.custom-scroll::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, rgba(180,112,20,0.8), rgba(197,133,41,0.8), rgba(127,58,14,0.8));
}

/* Firefox */
.custom-scroll {
    scrollbar-width: thin;
    scrollbar-color: rgba(197,133,41,0.7) #0b282a;
}
</style>


     </div>
 </div>

 <script>
     const botoes = document.querySelectorAll('[data-target]');
     botoes.forEach(btn => {
         btn.addEventListener('click', () => {
             const alvo = document.getElementById(btn.dataset.target);

             // Fecha todos os conteúdos
             document.querySelectorAll('#descricao, #avaliacoes').forEach(div => {
                 if(div !== alvo) div.classList.add('hidden');
             });

             // Alterna o conteúdo clicado
             alvo.classList.toggle('hidden');

             // Scroll suave para mostrar o conteúdo aberto
             if(!alvo.classList.contains('hidden')){
                 alvo.scrollIntoView({behavior: 'smooth', block: 'start'});
             }
         });
     });
 </script>

 <script>
    const avaliacoesContainer = document.querySelector('.avaliacoes-container');
    const botoesFiltro = document.querySelectorAll('[data-nota]');
    const seletorOrdenacao = document.querySelector('select');
    let avaliacoes = Array.from(document.querySelectorAll('.avaliacao-item'));

    function renderizarAvaliacoes(avaliacoesArray) {
        avaliacoesContainer.innerHTML = '';
        avaliacoesArray.forEach(avaliacao => {
            avaliacoesContainer.appendChild(avaliacao);
        });
    }

    function ordenarAvaliacoes(avaliacoesArray) {
        const ordenacao = seletorOrdenacao.value;
        if (ordenacao === 'mais-recente') {
            return avaliacoesArray.sort((a, b) => b.dataset.timestamp - a.dataset.timestamp);
        } else if (ordenacao === 'maior-nota') {
            return avaliacoesArray.sort((a, b) => b.dataset.nota - a.dataset.nota);
        } else if (ordenacao === 'menor-nota') {
            return avaliacoesArray.sort((a, b) => a.dataset.nota - b.dataset.nota);
        }
        return avaliacoesArray;
    }

    function aplicarFiltrosEOrdenacao() {
        const notaAtiva = document.querySelector('.bg-gray-600.text-white[data-nota]');
        const notaSelecionada = notaAtiva ? notaAtiva.dataset.nota : 'all';

        let avaliacoesFiltradas = avaliacoes.filter(avaliacao => {
            const nota = avaliacao.dataset.nota;
            return notaSelecionada === 'all' || Number(nota) === Number(notaSelecionada);
        });

        const avaliacoesOrdenadas = ordenarAvaliacoes(avaliacoesFiltradas);
        renderizarAvaliacoes(avaliacoesOrdenadas);
    }

    botoesFiltro.forEach(botao => {
        botao.addEventListener('click', () => {
            botoesFiltro.forEach(b => b.classList.remove('bg-gray-600', 'text-white'));
            botao.classList.add('bg-gray-600', 'text-white');
            aplicarFiltrosEOrdenacao();
        });
    });

    seletorOrdenacao.addEventListener('change', () => {
        aplicarFiltrosEOrdenacao();
    });

    // inicia com tudo renderizado
    window.addEventListener('load', () => {
        aplicarFiltrosEOrdenacao();
    });
</script>


@if(isset($produtos) && $produtos->isNotEmpty())
<div class="mt-16">
    <div class="mb-8">
    <h2 class="text-2xl font-bold border-b border-[#d5891b]/80 w-fit text-white">Você também pode gostar</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($produtos as $prod)
            @php
                $fotosRec = is_array($prod->fotos) ? $prod->fotos : json_decode($prod->fotos, true) ?? [];
                $estoqueRec = is_array($prod->estoque_imagem) ? $prod->estoque_imagem : json_decode($prod->estoque_imagem, true) ?? [];
                $tamanhosRec = is_array($prod->tamanhos_disponiveis) ? $prod->tamanhos_disponiveis : json_decode($prod->tamanhos_disponiveis, true) ?? [];

                // Inclui a imagem principal no array de miniaturas
                $miniaturas = $estoqueRec;
                if($fotosRec[0] ?? false) {
                    array_unshift($miniaturas, $fotosRec[0]);
                }
            @endphp

            <div class="bg-[#111]/50 rounded-xl border border-[#222]/50 hover:border-[#d5891b]/20 shadow-lg hover:shadow-2xl p-4 flex flex-col relative transition-all duration-300">
                <!-- Imagem do produto -->
                <a href="{{ route('produtos.detalhes', $prod->id_produtos) }}" class="block mb-3 rounded-md overflow-hidden">
                    <img src="{{ asset('storage/' . ($fotosRec[0] ?? 'sem-imagem.png')) }}" 
                         class="w-full h-52 object-cover rounded-lg mb-3 main-img">
                    <h3 class="font-semibold text-lg text-white truncate">{{ $prod->nome }}</h3>
                </a>

<!-- Miniaturas (incluindo imagem principal) -->
@if(count($miniaturas))
<div class="flex flex-wrap gap-2 mb-3">
    @foreach(collect($miniaturas)->take(5) as $img)
        <img src="{{ asset('storage/' . $img) }}" 
             class="w-10 h-10 rounded-lg border border-[#333] cursor-pointer hover:opacity-80 transition"
             onclick="this.closest('div.flex.flex-col').querySelector('.main-img').src=this.src">
    @endforeach
</div>
@endif


                <!-- Preço -->
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-white font-bold text-lg">R$ {{ number_format($prod->preco,2,',','.') }}</span>
                    <span class="line-through text-gray-500 text-sm">R$ {{ number_format($prod->preco*1.2,2,',','.') }}</span>
                </div>

                <!-- Tamanhos -->
                @if(count($tamanhosRec))
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach($tamanhosRec as $tam)
                        <button type="button" class="tamanho-btn-rec px-3 py-1 border border-gray-600 rounded-md text-sm hover:bg-[#14ba88]/20 transition" data-tamanho="{{ $tam }}">
                            {{ $tam }}
                        </button>
                    @endforeach
                </div>
                @endif

<form action="{{ route('carrinho.adicionar', $prod->id_produtos) }}" method="POST" class="form-carrinho-rec mt-auto">
    @csrf
    <input type="hidden" name="tamanho" class="tamanhoSelecionado-rec">
    
    <button type="submit" 
            class="relative w-full px-4 py-2 overflow-hidden font-medium text-gray-600 bg-gray-100 border border-[#14ba88] rounded-lg shadow-inner group text-base">

        <!-- Top border -->
        <span class="absolute top-0 left-0 w-0 h-0 transition-all duration-200 border-t-2 border-[#14ba88] group-hover:w-full ease"></span>

        <!-- Bottom border -->
        <span class="absolute bottom-0 right-0 w-0 h-0 transition-all duration-200 border-b-2 border-[#14ba88] group-hover:w-full ease"></span>

        <!-- Top fill -->
        <span class="absolute top-0 left-0 w-full h-0 transition-all duration-300 delay-200 bg-[#14ba88]/20 group-hover:h-full ease"></span>

        <!-- Bottom fill -->
        <span class="absolute bottom-0 left-0 w-full h-0 transition-all duration-300 delay-200 bg-[#14ba88]/20 group-hover:h-full ease"></span>

        <!-- Overlay fade -->
        <span class="absolute inset-0 w-full h-full duration-300 delay-300 bg-[#14ba88] opacity-0 group-hover:opacity-100 rounded-lg"></span>

        <!-- Button text -->
        <span class="relative transition-colors duration-300 delay-200 group-hover:text-white ease">Adicionar</span>
    </button>
    
    <p class="text-red-500 mt-2 hidden erroTamanho-rec">Selecione um tamanho.</p>
</form>

            </div>
        @endforeach
    </div>
</div>
@endif


 </div>

 <script>
     // Principal
     const tamanhoBtnsPrincipal = document.querySelectorAll('.tamanho-btn-produto');
     const tamanhoInputPrincipal = document.getElementById('tamanhoSelecionadoPrincipal');
     const erroTamanhoPrincipal = document.getElementById('erroTamanhoPrincipal');

     tamanhoBtnsPrincipal.forEach(btn=>{
         btn.addEventListener('click', ()=>{
             tamanhoBtnsPrincipal.forEach(b=>b.classList.remove('bg-[#14ba88]','border-white'));
             btn.classList.add('bg-[#14ba88]','border-white');
             tamanhoInputPrincipal.value = btn.dataset.tamanho;
             erroTamanhoPrincipal.classList.add('hidden');
         });
     });

     document.getElementById('form-carrinho-principal').addEventListener('submit', function(e){
         if(!tamanhoInputPrincipal.value){
             e.preventDefault();
             erroTamanhoPrincipal.classList.remove('hidden');
         }
     });

     // Recomendados
     document.querySelectorAll('.form-carrinho-rec').forEach(form=>{
         const card = form.closest('div.flex.flex-col');
         const tamanhoBtns = card.querySelectorAll('.tamanho-btn-rec');
         const tamanhoInput = card.querySelector('.tamanhoSelecionado-rec');
         const erro = card.querySelector('.erroTamanho-rec');

         tamanhoBtns.forEach(btn=>{
             btn.addEventListener('click', ()=>{
                 tamanhoBtns.forEach(b=>b.classList.remove('bg-[#14ba88]','border-white'));
                 btn.classList.add('bg-[#14ba88]','border-white');
                 tamanhoInput.value = btn.dataset.tamanho;
                 erro.classList.add('hidden');
             });
         });

         form.addEventListener('submit', function(e){
             if(!tamanhoInput.value && tamanhoBtns.length>0){
                 e.preventDefault();
                 erro.classList.remove('hidden');
             }
         });
     });


 </script>

<!-- Modal Fullscreen -->
<div id="imagemModal" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center backdrop-blur-md transition-opacity duration-300">
    <div class="relative w-full h-full flex items-center justify-center overflow-hidden">

        <!-- Imagem principal com zoom interno e efeito glow -->
        <div class="relative overflow-hidden rounded-2xl border-2 border-[#D5891B] shadow-2xl cursor-zoom-in max-w-[100%] max-h-[100%] bg-[#111]/50">
            <img id="modalMainImg" 
                 src="{{ asset('storage/' . ($fotos[0] ?? 'sem-imagem.png')) }}" 
                 class="w-[700px] h-auto object-contain transition-transform duration-300 ease-out transform hover:scale-105">
            <!-- Glow animado -->
            <div class="absolute inset-0 pointer-events-none rounded-2xl shadow-[0_0_60px_#D5891B] animate-pulse"></div>
        </div>

        <!-- Botão fechar com efeito hover -->
        <button id="closeModal" 
                class="absolute top-4 right-4 text-white text-4xl font-bold z-50 hover:text-[#D5891B] transition-all duration-200">&times;</button>

<!-- Miniaturas laterais -->
@if(count($estoqueImagens) || !empty($fotos[0]))
<div class="absolute left-4 top-1/2 transform -translate-y-1/2 flex flex-col gap-3 max-h-[80%] overflow-y-auto p-2 rounded-lg bg-[#111]/50 border border-[#D5891B] shadow-lg">
    
    <!-- Adiciona a imagem principal também -->
    <img src="{{ asset('storage/' . ($fotos[0] ?? 'sem-imagem.png')) }}" 
         class="w-20 h-20 object-cover rounded-lg cursor-pointer hover:opacity-70 hover:border-[#D5891B] transition-all duration-200 modal-thumb">

    @foreach($estoqueImagens as $img)
        <img src="{{ asset('storage/' . $img) }}" 
             class="w-20 h-20 object-cover rounded-lg cursor-pointer hover:opacity-70 hover:border-[#D5891B] transition-all duration-200 modal-thumb">
    @endforeach
</div>
@endif

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById('imagemModal');
    const mainImg = document.getElementById('modalMainImg');
    const thumbs = document.querySelectorAll('.modal-thumb');
    const closeBtn = document.getElementById('closeModal');

    // Abrir modal
    const trigger = document.querySelector('.main-image');
    if (trigger) {
        trigger.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
    }

    // Fechar modal
    closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        mainImg.style.transform = 'scale(1)';
        mainImg.style.transformOrigin = 'center center';
    });

    // Trocar imagem principal
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', () => {
            mainImg.src = thumb.src;
            mainImg.style.transform = 'scale(1)';
            mainImg.style.transformOrigin = 'center center';
        });
    });

    // Zoom tipo lupa
    mainImg.addEventListener('mousemove', e => {
        const rect = mainImg.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;

        mainImg.style.transformOrigin = `${x}% ${y}%`;
        mainImg.style.transform = 'scale(2)';
    });

    mainImg.addEventListener('mouseleave', () => {
        mainImg.style.transformOrigin = 'center center';
        mainImg.style.transform = 'scale(1)';
    });
});
</script>

<style>
/* Miniaturas laterais com glow no scroll */
#imagemModal .flex-col::-webkit-scrollbar {
    width: 6px;
}
#imagemModal .flex-col::-webkit-scrollbar-thumb {
    background: #D5891B;
    border-radius: 3px;
}
#imagemModal .flex-col::-webkit-scrollbar-track {
    background: transparent;
}

/* Glow animado no modal */
@keyframes pulse {
    0%, 100% { box-shadow: 0 0 30px #D5891B; }
    50% { box-shadow: 0 0 60px #D5891B; }
}
.animate-pulse {
    animation: pulse 2s infinite;
}
</style>


@include('usuarios.partials.footer')
 </body>
 </html>