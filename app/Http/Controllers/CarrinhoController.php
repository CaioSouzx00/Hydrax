<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\CarrinhoItem;
use App\Models\ProdutoFornecedor;
use App\Models\EnderecoUsuario;
use App\Models\Cupom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Jobs\EnviarCarrinhoAbandonadoJob;

class CarrinhoController extends Controller
{
    // 1️⃣ Adicionar produto ao carrinho
    public function adicionarProduto(Request $request, $produtoId)
    {
        $usuario = Auth::guard('usuarios')->user();

        $produto = ProdutoFornecedor::ativos()->find($produtoId);
        if (!$produto) {
            return redirect()->back()->with('error', 'Este produto não está disponível.');
        }

        $request->validate([
            'tamanho' => 'required|string',
            'quantidade' => 'nullable|integer|min:1',
        ]);

        $quantidade = $request->input('quantidade', 1);

        $carrinho = $usuario->carrinhoAtivo ?? Carrinho::create([
            'id_usuarios' => $usuario->id_usuarios,
            'status' => 'ativo',
        ]);

        $item = CarrinhoItem::where('carrinho_id', $carrinho->id)
            ->where('produto_id', $produtoId)
            ->where('tamanho', $request->tamanho)
            ->first();

        if ($item) {
            $item->quantidade += $quantidade;
            $item->save();
        } else {
            CarrinhoItem::create([
                'carrinho_id' => $carrinho->id,
                'produto_id' => $produtoId,
                'tamanho' => $request->tamanho,
                'quantidade' => $quantidade,
            ]);
        }

        EnviarCarrinhoAbandonadoJob::dispatch($carrinho->id)->delay(now()->addMinutes(1));

        return redirect()->route('carrinho.ver')->with('success', 'Produto adicionado ao carrinho!');
    }

    // 2️⃣ Visualizar carrinho
// 2️⃣ Visualizar carrinho
public function verCarrinho()
{
    $usuario = Auth::guard('usuarios')->user();

    $carrinho = $usuario->carrinhoAtivo ?? Carrinho::create([
        'id_usuarios' => $usuario->id_usuarios,
        'status' => 'ativo',
    ]);

    $carrinho->load(['itens.produto']);

    $enderecos = EnderecoUsuario::where('id_usuarios', $usuario->id_usuarios)->get();
    $total = $carrinho->itens->sum(fn($item) => $item->produto->preco * $item->quantidade);

    $cupons = Cupom::where('ativo', 1)
        ->where(fn($q) => $q->whereNull('validade')->orWhere('validade', '>=', now()))
        ->get();

    $cupomAplicado = session('cupom_aplicado');

    // 🔥 Buscar 4 produtos aleatórios para recomendação
    $produtos = ProdutoFornecedor::ativos()
        ->inRandomOrder()
        ->take(4)
        ->get();

    return view('usuarios.carrinho', compact(
        'carrinho', 'total', 'enderecos', 'cupons', 'cupomAplicado', 'produtos'
    ));
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

    // 4️⃣ Finalizar compra
    public function finalizarCompra()
    {
        $usuario = Auth::guard('usuarios')->user();

        $enderecos = EnderecoUsuario::where('id_usuarios', $usuario->id_usuarios)->get();

        $carrinho = Carrinho::where('id_usuarios', $usuario->id_usuarios)
            ->where('status', 'ativo')
            ->with(['itens.produto' => fn($q) => $q->ativos()])
            ->first();

        if (!$carrinho || $carrinho->itens->isEmpty()) {
            return redirect()->route('carrinho.ver')->with('error', 'Você precisa ter pelo menos 1 produto no carrinho.');
        }

        $cupons = Cupom::where('ativo', 1)
            ->where(fn($q) => $q->whereNull('validade')->orWhere('validade', '>=', now()))
            ->get();

        $total = $carrinho->itens->sum(fn($item) => $item->produto->preco * $item->quantidade);
        $entrega = 15;
        $totalComEntrega = $total + $entrega;

        $cupomAplicado = session('cupom_aplicado');
        $desconto = 0;

        if ($cupomAplicado) {
            if ($cupomAplicado['tipo'] === 'percentual') {
                $desconto = $totalComEntrega * ($cupomAplicado['valor']/100);
            } else {
                $desconto = $cupomAplicado['valor'];
            }
            $totalComEntrega -= $desconto;
        }

        return view('usuarios.selecionar_endereco', compact(
            'enderecos', 'carrinho', 'cupons', 'totalComEntrega', 'desconto', 'cupomAplicado'
        ));
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
            return redirect()->route('carrinho.ver')->with('error', 'Carrinho vazio.');
        }

        $total = $carrinho->itens->sum(fn($item) => $item->produto->preco * $item->quantidade);
        $entrega = 15;
        $total += $entrega;

        $cupomAplicado = session('cupom_aplicado');
        $desconto = 0;
        if ($cupomAplicado) {
            if ($cupomAplicado['tipo'] === 'percentual') {
                $desconto = $total * ($cupomAplicado['valor']/100);
            } else {
                $desconto = $cupomAplicado['valor'];
            }
            $total -= $desconto;
        }

        $carrinho->id_endereco = $enderecoSelecionado->id_endereco;
        $carrinho->status = 'finalizado';
        $carrinho->save();

        $chavePix = 'hydrax-pix-' . strtoupper(Str::random(10));
        Mail::to($usuario->email)->send(new \App\Mail\ChavePixMail($chavePix, $total));

        Carrinho::create(['id_usuarios' => $usuario->id_usuarios, 'status' => 'ativo']);

        session()->forget('cupom_aplicado');

        return view('usuarios.pix', compact('chavePix', 'total', 'enderecoSelecionado', 'desconto', 'cupomAplicado'));
    }

    // 5️⃣ Meus pedidos
    public function meusPedidos()
    {
        $usuario = Auth::guard('usuarios')->user();

        $pedidos = Carrinho::where('id_usuarios', $usuario->id_usuarios)
            ->where('status', 'finalizado')
            ->with([
                'itens' => fn($q) => $q->whereHas('produto', fn($q2) => $q2->ativos())->with('produto'),
                'endereco'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('usuarios.pedidos', compact('pedidos'));
    }

public function detalhePedido($pedidoId)
{
    $usuario = Auth::guard('usuarios')->user();
    $pedido = Carrinho::where('id_usuarios', $usuario->id_usuarios)
        ->where('status', 'finalizado')
        ->with('itens.produto', 'endereco')
        ->findOrFail($pedidoId);

    // Pega o cupom aplicado, caso esteja na sessão ou gravado no pedido
    $cupomAplicado = $pedido->cupom_aplicado ?? null;

    return view('usuarios.pedido_detalhe', compact('pedido', 'cupomAplicado'));
}


    // 6️⃣ Aplicar cupom
    public function aplicarCupom(Request $request)
    {
        $cupom = Cupom::where('codigo', $request->codigo_cupom)
                        ->where('ativo', 1)
                        ->first();

        if(!$cupom) {
            return back()->with('error', 'Cupom inválido.');
        }

        session(['cupom_aplicado' => [
            'codigo' => $cupom->codigo,
            'tipo' => $cupom->tipo,
            'valor' => $cupom->valor
        ]]);

        return back()->with('success', 'Cupom aplicado com sucesso!');
    }
}
