<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoFornecedor;
use Illuminate\Pagination\LengthAwarePaginator;

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
    // Adicione o 'with' para carregar a coleção de avaliações
    ->with('avaliacoes')
    // Mantenha o 'withAvg' para a propriedade calculada
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

    if ($produtos->isEmpty()) {
        $html = '<p class="text-white p-6 pt-24">Nenhum produto encontrado.</p>';
    } else {
        $html = $produtos->map(function($produto) {
            // A nota média já estará disponível em $produto->avaliacoes_avg_nota
            $produto->fotos = json_decode($produto->fotos, true) ?: [];
            return view('usuarios.partials.card-produto', compact('produto'))->render();
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
        // Pega o usuário logado
        $usuario = auth()->guard('usuarios')->user(); 

        // Busca o produto e carrega as avaliações e os usuários que as fizeram
        // Use with() para carregar os relacionamentos, otimizando a consulta.
        $produto = ProdutoFornecedor::with(['fornecedor', 'avaliacoes.usuario'])->findOrFail($id);

        // **AQUI ESTÁ A LÓGICA DE AVALIAÇÃO CONSOLIDADA**
        $avaliacoes = $produto->avaliacoes;
        
        $totalAvaliadores = $avaliacoes->count();
        $notaMedia = $totalAvaliadores > 0 ? $avaliacoes->avg('nota') : 0;
        
        $confortoDist = $avaliacoes->whereNotNull('conforto')->avg('conforto') ?? 0;
        $qualidadeDist = $avaliacoes->whereNotNull('qualidade')->avg('qualidade') ?? 0;
        $tamanhoDist = $avaliacoes->whereNotNull('tamanho')->avg('tamanho') ?? 0;
        $larguraDist = $avaliacoes->whereNotNull('largura')->avg('largura') ?? 0;

        // Pega produtos recomendados (exceto o produto atual)
        $produtosRecomendados = ProdutoFornecedor::where('id_produtos', '!=', $id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Passa todas as variáveis para a view 'usuarios.detalhes-produto'
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
        ]);
    }




}

