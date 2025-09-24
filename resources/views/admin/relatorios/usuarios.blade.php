<!-- resources/views/admin/relatorios/usuarios.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="/imagens/hydrax/lca.png" type="image/png" />
<title>Relatório de Compras por Usuário</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
.barra-usuario {
    background: linear-gradient(90deg, #1e40af 0%, #0b182a 100%);
    transition: width 0.6s ease-in-out;
}
.barra-usuario:hover {
    background: linear-gradient(90deg, #3b82f6 0%, #1e3a8a 100%);
}

</style>
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#211828] to-[#17110D] text-white min-h-screen p-10 relative">
<!-- Botão voltar redondo -->
<a href="{{ route('admin.dashboard') }}"
   class="fixed top-4 left-4 z-50 w-10 h-10 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300 shadow-lg"
   title="Voltar">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
</a>
<h2 class="text-2xl font-bold mb-10 mt-10 border-b border-gray-700/80 w-fit text-white">
    Relatório de Compras por Usuário (Últimos 6 Meses)
</h2>

@php
    use Carbon\Carbon;

    $hoje = Carbon::now();
    $meses = [];
    for($i = 5; $i >= 0; $i--){
        $mes = $hoje->copy()->subMonths($i);
        $meses[] = $mes->format('Y-m');
    }

    // Preparar dados de compras por usuário
    $usuariosDados = [];
    foreach($usuarios as $usuario){
        $compras = [];
        foreach($meses as $mes){
            $compras[] = $usuario->carrinhos
                ->where('status','finalizado')
                ->whereBetween('created_at', [
                    Carbon::parse($mes.'-01')->startOfMonth(),
                    Carbon::parse($mes.'-01')->endOfMonth()
                ])
                ->count();
        }
        $usuariosDados[] = [
            'nome' => $usuario->nome_completo,
            'compras' => $compras,
            'total' => array_sum($compras)
        ];
    }

    $maxCompras = max(array_map(fn($u) => $u['total'], $usuariosDados)) ?: 1;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($usuariosDados as $usuario)
        <div class="bg-[#1a1a1a]/30 rounded-2xl p-6 shadow-lg border border-gray-800 hover:shadow-xl transition">
            <h3 class="font-bold text-lg mb-4 text-white border-b border-gray-700 pb-2">
                {{ $usuario['nome'] }}
            </h3>
            
            @foreach($usuario['compras'] as $index => $qtd)
                <div class="mb-4">
                    <span class="text-sm text-gray-400">
                        {{ \Carbon\Carbon::parse($meses[$index].'-01')->translatedFormat('M/Y') }}: 
                        <span class="text-gray-200 font-semibold">{{ $qtd }}</span>
                    </span>
                    <div class="bg-gray-800 h-5 w-full rounded-full overflow-hidden mt-1">
                        <div class="barra-usuario h-full rounded-full" 
                             style="width: {{ ($qtd / $maxCompras) * 100 }}%">
                        </div>
                    </div>
                </div>
            @endforeach

            <p class="text-right font-semibold mt-4 text-blue-400">
                Total: {{ $usuario['total'] }}
            </p>
        </div>
    @endforeach
</div>

</body>
</html>
