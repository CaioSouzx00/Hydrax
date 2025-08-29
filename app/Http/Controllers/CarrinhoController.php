<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\CarrinhoItem;
use App\Models\ProdutoFornecedor;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    // 1️⃣ Adicionar produto ao carrinho
   public function adicionarProduto(Request $request, $produtoId)
{
    $usuario = Auth::guard('usuarios')->user();

    // Valida o tamanho selecionado
    $request->validate([
        'tamanho' => 'required|string',
    ]);

    // Recupera ou cria carrinho ativo
    $carrinho = $usuario->carrinhoAtivo;
    if (!$carrinho) {
        $carrinho = Carrinho::create([
            'id_usuarios' => $usuario->id_usuarios,
            'status' => 'ativo',
        ]);
    }

    // Recupera ou cria item no carrinho com o tamanho selecionado
    $item = CarrinhoItem::firstOrCreate(
        [
            'carrinho_id' => $carrinho->id, 
            'produto_id' => $produtoId,
            'tamanho' => $request->tamanho, // Adiciona o tamanho como chave para diferenciar itens
        ],
        ['quantidade' => 1]
    );

    // Se já existia, apenas incrementa a quantidade
    if (!$item->wasRecentlyCreated) {
        $item->increment('quantidade');
    }

    return redirect()->route('carrinho.ver')->with('success', 'Produto adicionado ao carrinho!');
}


    // 2️⃣ Visualizar carrinho
public function verCarrinho()
{
    $usuario = Auth::guard('usuarios')->user();

    $carrinho = $usuario->carrinhoAtivo;
    if (!$carrinho) {
        $carrinho = Carrinho::create([
            'id_usuarios' => $usuario->id_usuarios,
            'status' => 'ativo',
        ]);
    }

    $carrinho->load('itens.produto');

    // Calcula o total
    $total = $carrinho->itens->sum(function($item) {
        return $item->produto->preco * $item->quantidade;
    });

    // 🔥 Buscar produtos para recomendação (4 aleatórios)
    $produtos = ProdutoFornecedor::inRandomOrder()->take(4)->get();

    return view('usuarios.carrinho', compact('carrinho', 'total', 'produtos'));
}


    // 3️⃣ Remover produto do carrinho
public function removerProduto(Request $request, $produtoId)
{
    $usuario = Auth::guard('usuarios')->user();

    $carrinho = $usuario->carrinhoAtivo;
    if ($carrinho) {
        $carrinho->itens()
            ->where('produto_id', $produtoId)
            ->where('tamanho', $request->tamanho)
            ->delete();
    }

    return redirect()->back()->with('success', 'Produto removido do carrinho!');
}



    // 4️⃣ Finalizar compra (simulada)
    public function finalizarCompra()
    {
        $usuario = Auth::guard('usuarios')->user();


        $carrinho = $usuario->carrinhoAtivo;
        if ($carrinho) {
            $carrinho->update(['status' => 'finalizado']);
        }

        return redirect()->route('produtos.index')->with('success', 'Compra finalizada com sucesso!');
    }
}
