<?php

namespace App\Http\Controllers;

use App\Models\ListaDesejo;
use App\Models\ProdutoFornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    public function buscar(Request $request)
    {
        $query = trim($request->input('q'));
        $genero = $request->input('genero');
        $categoria = $request->input('categoria');
        $tamanho = $request->input('tamanho');
        $preco_min = $request->input('preco_min');
        $preco_max = $request->input('preco_max');

        $produtosQuery = ProdutoFornecedor::ativos()
            ->with('avaliacoes')
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

        $produtos = $produtosQuery->paginate(21)->withQueryString();

        // ** Lógica para verificar a lista de desejos **
        $idsDesejados = [];
        if (Auth::guard('usuarios')->check()) {
            $idUsuario = Auth::guard('usuarios')->id();
            $idsDesejados = ListaDesejo::where('id_usuarios', $idUsuario)->pluck('id_produtos')->toArray();
        }

        if ($produtos->isEmpty()) {
            $html = '<p class="text-white p-6 pt-24">Nenhum produto encontrado.</p>';
        } else {
            $html = $produtos->map(function ($produto) use ($idsDesejados) {
                $produto->fotos = json_decode($produto->fotos, true) ?: [];
                // Passa a lista de IDs desejados para a view parcial
                return view('usuarios.partials.card-produto', compact('produto', 'idsDesejados'))->render();
            })->implode('');
        }

        $pagination = view('vendor.pagination.custom', ['paginator' => $produtos])->render();
        
        $texto = "Mostrando {$produtos->firstItem()} a {$produtos->lastItem()} de {$produtos->total()} resultados";

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'texto' => $texto
        ]);
    }


public function detalhes($id)
{
    $usuario = auth()->guard('usuarios')->user();
    
    $produto = ProdutoFornecedor::with(['fornecedor', 'avaliacoes.usuario'])->findOrFail($id);

    // Verifica se o produto está na lista de desejos do usuário logado
  // $usuario = auth()->guard('usuarios')->user();

$isDesejado = $usuario
    ? ListaDesejo::where('id_usuarios', $usuario->id_usuarios)
                 ->where('id_produtos', $produto->id_produtos)
                 ->exists()
    : false;

    // Avaliações
    $avaliacoes = $produto->avaliacoes;
    $totalAvaliadores = $avaliacoes->count();
    $notaMedia = $totalAvaliadores > 0 ? $avaliacoes->avg('nota') : 0;

    $confortoDist = $avaliacoes->whereNotNull('conforto')->avg('conforto') ?? 0;
    $qualidadeDist = $avaliacoes->whereNotNull('qualidade')->avg('qualidade') ?? 0;
    $tamanhoDist = $avaliacoes->whereNotNull('tamanho')->avg('tamanho') ?? 0;
    $larguraDist = $avaliacoes->whereNotNull('largura')->avg('largura') ?? 0;

    // Produtos recomendados
            $produtosRecomendados = ProdutoFornecedor::where('id_produtos', '!=', $id)
            ->inRandomOrder()
            ->limit(4)
            ->get();



        return view('usuarios.detalhes-produto', [

            'produto' => $produto,
            'produtos' => $produtosRecomendados,
            'avaliacoes' => $avaliacoes,
            'totalAvaliadores' => $totalAvaliadores,
            'notaMedia' => $notaMedia,
            'confortoDist' => $confortoDist,
            'qualidadeDist' => $qualidadeDist,
            'tamanhoDist' => $tamanhoDist,
            'larguraDist' => $larguraDist,
            'isDesejado' => $isDesejado,

        ]);


    }


}