<div class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] border border-[#d5891b]/50 rounded-xl shadow p-8 max-w-7xl mx-auto text-white">
    <h3 class="text-[#e29b37] text-2xl mb-6 font-semibold">Lista de Produtos</h3>

    <!-- Lupa / Campo de pesquisa -->
    <div class="mb-4 relative max-w-sm">
        <input type="text" id="produto-search" placeholder="Pesquisar produtos..."
            class="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#d5891b] transition">
        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-[#0b282a] border border-[#14ba88] rounded text-[#14ba88]">
        {{ session('success') }}
    </div>
    @endif

    @if($produtos->isEmpty())
    <p class="text-gray-400">Nenhum produto cadastrado.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm" id="produtos-table">
            <thead class="bg-[#7f3a0e] text-white">
                <tr>
                    <th class="px-6 py-3">Nome</th>
                    <th class="px-6 py-3">Preço</th>
                    <th class="px-6 py-3">Categoria</th>
                    <th class="px-6 py-3">Tamanhos</th>
                    <th class="px-6 py-3">Fotos</th>
                    <th class="px-6 py-3">Estoque (Imagens)</th>
                    <th class="px-6 py-3">Ações</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-[#d5891b]/30">
                @foreach($produtos as $produto)
                @php
                    $tamanhos = is_array($produto->tamanhos_disponiveis)
                        ? $produto->tamanhos_disponiveis
                        : json_decode($produto->tamanhos_disponiveis ?? '[]', true);

                    $fotos = is_array($produto->fotos)
                        ? $produto->fotos
                        : json_decode($produto->fotos ?? '[]', true);

                    $estoqueImgs = is_array($produto->estoque_imagem)
                        ? $produto->estoque_imagem
                        : json_decode($produto->estoque_imagem ?? '[]', true);
                @endphp

                <tr class="hover:bg-[#0b282a]/70 transition">
                    <!-- Nome + Rótulos -->
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $produto->nome }}</div>

                        @if($produto->rotulos->isNotEmpty())
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($produto->rotulos as $rotulo)
                            <span class="bg-[#14ba88] text-black px-2 py-1 text-xs rounded">
                                {{ $rotulo->categoria ?? '-' }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                    </td>

                    <!-- Preço -->
                    <td class="px-6 py-4 text-[#e29b37] font-medium">
                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    </td>

                    <!-- Categoria -->
                    <td class="px-6 py-4">{{ ucfirst($produto->categoria) }}</td>

                    <!-- Tamanhos -->
                    <td class="px-6 py-4">
                        @if(!empty($produto->tamanhos_disponiveis))
                        <div class="flex flex-wrap gap-1">
                            @foreach($produto->tamanhos_disponiveis as $tamanho)
                            <span class="bg-[#d5891b] text-black px-2 py-1 text-xs rounded">{{ $tamanho }}</span>
                            @endforeach
                        </div>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>

                    <!-- Fotos -->
                    <td class="px-6 py-4">
                        @if(!empty($produto->fotos))
                        <div class="flex gap-2">
                            @foreach($produto->fotos as $foto)
                            <img src="{{ asset('storage/' . $foto) }}" class="w-10 h-10 rounded shadow border border-[#d5891b]/40" alt="Foto Produto">
                            @endforeach
                        </div>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>

                    <!-- Estoque (Imagens) -->
                    <td class="px-6 py-4">
                        @if(!empty($produto->estoque_imagem))
                        <div class="flex gap-2">
                            @foreach($produto->estoque_imagem as $img)
                            <img src="{{ asset('storage/' . $img) }}" class="w-10 h-10 rounded shadow border border-[#e29b37]/40" alt="Imagem Estoque">
                            @endforeach
                        </div>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>

                    <!-- Ações -->
                    <td class="px-6 py-4 flex flex-col gap-1">
                        <a href="#"
                            data-url="{{ route('fornecedores.produtos.edit', $produto->id_produtos) }}"
                            class="link-ajax text-[#e29b37] hover:underline text-sm">
                            Editar
                        </a>

                        <a href="#"
                            data-url="{{ route('fornecedores.produtos.rotulos.create', $produto->id_produtos) }}"
                            class="link-ajax text-[#14ba88] hover:underline text-sm">
                            Labels
                        </a>

                        <form action="{{ route('fornecedores.produtos.toggle', $produto->id_produtos) }}" method="POST" class="inline toggle-form">
                            @csrf
                            @method('PATCH')
                            <button type="button"
                                class="text-sm hover:underline {{ $produto->ativo ? 'text-red-500' : 'text-green-500' }}">
                                {{ $produto->ativo ? 'Desativar' : 'Ativar' }}
                            </button>
                        </form>

                        <button
                            class="btn-excluir-produto text-red-400 hover:underline text-sm text-left p-0 bg-transparent border-0 cursor-pointer"
                            data-id="{{ $produto->id_produtos }}">
                            Excluir
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<!-- Script para pesquisa -->
<script>
    document.getElementById('produto-search').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#produtos-table tbody tr');
        rows.forEach(row => {
            const nome = row.querySelector('td').textContent.toLowerCase();
            if (nome.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
