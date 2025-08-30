<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Fornecedor;
use App\Models\ProdutoFornecedor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class RelatorioController extends Controller
{
    // 1️⃣ Compras por usuário
    public function comprasPorUsuario()
    {
        $usuarios = Usuario::with(['carrinhos.itens.produto'])->get();
        return view('admin.relatorios.usuarios', compact('usuarios'));
    }

    // 2️⃣ Vendas por fornecedor
public function vendasPorFornecedor()
{
    $seisMesesAtras = now()->subMonths(5)->startOfMonth();
    $hoje = now()->endOfMonth();

    // Pega todos os fornecedores e produtos
    $fornecedores = Fornecedor::with('produtos.carrinhoItens.carrinho')->get();

    $labels = [];
    for ($i = 0; $i < 6; $i++) {
        $labels[] = now()->subMonths(5 - $i)->format('m/Y'); // Formato MM/YYYY
    }

    $dadosFornecedores = $fornecedores->map(function($fornecedor) use ($labels, $seisMesesAtras, $hoje) {
        $valores = [];

        foreach ($labels as $label) {
            [$mes, $ano] = explode('/', $label);

            $total = $fornecedor->produtos->sum(function($produto) use ($mes, $ano, $seisMesesAtras, $hoje) {
                return $produto->carrinhoItens->sum(function($item) use ($mes, $ano, $seisMesesAtras, $hoje) {
                    $carrinho = $item->carrinho;

                    if (!$carrinho || $carrinho->status !== 'finalizado') return 0;

                    $data = $carrinho->created_at->format('m/Y');
                    return $data === "$mes/$ano" ? $item->quantidade : 0;
                });
            });

            $valores[] = $total;
        }

        return [
            'nome' => $fornecedor->nome_empresa,
            'valores' => $valores,
        ];
    });

    return view('admin.relatorios.fornecedores', compact('labels', 'dadosFornecedores'));
}



    // 3️⃣ Produtos mais vendidos (últimos 7 dias)
   public function produtosMaisVendidos()
{
    $produtos = ProdutoFornecedor::with(['carrinhoItens.carrinho'])->get();

    $produtosVendidos = $produtos->map(function($produto) {
        $dias = [];
        $vendasPorDia = [];

        // últimos 7 dias
        for ($i = 6; $i >= 0; $i--) {
            $data = Carbon::now()->subDays($i);
            $dias[] = $data->format('d/m');

            $total = $produto->carrinhoItens
                ->where('carrinho.status', 'finalizado')
                ->where(fn($c) => $c->carrinho->created_at->format('Y-m-d') == $data->format('Y-m-d'))
                ->sum('quantidade');

            $vendasPorDia[] = $total;
        }

        $produto->dias = $dias;
        $produto->vendasPorDia = $vendasPorDia;

        return $produto;
    });

    return view('admin.relatorios.produtos', compact('produtosVendidos'));
}
}
