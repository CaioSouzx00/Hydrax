<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\CarrinhoItem;
use App\Models\ProdutoFornecedor;
use Illuminate\Support\Facades\Auth;
use App\Models\EnderecoUsuario;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Jobs\EnviarCarrinhoAbandonadoJob;

class CarrinhoController extends Controller
{
    // 1️⃣ Adicionar produto ao carrinho
  // 1️⃣ Adicionar produto ao carrinho
public function adicionarProduto(Request $request, $produtoId)
{
    $usuario = Auth::guard('usuarios')->user();

    // Valida o tamanho selecionado e quantidade
    $request->validate([
        'tamanho' => 'required|string',
        'quantidade' => 'nullable|integer|min:1',
    ]);

    $quantidade = $request->input('quantidade', 1);

    // Recupera ou cria carrinho ativo
    $carrinho = $usuario->carrinhoAtivo;
    if (!$carrinho) {
        $carrinho = Carrinho::create([
            'id_usuarios' => $usuario->id_usuarios,
            'status' => 'ativo',
        ]);
    }

    // Recupera item existente (mesmo produto e mesmo tamanho)
    $item = CarrinhoItem::where('carrinho_id', $carrinho->id)
        ->where('produto_id', $produtoId)
        ->where('tamanho', $request->tamanho)
        ->first();

    if ($item) {
        // Se já existe, soma a quantidade
        $item->quantidade += $quantidade;
        $item->save();
    } else {
        // Se não existe, cria o item
        CarrinhoItem::create([
            'carrinho_id' => $carrinho->id,
            'produto_id' => $produtoId,
            'tamanho' => $request->tamanho,
            'quantidade' => $quantidade,
        ]);
    }

    EnviarCarrinhoAbandonadoJob::dispatch($carrinho->id)->delay(now()->addMinutes(1));


    return redirect()->route('carrinho.ver')
                     ->with('success', 'Produto adicionado ao carrinho!');
}



    // 2️⃣ Visualizar carrinho
public function verCarrinho()
{
    $usuario = Auth::guard('usuarios')->user();
    $carrinho = $usuario->carrinhoAtivo ?? Carrinho::create([
        'id_usuarios' => $usuario->id_usuarios,
        'status' => 'ativo',
    ]);

    $carrinho->load('itens.produto');

    $enderecos = EnderecoUsuario::where('id_usuarios', $usuario->id_usuarios)->get(); // ADICIONAR ISSO

    $total = $carrinho->itens->sum(fn($item) => $item->produto->preco * $item->quantidade);
    $produtos = ProdutoFornecedor::inRandomOrder()
    ->limit(4)
    ->get();


    return view('usuarios.carrinho', compact('carrinho', 'total', 'produtos', 'enderecos')); // INCLUIR $enderecos
}



    // 3️⃣ Remover produto do carrinho
public function removerProduto($produtoId, $tamanho)
{
    $usuario = Auth::guard('usuarios')->user();

    $carrinho = $usuario->carrinhoAtivo;
    if ($carrinho) {
        $carrinho->itens()
            ->where('produto_id', $produtoId)
            ->where('tamanho', $tamanho)
            ->delete();
    }

    return redirect()->back()->with('success', 'Produto removido do carrinho!');
}



    // 4️⃣ Finalizar compra (simulada)
public function finalizarCompra()
{
    $usuario = Auth::guard('usuarios')->user();

    $enderecos = EnderecoUsuario::where('id_usuarios', $usuario->id_usuarios)->get();
    $carrinho = Carrinho::where('id_usuarios', $usuario->id_usuarios)
                        ->where('status', 'ativo')
                        ->with('itens.produto')
                        ->first();

    // 🚨 Se não tiver carrinho ou não tiver itens → volta pro carrinho com erro
    if (!$carrinho || $carrinho->itens->isEmpty()) {
        return redirect()->route('carrinho.ver')
                         ->with('error', 'Você precisa ter no mínimo 1 produto no carrinho para finalizar a compra.');
    }

    // Se não tem endereço cadastrado → pede pra cadastrar
    if ($enderecos->isEmpty()) {
        return view('usuarios.endereco_form', compact('carrinho'));
    }

    // Caso ok → vai para selecionar endereço
    return view('usuarios.selecionar_endereco', compact('enderecos', 'carrinho'));
}



public function processarFinalizacao(Request $request)
{
    $usuario = Auth::guard('usuarios')->user();

    $request->validate([
        'id_endereco' => 'required|exists:endereco_usuarios,id_endereco',
    ], [
        'id_endereco.required' => 'Você precisa selecionar um endereço para finalizar a compra.',
    ]);

    $enderecoSelecionado = EnderecoUsuario::find($request->id_endereco);

    $carrinho = Carrinho::where('id_usuarios', $usuario->id_usuarios)
                        ->where('status', 'ativo')
                        ->with('itens.produto')
                        ->first();

    if (!$carrinho || $carrinho->itens->isEmpty()) {
    return redirect()->route('carrinho.ver')
                     ->with('error', 'Você precisa ter no mínimo 1 produto no carrinho para finalizar a compra.');
}


    // 🔹 Calcular total
    $total = $carrinho->itens->sum(fn($item) => $item->produto->preco * $item->quantidade) + 15;

    // 🔹 Gerar chave Pix fake
    $chavePix = 'hydrax-pix-' . strtoupper(\Illuminate\Support\Str::random(10));

    // 🔹 Enviar chave Pix por e-mail
    \Illuminate\Support\Facades\Mail::to($usuario->email)
        ->send(new \App\Mail\ChavePixMail($chavePix, $total));

    // 🔹 Marcar carrinho como finalizado
    $carrinho->status = 'finalizado';
    $carrinho->id_endereco = $enderecoSelecionado->id_endereco;
    $carrinho->save();


    // 🔹 Criar novo carrinho vazio (se quiser manter o fluxo contínuo)
    $novoCarrinho = Carrinho::create([
        'id_usuarios' => $usuario->id_usuarios,
        'status' => 'ativo',
    ]);

    // 🔹 Retornar tela com chave Pix
    return view('usuarios.pix', compact('chavePix', 'total', 'enderecoSelecionado'));
}

public function meusPedidos()
{
    $usuario = Auth::guard('usuarios')->user();

    // Buscar todos os carrinhos finalizados desse usuário
    $pedidos = Carrinho::where('id_usuarios', $usuario->id_usuarios)
        ->where('status', 'finalizado')
        ->with('itens.produto')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('usuarios.pedidos', compact('pedidos'));
}

// 7️⃣ Detalhes de um pedido específico
public function detalhePedido($pedidoId)
{
    $usuario = Auth::guard('usuarios')->user();

    // Buscar pedido finalizado do usuário com itens, produtos e endereço
    $pedido = Carrinho::where('id_usuarios', $usuario->id_usuarios)
        ->where('status', 'finalizado')
        ->with('itens.produto', 'endereco')
        ->findOrFail($pedidoId); // retorna 404 se não existir

    return view('usuarios.pedido_detalhe', compact('pedido'));
}




}