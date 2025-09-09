<!-- resources/views/admin/relatorios/usuarios.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Relatório de Compras por Usuário</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Barra estilo Adidas em dark mode */
    .barra-usuario {
        background: linear-gradient(90deg, #14ba88 0%, #0b282a 100%);
        transition: width 0.6s ease-in-out;
    }
    .barra-usuario:hover {
        background: linear-gradient(90deg, #1fe0aa 0%, #146b6d 100%);
    }
</style>
</head>
<body class="bg-[#0f0f0f] font-sans p-8 text-gray-200">

<h2 class="text-3xl font-bold mb-10 text-center text-white">
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
        <div class="bg-[#1a1a1a] rounded-2xl p-6 shadow-lg border border-gray-800 hover:shadow-xl transition">
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

            <p class="text-right font-semibold mt-4 text-green-400">
                Total: {{ $usuario['total'] }}
            </p>
        </div>
    @endforeach
</div>

</body>
</html>
