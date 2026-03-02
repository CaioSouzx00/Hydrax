<div class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] border border-[#d5891b]/50 rounded-xl shadow-lg p-8 max-w-4xl mx-auto mb-12 text-white">
    <h2 class="text-2xl font-semibold mb-6 text-[#e29b37]">Estoque por Tamanho</h2>

    <div class="mb-6">
        <p class="text-gray-300 text-sm">Produto:</p>
        <p class="text-white font-semibold">{{ $produto->nome }}</p>
    </div>

    @if(empty($tamanhos))
        <div class="p-4 bg-[#0b282a] border border-[#d5891b]/40 rounded text-gray-200">
            Este produto não possui tamanhos cadastrados. Edite o produto e informe os tamanhos disponíveis.
        </div>
    @else
        <form method="POST" action="{{ route('fornecedores.produtos.estoque.update', $produto->id_produtos) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($tamanhos as $tamanho)
                    @php
                        $estoqueAtual = $estoques->get((string)$tamanho)->quantidade ?? 0;
                    @endphp
                    <div class="bg-black/20 border border-[#d5891b]/30 rounded-xl p-4">
                        <label class="block text-sm font-medium text-[#d5891b]">Tamanho {{ $tamanho }}</label>
                        <input
                            type="number"
                            min="0"
                            name="estoque[{{ $tamanho }}]"
                            value="{{ old('estoque.' . $tamanho, $estoqueAtual) }}"
                            class="mt-2 w-full h-10 bg-[#17110d] border border-[#d5891b]/40 rounded px-2 text-white/70 hover:text-white"
                        />
                    </div>
                @endforeach
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-[#d5891b] hover:bg-[#e29b37] text-black/80 font-semibold py-2 px-6 rounded transition">
                    Salvar Estoque
                </button>
            </div>
        </form>
    @endif
</div>
