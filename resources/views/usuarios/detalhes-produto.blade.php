<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $produto->nome }} - Detalhes</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] text-gray-100 font-sans">

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


<div class="max-w-7xl mx-auto p-6 mt-20">

     <div class="grid grid-cols-1 md:grid-cols-2 gap-12 relative">
         
         <div>
             @php
                 $fotos = is_array($produto->fotos) ? $produto->fotos : json_decode($produto->fotos, true) ?? [];
                 $estoqueImagens = is_array($produto->estoque_imagem) ? $produto->estoque_imagem : json_decode($produto->estoque_imagem, true) ?? [];
                 $tamanhos = is_array($produto->tamanhos_disponiveis) ? $produto->tamanhos_disponiveis : json_decode($produto->tamanhos_disponiveis, true) ?? [];
             @endphp

             <img src="{{ asset('storage/' . ($fotos[0] ?? 'sem-imagem.png')) }}"
                  class="w-full h-[480px] object-cover rounded-md border border-[#d5891b]/50 shadow main-image">
                 
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

             <p class="text-gray-300 leading-relaxed">{{ $produto->categoria }}</p>

             @php
                 $coresComPrincipal = array_merge([$fotos[0] ?? 'sem-imagem.png'], $estoqueImagens);
             @endphp
             @if(count($coresComPrincipal))
             <div>
                 <h3 class="font-semibold mb-1 text-white">Imagens</h3>
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
             <div class="flex flex-wrap gap-2 mt-2">
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
                 class="w-full px-5 py-3 overflow-hidden font-bold text-gray-600 bg-white border border-[#14ba88] rounded-lg shadow-inner group text-lg">
             <span class="relative transition-colors duration-300 delay-200 group-hover:text-white ease">
                 Adicionar ao carrinho
             </span>
         </button>
         <p id="erroTamanhoPrincipal" class="text-red-500 mt-2 hidden">
             Por favor, selecione um tamanho antes.
         </p>
     </form>

     <form action="{{ route('lista-desejos.store', $produto->id_produtos) }}" method="POST">
         @csrf
         <button type="submit" 
                 class="w-14 h-14 flex items-center justify-center bg-[#111] border border-[#d5891b]/50 rounded-lg hover:bg-[#222] transition"
                 title="Adicionar à lista de desejos">
             <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#d5891b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 
                           4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 
                           4.5 0 00-6.364 0z" />
             </svg>
         </button>
     </form>
 </div>

                 <p id="erroTamanhoPrincipal" class="text-red-500 mt-2 hidden">
                     Por favor, selecione um tamanho antes.
                 </p>
             </form>
         </div>
     </div>

 <hr class="border-t border-[#d5891b]/20 my-12">


 <div class="mt-12 max-w-6xl mx-auto px-4 space-y-4">

     <div class="flex flex-col gap-2">

         <button class="w-full bg-[#111] border border-[#14ba88] text-white font-bold py-4 rounded-lg hover:bg-[#14ba88]/20 transition"
        data-target="descricao">
    Descrição
</button>
<div id="descricao" class="hidden w-full bg-[#111] border border-[#14ba88]/20 p-6 rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <!-- Texto -->
        <p class="text-gray-300 text-lg leading-relaxed">
            {{ $produto->descricao ?? 'Sem descrição disponível.' }}
        </p>

        <!-- Imagem -->
        <img src="{{ asset('storage/' . ($fotos[0] ?? 'sem-imagem.png')) }}"
             alt="{{ $produto->nome }}"
             class="w-full h-auto object-contain rounded-lg">
    </div>
</div>


         <button class="w-full bg-[#111] border border-[#14ba88] text-white font-bold py-4 rounded-lg hover:bg-[#14ba88]/20 transition"
                 data-target="avaliacoes">
             Avaliações ({{ $totalAvaliadores }})
         </button>
         <div id="avaliacoes" class="hidden w-full bg-[#0b282a] border border-[#14ba88]/30 p-6 rounded-lg max-h-[70vh] overflow-y-auto">
             
             @if($totalAvaliadores > 0)
                 <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                     <div class="text-white text-3xl font-bold mb-4 md:mb-0">{{ $totalAvaliadores }} Avaliações</div>
                     <div class="flex items-center space-x-2 text-xl md:text-2xl">
                         @for($i = 1; $i <= 5; $i++)
                             @if($i <= floor($notaMedia))
                                 <span class="text-[#14ba88]">&#9733;</span>
                             @elseif($i - 0.5 <= $notaMedia)
                                 <span class="text-[#14ba88] opacity-50">&#9733;</span>
                             @else
                                 <span class="text-gray-600">&#9733;</span>
                             @endif
                         @endfor
                     </div>
                 </div>
                 
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                     <div class="flex items-center gap-4">
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
                             <div class="text-sm text-gray-400">{{ $totalAvaliadores }} avaliações</div>
                         </div>
                     </div>

                     <div class="space-y-4">
                         <div>
                             <span class="text-gray-300">Conforto</span>
                             <div class="relative w-full h-2 bg-gray-700 rounded-full mt-1">
                                 <div class="h-full bg-[#14ba88] rounded-full" style="width: {{ min(100, ($confortoDist / 5) * 100) }}%;"></div>
                             </div>
                             <div class="flex justify-between text-xs mt-1 text-gray-400">
                                 <span>Muito Ruim</span>
                                 <span>Excelente</span>
                             </div>
                         </div>
                         
                         <div>
                             <span class="text-gray-300">Qualidade</span>
                             <div class="relative w-full h-2 bg-gray-700 rounded-full mt-1">
                                 <div class="h-full bg-[#14ba88] rounded-full" style="width: {{ min(100, ($qualidadeDist / 5) * 100) }}%;"></div>
                             </div>
                             <div class="flex justify-between text-xs mt-1 text-gray-400">
                                 <span>Muito Ruim</span>
                                 <span>Excelente</span>
                             </div>
                         </div>
                         
                         <div>
                             <span class="text-gray-300">Tamanho</span>
                             <div class="relative w-full h-2 bg-gray-700 rounded-full mt-1">
                                 <div class="h-full bg-[#14ba88] rounded-full" style="width: {{ min(100, ($tamanhoDist / 5) * 100) }}%;"></div>
                             </div>
                             <div class="flex justify-between text-xs mt-1 text-gray-400">
                                 <span>Muito Pequeno</span>
                                 <span>Perfeito</span>
                                 <span>Muito Grande</span>
                             </div>
                         </div>
                         
                         <div>
                             <span class="text-gray-300">Largura</span>
                             <div class="relative w-full h-2 bg-gray-700 rounded-full mt-1">
                                 <div class="h-full bg-[#14ba88] rounded-full" style="width: {{ min(100, ($larguraDist / 5) * 100) }}%;"></div>
                             </div>
                             <div class="flex justify-between text-xs mt-1 text-gray-400">
                                 <span>Muito Pequeno</span>
                                 <span>Perfeito</span>
                                 <span>Muito Largo</span>
                             </div>
                         </div>
                     </div>
                 </div>

                 <hr class="border-t border-[#14ba88]/20 my-8">

                 <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                     <div class="flex items-center space-x-2">
                         <span class="text-gray-400">Filtrar por avaliações</span>
                         <div class="flex space-x-1">
                         <button class="px-3 py-1 border border-gray-600 rounded-md hover:bg-gray-700 transition" data-nota="5">5 ★</button>
                         <button class="px-3 py-1 border border-gray-600 rounded-md hover:bg-gray-700 transition" data-nota="4">4 ★</button>
                         <button class="px-3 py-1 border border-gray-600 rounded-md hover:bg-gray-700 transition" data-nota="3">3 ★</button>
                         <button class="px-3 py-1 border border-gray-600 rounded-md hover:bg-gray-700 transition" data-nota="2">2 ★</button>
                         <button class="px-3 py-1 border border-gray-600 rounded-md hover:bg-gray-700 transition" data-nota="1">1 ★</button>
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
             

                <div class="space-y-4 max-h-[70vh] overflow-y-auto pr-2 avaliacoes-container">
                 @foreach($avaliacoes->sortByDesc('created_at') as $avaliacao)
                     {{-- ADICIONE A CLASSE ABAIXO --}}
                     <div class="bg-[#111] border border-[#14ba88]/20 p-4 rounded-lg avaliacao-item"
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
                         @if($avaliacao->conforto || $avaliacao->qualidade || $avaliacao->tamanho || $avaliacao->largura)
                             <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-400">
                                 @if($avaliacao->conforto)
                                     <span>**Conforto:** {{ ['Muito Ruim', 'Ruim', 'Médio', 'Bom', 'Excelente'][$avaliacao->conforto-1] }}</span>
                                 @endif
                                 @if($avaliacao->qualidade)
                                     <span>**Qualidade:** {{ ['Muito Ruim', 'Ruim', 'Médio', 'Bom', 'Excelente'][$avaliacao->qualidade-1] }}</span>
                                 @endif
                                 @if($avaliacao->tamanho)
                                     <span>**Tamanho:** {{ ['Muito Pequeno', 'Pequeno', 'Perfeito', 'Grande', 'Muito Grande'][$avaliacao->tamanho-1] }}</span>
                                 @endif
                                 @if($avaliacao->largura)
                                     <span>**Largura:** {{ ['Muito Pequeno', 'Pequeno', 'Perfeito', 'Largo', 'Muito Largo'][$avaliacao->largura-1] }}</span>
                                 @endif
                             </div>
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
     <h2 class="text-2xl font-bold mb-8 text-white">Você também pode gostar</h2>
     <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
         @foreach($produtos as $prod)
             @php
                 $fotosRec = is_array($prod->fotos) ? $prod->fotos : json_decode($prod->fotos, true) ?? [];
                 $estoqueRec = is_array($prod->estoque_imagem) ? $prod->estoque_imagem : json_decode($prod->estoque_imagem, true) ?? [];
                 $tamanhosRec = is_array($prod->tamanhos_disponiveis) ? $prod->tamanhos_disponiveis : json_decode($prod->tamanhos_disponiveis, true) ?? [];
             @endphp

             <div class="bg-[#1a1a1a]/50 rounded-md border border-[#222] hover:border-[#D5891B]/20 shadow p-4 flex flex-col relative">
                 <form action="{{ route('lista-desejos.store', $prod->id_produtos) }}" method="POST" class="absolute top-2 right-2 z-50">
                     @csrf
                     <button type="submit" class="w-10 h-10 flex items-center justify-center bg-[#111] border border-[#d5891b]/50 rounded-lg hover:bg-[#222] transition">
                         <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#d5891b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 
                                         4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 
                                         4.5 0 00-6.364 0z" />
                         </svg>
                     </button>
                 </form>

                 <a href="{{ route('produtos.detalhes', $prod->id_produtos) }}" class="block mb-3">
                     <img src="{{ asset('storage/' . ($fotosRec[0] ?? 'sem-imagem.png')) }}" class="w-full h-52 object-cover rounded-md mb-3">
                     <h3 class="font-semibold text-lg text-white">{{ $prod->nome }}</h3>
                 </a>

                 @if(count($estoqueRec))
                 <div class="flex gap-2 mb-3">
                     @foreach($estoqueRec as $img)
                         <img src="{{ asset('storage/' . $img) }}" 
                               class="w-10 h-10 rounded border border-[#333] cursor-pointer hover:opacity-80"
                               onclick="this.closest('div.flex.flex-col').querySelector('img').src=this.src">
                     @endforeach
                 </div>
                 @endif

                 <div class="flex items-center gap-2 mb-2">
                     <span class="text-white font-bold">R$ {{ number_format($prod->preco,2,',','.') }}</span>
                     <span class="line-through text-gray-500 text-sm">R$ {{ number_format($prod->preco*1.2,2,',','.') }}</span>
                 </div>

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
                     <button type="submit" class="w-full bg-[#14ba88] text-white font-bold py-2 rounded-md hover:bg-[#117c66] transition">
                         Adicionar
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

 </body>
 </html>