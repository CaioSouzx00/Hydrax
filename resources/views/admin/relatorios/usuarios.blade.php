<!-- resources/views/admin/relatorios/usuarios.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Relatório de Compras por Usuário</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Estilo Adidas: gradientes e barra com sombra */
    .barra-usuario {
        background: linear-gradient(90deg, #000 0%, #555 100%);
        transition: width 0.5s;
    }
    .barra-usuario:hover {
        background: linear-gradient(90deg, #000 0%, #888 100%);
    }
</style>
</head>
<body class="bg-white font-sans p-6">

<h2 class="text-2xl font-bold mb-8 text-center">Relatório de Compras por Usuário (Últimos 6 Meses)</h2>

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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($usuariosDados as $usuario)
        <div class="bg-gray-100 rounded-lg p-4 shadow hover:shadow-lg transition">
            <h3 class="font-bold text-lg mb-2">{{ $usuario['nome'] }}</h3>
            
            @foreach($usuario['compras'] as $index => $qtd)
                <div class="mb-2">
                    <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($meses[$index].'-01')->translatedFormat('M/Y') }}: {{ $qtd }}</span>
                    <div class="bg-gray-300 h-6 w-full rounded-full overflow-hidden mt-1">
                        <div class="barra-usuario h-full rounded-full" style="width: {{ ($qtd / $maxCompras) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach

            <p class="text-right font-semibold mt-2">Total: {{ $usuario['total'] }}</p>
        </div>
    @endforeach
</div>

</body>
</html>
