<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro de Produto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black min-h-screen flex items-center justify-center">

    <div class="w-full max-w-2xl p-8 bg-gray-900 rounded-3xl shadow-lg shadow-blue-900/50">
        <h1 class="text-4xl font-extrabold mb-8 text-center text-blue-500 tracking-wide">Cadastrar Produto</h1>

        @if(session('success'))
            <div class="bg-green-700 text-green-300 p-3 rounded mb-6 text-center font-semibold">{{ session('success') }}</div>
        @endif

        <form action="{{ route('fornecedores.produtos.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <input
                    type="text"
                    name="nome"
                    placeholder="Nome"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <input
                    type="text"
                    name="descricao"
                    placeholder="Descrição"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <input
                    type="number"
                    name="preco"
                    placeholder="Preço"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <input
                    type="text"
                    name="estoque_imagem"
                    placeholder="Estoque Imagem"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <input
                    type="text"
                    name="caracteristicas"
                    placeholder="Características"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <input
                    type="text"
                    name="historico_modelos"
                    placeholder="Histórico de Modelos"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <input
                    type="text"
                    name="tamanhos_disponiveis"
                    placeholder="Tamanhos Disponíveis"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <input
                    type="text"
                    name="genero"
                    placeholder="Gênero"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <input
                    type="text"
                    name="categoria"
                    placeholder="Categoria"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <input
                    type="text"
                    name="fotos"
                    placeholder="Fotos (caminhos separados por vírgula)"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <input
                    type="number"
                    name="id_fornecedores"
                    placeholder="ID do Fornecedor"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                />
            </div>
            <div>
                <select
                    name="ativo"
                    class="w-full p-4 bg-gray-800 text-gray-200 rounded-xl border border-blue-600 focus:border-blue-400 focus:outline-none transition"
                >
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </div>

            <div class="text-center">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold tracking-wide transition"
                >
                    Cadastrar
                </button>
            </div>
        </form>
    </div>

</body>
</html>
