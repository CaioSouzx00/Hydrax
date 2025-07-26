<div class="bg-[#1a1a1a]/50 rounded-xl border border-[#2c2c2c] p-6 shadow-lg">
  <h2 class="text-2xl font-bold mb-6 text-white border-b-2 border-[#14ba88] pb-2">Seus Endereços Cadastrados</h2>

  @if($enderecos->isEmpty())
    <p class="text-gray-400">Você ainda não cadastrou nenhum endereço.</p>
  @else
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-300">
        <thead class="bg-[#0f0f0f] text-[#14ba88]">
          <tr>
            <th class="px-4 py-3 border-b border-[#2c2c2c]">Cidade</th>
            <th class="px-4 py-3 border-b border-[#2c2c2c]">CEP</th>
            <th class="px-4 py-3 border-b border-[#2c2c2c]">Bairro</th>
            <th class="px-4 py-3 border-b border-[#2c2c2c]">Estado</th>
            <th class="px-4 py-3 border-b border-[#2c2c2c]">Rua</th>
            <th class="px-4 py-3 border-b border-[#2c2c2c]">Número</th>
            <th class="px-4 py-3 border-b border-[#2c2c2c]">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($enderecos as $endereco)
          <tr class="hover:bg-[#2a2a2a]/50 transition">
            <td class="px-4 py-3 border-b border-[#2c2c2c]">{{ $endereco->cidade }}</td>
            <td class="px-4 py-3 border-b border-[#2c2c2c]">{{ $endereco->cep }}</td>
            <td class="px-4 py-3 border-b border-[#2c2c2c]">{{ $endereco->bairro }}</td>
            <td class="px-4 py-3 border-b border-[#2c2c2c]">{{ $endereco->estado }}</td>
            <td class="px-4 py-3 border-b border-[#2c2c2c]">{{ $endereco->rua }}</td>
            <td class="px-4 py-3 border-b border-[#2c2c2c]">{{ $endereco->numero }}</td>
            <td class="px-4 py-3 border-b border-[#2c2c2c]">
              <div class="flex items-center gap-4">
                <a href="#" 
                   class="editar-endereco text-orange-400 hover:text-orange-300 transition flex items-center gap-1"
                   data-id="{{ $endereco->id_endereco }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                  </svg>
                  Editar
                </a>

                <form method="POST"
                      action="{{ route('usuarios.enderecos.destroy', $endereco->id_endereco) }}"
                      onsubmit="return confirm('Confirma exclusão deste endereço?')"
                      class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="text-red-500 hover:text-red-400 transition flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Excluir
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
