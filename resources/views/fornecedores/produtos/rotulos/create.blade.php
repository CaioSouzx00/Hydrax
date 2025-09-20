@if(session('error'))
<div class="mb-4 p-4 bg-[#0b282a] border border-red-500 rounded text-red-500">
    {{ session('error') }}
</div>
@endif

<h2 class="text-2xl font-bold mb-4">Cadastrar Labels para: {{ $produto->nome }}</h2>

<form method="POST" action="{{ route('fornecedores.produtos.rotulos.store', $produto->id_produtos) }}">
    @csrf

    <label class="block mb-2">Imagem</label>
    <select name="imagem" class="w-full p-2 mb-4 bg-gray-800 text-white rounded">
        @foreach(json_decode($produto->estoque_imagem, true) as $img)
            <option value="{{ $img }}">{{ $img }}</option>
        @endforeach
    </select>

    <label class="block mb-2">Categoria</label>
    <select name="categoria" class="w-full p-2 mb-4 bg-gray-800 text-white rounded">
        <option value="basquete">Basquete</option>
        <option value="lifestyle">Lifestyle</option>
        <option value="volei">Vôlei</option>
    </select>

    <label class="block mb-2">Estilo</label>
    <select name="estilo" class="w-full p-2 mb-4 bg-gray-800 text-white rounded">
        <option value="casual">Casual</option>
        <option value="agressivo">Agressivo</option>
    </select>

    <label class="block mb-2">Gênero</label>
    <select name="genero" class="w-full p-2 mb-4 bg-gray-800 text-white rounded">
        <option value="MASCULINO">Masculino</option>
        <option value="FEMININO">Feminino</option>
        <option value="UNISSEX">Unissex</option>
    </select>

   <div class="mb-4">
    <label class="block text-sm font-medium text-gray-200">Marca</label>
    <input type="text" class="w-full rounded bg-gray-800 text-white p-2" value="{{ $fornecedorNome }}" disabled>
</div>


    <button type="submit" class="px-5 py-2 bg-green-600 rounded hover:bg-green-700 transition text-white">
        Salvar Label
    </button>
</form>