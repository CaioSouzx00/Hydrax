<form method="POST" action="/completar-cadastro" class="p-6 space-y-4">
    @csrf

    <h2 class="text-xl font-bold">Complete seu cadastro</h2>

    <div>
        <label>Sexo:</label>
        <select name="sexo" class="border p-2 w-full">
            <option value="">Selecione</option>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
            <option value="O">Outro</option>
        </select>
    </div>

    <div>
        <label>CPF:</label>
        <input type="text" name="cpf" class="border p-2 w-full">
    </div>

    <div>
        <label>Telefone:</label>
        <input type="text" name="telefone" class="border p-2 w-full">
    </div>

    <div>
        <label>Data de nascimento:</label>
        <input type="date" name="data_nascimento" class="border p-2 w-full">
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded-md">
        Salvar
    </button>
</form>
