@if(session('error'))
<div class="mb-6 p-4 bg-[#0b282a]/80 border border-red-600 rounded-lg text-red-500 font-medium">
    {{ session('error') }}
</div>
@endif

<div class="bg-gradient-to-br from-[#211828] via-[#0b282a] to-[#17110d] border border-[#d5891b]/50 rounded-xl shadow-lg p-8 max-w-3xl mx-auto">
    <h2 class="text-2xl font-semibold mb-6 text-[#e29b37]">
        Cadastrar Labels para: {{ $produto->nome }}
    </h2>

    <form method="POST" action="{{ route('fornecedores.produtos.rotulos.store', $produto->id_produtos) }}">
        @csrf

        <!-- Imagem -->
        <div class="mb-4">
            <label class="block text-sm text-[#d5891b] mb-1">Imagem</label>
            <select name="imagem" class="w-full px-4 py-3 bg-[#17110d] text-white/70 border border-[#d5891b]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d5891b] transition">
                @foreach(json_decode($produto->estoque_imagem, true) as $img)
                    <option value="{{ $img }}">{{ $img }}</option>
                @endforeach
            </select>
        </div>

        <!-- Categoria -->
        <div class="mb-4">
            <label class="block text-sm text-[#d5891b] mb-1">Categoria</label>
            <select name="categoria" class="w-full px-4 py-3 bg-[#17110d] text-white/70 border border-[#d5891b]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d5891b] transition">
                <option value="basquete">Basquete</option>
                <option value="lifestyle">Lifestyle</option>
                <option value="volei">Vôlei</option>
            </select>
        </div>

        <!-- Estilo -->
        <div class="mb-4">
            <label class="block text-sm text-[#d5891b] mb-1">Estilo</label>
            <select name="estilo" class="w-full px-4 py-3 bg-[#17110d] text-white/70 border border-[#d5891b]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d5891b] transition">
                <option value="casual">Casual</option>
                <option value="agressivo">Agressivo</option>
            </select>
        </div>

        <!-- Gênero -->
        <div class="mb-4">
            <label class="block text-sm text-[#d5891b] mb-1">Gênero</label>
            <select name="genero" class="w-full px-4 py-3 bg-[#17110d] text-white/70 border border-[#d5891b]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d5891b] transition">
                <option value="MASCULINO">Masculino</option>
                <option value="FEMININO">Feminino</option>
                <option value="UNISSEX">Unissex</option>
            </select>
        </div>

        <!-- Marca -->
        <div class="mb-6">
            <label class="block text-sm text-[#d5891b] mb-1">Marca</label>
            <input type="text" class="w-full px-4 py-3 bg-[#17110d] text-white/70 border border-[#d5891b]/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d5891b]" value="{{ $fornecedorNome }}" disabled>
        </div>

        <!-- Botão -->
        <button type="submit" class="w-full py-3 bg-[#14ba88] hover:bg-[#0fa374] rounded-lg font-semibold shadow transition text-black/80">
            Salvar Label
        </button>
    </form>
</div>
