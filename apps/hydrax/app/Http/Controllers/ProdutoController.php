<?php

namespace App\Http\Controllers;

use App\Models\ListaDesejo;
use App\Models\ProdutoFornecedor;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class ProdutoController extends Controller
{
    public function marca($slug)
    {
        return redirect()->route('dashboard', ['marca' => $slug]);
    }

    public function buscar(Request $request)
{
    $query = trim($request->input('q'));
    $genero = $request->input('genero');
    $categoria = $request->input('categoria');
    $tamanho = $request->input('tamanho');
    $preco_min = $request->input('preco_min');
    $preco_max = $request->input('preco_max');
    $cor = $request->input('cor'); // 👈 Novo filtro
    $marca = $request->input('marca');

    $produtosQuery = ProdutoFornecedor::ativos()
        ->with(['avaliacoes', 'marca'])
        ->withAvg('avaliacoes', 'nota');

    if ($query !== '') { 
        $produtosQuery->where(function ($q) use ($query) {
            $q->where('nome', 'LIKE', "%{$query}%")
              ->orWhere('descricao', 'LIKE', "%{$query}%");
        });
    }

    if (!empty($genero)) $produtosQuery->where('genero', $genero);
    if (!empty($categoria)) $produtosQuery->where('categoria', $categoria);
    if (!empty($tamanho)) {
        $produtosQuery->whereJsonContains('tamanhos_disponiveis', (string)$tamanho);
    }
    if (!empty($preco_min)) $produtosQuery->where('preco', '>=', $preco_min);
    if (!empty($preco_max)) $produtosQuery->where('preco', '<=', $preco_max);
    if (!empty($cor)) $produtosQuery->where('cor', $cor);

    if (!empty($marca)) {
        if (is_numeric($marca)) {
            $produtosQuery->where('marca_id', (int)$marca);
        } else {
            $marcaModel = Marca::where('slug', $marca)->first();
            if ($marcaModel) {
                $produtosQuery->where('marca_id', $marcaModel->id);
            }
        }
    }

    $produtos = $produtosQuery->paginate(21)->withQueryString();

    // 🔥 Aqui você pega apenas as cores que realmente existem
    $coresDisponiveis = ProdutoFornecedor::ativos()
    ->selectRaw('TRIM(cor) as cor')
    ->distinct()
    ->pluck('cor')
    ->filter()
    ->values();

    // ** Lista de desejos **
    $idsDesejados = [];
    if (Auth::guard('usuarios')->check()) {
        $idUsuario = Auth::guard('usuarios')->id();
        $idsDesejados = ListaDesejo::where('id_usuarios', $idUsuario)->pluck('id_produtos')->toArray();
    }

    if ($produtos->isEmpty()) {
        $html = '<p class="text-white p-6 pt-24">Nenhum produto encontrado.</p>';
    } else {
        $html = $produtos->map(function ($produto) use ($idsDesejados) {
            $fotos = $produto->fotos ?? [];
            if (!is_array($fotos)) {
                $fotos = json_decode((string) $fotos, true);
                if (is_string($fotos)) {
                    $fotos = json_decode($fotos, true);
                }
            }
            $produto->fotos = is_array($fotos) ? $fotos : [];
            return view('usuarios.partials.card-produto', compact('produto', 'idsDesejados'))->render();
        })->implode('');
    }

    $pagination = view('vendor.pagination.custom', ['paginator' => $produtos])->render();
    $texto = "Mostrando {$produtos->firstItem()} a {$produtos->lastItem()} de {$produtos->total()} resultados";


    return response()->json([
        'html' => $html,
        'pagination' => $pagination,
        'texto' => $texto,
        'cores' => $coresDisponiveis
    ]);
}


public function detalhes($id)
{
    $usuario = auth()->guard('usuarios')->user();

    // ✅ Cache leve do produto com relações (1 min)
    $produto = Cache::remember("produto_detalhe_{$id}", 60, function () use ($id) {
        return ProdutoFornecedor::with([
            'fornecedor:id_fornecedores,nome_empresa', 
            'avaliacoes' => function ($q) {
                $q->with('usuario:id_usuarios,nome_completo');
            }
        ])->findOrFail($id);
    });

    // ✅ Verifica se está na lista de desejos (consulta indexada)
    $isDesejado = $usuario
        ? ListaDesejo::where('id_usuarios', $usuario->id_usuarios)
            ->where('id_produtos', $produto->id_produtos)
            ->exists()
        : false;

    // ✅ Cálculos no banco (evita percorrer coleções grandes no PHP)
    $avaliacoesQuery = $produto->avaliacoes();
    $totalAvaliadores = $avaliacoesQuery->count();
    $notaMedia = $totalAvaliadores > 0 ? $avaliacoesQuery->avg('nota') : 0;
    $confortoDist = $avaliacoesQuery->avg('conforto') ?? 0;
    $qualidadeDist = $avaliacoesQuery->avg('qualidade') ?? 0;
    $tamanhoDist = $avaliacoesQuery->avg('tamanho') ?? 0;
    $larguraDist = $avaliacoesQuery->avg('largura') ?? 0;

    // ✅ Produtos recomendados com cache de 5 min (evita RAND() pesado toda vez)
$produtosRecomendados = Cache::remember("recomendados_{$id}", 300, function () use ($id) {
    return ProdutoFornecedor::with([
        'fornecedor:id_fornecedores,nome_empresa,foto',
    ])
    ->withAvg('avaliacoes', 'nota')
    ->withCount('avaliacoes')
    ->where('id_produtos', '!=', $id)
    ->inRandomOrder()
    ->limit(4)
    ->get([
        'id_produtos',
        'nome',
        'categoria',
        'preco',
        'fotos',
        'id_fornecedores',
    ]);
});


    // ✅ Variantes otimizadas (somente campos necessários)
    $variantes = ProdutoFornecedor::where('historico_modelos', $produto->historico_modelos)
        ->get(['id_produtos', 'cor', 'slug', 'fotos', 'estoque_imagem']);

    return view('usuarios.detalhes-produto', [
        'produto' => $produto,
        'produtos' => $produtosRecomendados,
        'avaliacoes' => $produto->avaliacoes, // mantém compatibilidade
        'totalAvaliadores' => $totalAvaliadores,
        'notaMedia' => $notaMedia,
        'confortoDist' => $confortoDist,
        'qualidadeDist' => $qualidadeDist,
        'tamanhoDist' => $tamanhoDist,
        'larguraDist' => $larguraDist,
        'isDesejado' => $isDesejado,
        'variantes' => $variantes,
    ]);
}



}