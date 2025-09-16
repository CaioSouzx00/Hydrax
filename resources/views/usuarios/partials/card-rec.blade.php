@php
    $isDesejado = in_array($produto->id_produtos, $idsDesejados ?? []);
@endphp

<div class="relative w-96 mr-12">

    {{-- Card clicável --}}
    <a href="{{ route('produtos.detalhes', $produto->id_produtos) }}" class="block w-full h-full relative z-10">
        <div class="bg-[#111]/50 border border-[#222] rounded-xl shadow-lg p-8 min-h-[580px] cursor-pointer hover:border-[#D5891B]/20 transition-all duration-200 flex flex-col">

            {{-- Imagem do produto --}}
            @php
                $fotos = is_array($produto->fotos) ? $produto->fotos : json_decode($produto->fotos, true);
                $foto = is_array($fotos) && count($fotos) > 0 ? $fotos[0] : null;
            @endphp
            <div class="w-full mb-4">
                <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/400x400?text=Produto' }}" 
                     alt="Imagem do Produto" 
                     class="w-full h-72 object-cover rounded-lg border border-[#D5891B]/20 shadow-sm" />
            </div>

            {{-- Conteúdo --}}
            <div class="flex flex-col space-y-3">
                <h3 class="text-base font-semibold text-white truncate" title="{{ $produto->nome }}">
                    {{ $produto->nome }}
                </h3>

                <p class="text-xs text-gray-400">{{ $produto->categoria }}</p>

                <p class="text-white font-bold text-lg mt-1">
                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                </p>

                {{-- Fornecedor --}}
                <div class="flex items-center space-x-2 mt-2">
                    <img 
                        src="{{ $produto->fornecedor->foto ? asset('storage/' . $produto->fornecedor->foto) : 'https://via.placeholder.com/40x40?text=F' }}" 
                        alt="Foto do fornecedor"
                        class="w-8 h-8 rounded-full object-cover border border-[#D5891B]/20"
                    >
                    <span class="text-xs text-gray-400">
                        {{ $produto->fornecedor->nome_empresa ?? 'Fornecedor não informado' }}
                    </span>
                </div>



            </div>
        </div>
    </a>
</div>

{{-- Script AJAX para wishlist --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.wishlist-form');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const url = this.action;
                const button = this.querySelector('button svg');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // alterna o fill do coração
                        if (data.action === 'adicionado') {
                            button.setAttribute('fill', '#d5891b');
                        } else {
                            button.setAttribute('fill', 'none');
                        }
                    }
                })
                .catch(err => console.error(err));
            });
        });
    });
</script>
