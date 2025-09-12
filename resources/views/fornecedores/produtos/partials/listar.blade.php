<div class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] border border-[#d5891b]/50 rounded-xl shadow p-8 max-w-7xl mx-auto text-white">
    <h3 class="text-[#e29b37] text-2xl mb-6 font-semibold">Lista de Produtos</h3>

    @if(session('success'))
        <div class="mb-4 p-4 bg-[#0b282a] border border-[#14ba88] rounded text-[#14ba88]">
            {{ session('success') }}
        </div>
    @endif

    @if($produtos->isEmpty())
        <p class="text-gray-400">Nenhum produto cadastrado.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
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
                            <td class="px-6 py-4">{{ $produto->nome }}</td>
                            <td class="px-6 py-4 text-[#e29b37] font-medium">
                                R$ {{ number_format($produto->preco, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">{{ ucfirst($produto->categoria) }}</td>

                            <!-- Tamanhos -->
                            <td class="px-6 py-4">
                                @if(!empty($tamanhos))
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($tamanhos as $tamanho)
                                            <span class="bg-[#d5891b] text-black px-2 py-1 text-xs rounded">{{ $tamanho }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Fotos -->
                            <td class="px-6 py-4">
                                @if(!empty($fotos))
                                    <div class="flex gap-2">
                                        @foreach($fotos as $foto)
                                            <img src="{{ asset('storage/' . $foto) }}" class="w-10 h-10 rounded shadow border border-[#d5891b]/40" alt="Foto do produto {{ $produto->nome }}">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Estoque (imagens) -->
                            <td class="px-6 py-4">
                                @if(!empty($estoqueImgs))
                                    <div class="flex gap-2">
                                        @foreach($estoqueImgs as $img)
                                            <img src="{{ asset('storage/' . $img) }}" class="w-10 h-10 rounded shadow border border-[#e29b37]/40" alt="Estoque do produto {{ $produto->nome }}">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Ações -->
                            <td class="px-6 py-4 flex flex-col gap-1">
                                <!-- Editar -->
                                <a href="#"
                                   data-url="{{ route('fornecedores.produtos.edit', $produto->id_produtos) }}"
                                   class="link-ajax text-[#e29b37] hover:underline text-sm">
                                    Editar




                                <!-- Excluir -->
                                <form action="{{ route('fornecedores.produtos.destroy', $produto->id_produtos) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                <button
                                  class="btn-excluir-produto text-red-400 hover:underline text-sm text-left p-0 bg-transparent border-0 cursor-pointer"
                                  data-id="{{ $produto->id_produtos }}"
                                >
                                Excluir
                                </button>
                                                            <!-- Ativar / Desativar -->
                            <form action="{{ route('fornecedores.produtos.toggle', $produto->id_produtos) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                            <button type="submit" 
                            class="text-sm hover:underline {{ $produto->ativo ? 'text-red-500' : 'text-green-500' }}">
                            {{ $produto->ativo ? 'Desativar' : 'Ativar' }}
                            </button>
                            </form>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
