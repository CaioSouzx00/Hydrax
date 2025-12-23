<?php

namespace App\Http\Controllers;

use App\Http\Requests\Carrinho\AdicionarProdutoRequest;
use App\Http\Requests\Carrinho\ProcessarFinalizacaoRequest;
use App\Services\Carrinho\CarrinhoService;
use App\Models\Carrinho;
use App\Models\ProdutoFornecedor;
use App\Models\EnderecoUsuario;
use App\Models\Cupom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsável pelas operações relacionadas ao carrinho de compras.
 * 
 * Refatorado seguindo Clean Code e SOLID:
 * - Validações movidas para Form Requests
 * - Lógica de negócio extraída para CarrinhoService
 * - Controller mantém apenas orquestração e respostas HTTP
 */
class CarrinhoController extends Controller
{
    /**
     * Service de carrinho injetado via construtor.
     *
     * @var CarrinhoService
     */
    protected CarrinhoService $carrinhoService;

    /**
     * Construtor com injeção de dependência do Service.
     *
     * @param CarrinhoService $carrinhoService
     */
    public function __construct(CarrinhoService $carrinhoService)
    {
        $this->carrinhoService = $carrinhoService;
    }

    /**
     * Adiciona um produto ao carrinho.
     * 
     * Validação via AdicionarProdutoRequest.
     * Lógica de negócio delegada ao CarrinhoService.
     *
     * @param AdicionarProdutoRequest $request
     * @param int $produtoId ID do produto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adicionarProduto(AdicionarProdutoRequest $request, $produtoId)
    {
        $usuario = Auth::guard('usuarios')->user();
        $produto = ProdutoFornecedor::ativos()->find($produtoId);

        if (!$produto) {
            return redirect()->back()->with('error', 'Este produto não está disponível.');
        }

        $dados = $request->validated();
        $quantidade = $dados['quantidade'] ?? 1;

        $this->carrinhoService->adicionarProduto(
            $usuario->id_usuarios,
            $produtoId,
            $dados['tamanho'],
            $quantidade
        );

        return redirect()->route('carrinho.ver')->with('success', 'Produto adicionado ao carrinho!');
    }

    /**
     * Visualiza o carrinho do usuário.
     *
     * @return \Illuminate\View\View
     */
    public function verCarrinho()
    {
        $usuario = Auth::guard('usuarios')->user();

        $carrinho = $usuario->carrinhoAtivo ?? Carrinho::create([
            'id_usuarios' => $usuario->id_usuarios,
            'status' => 'ativo',
        ]);

        // Carrega itens e produtos relacionados de forma otimizada
        $carrinho->load(['itens.produto' => fn($q) => $q->select('id_produtos', 'preco', 'nome', 'slug', 'fotos')]);

        $enderecos = EnderecoUsuario::where('id_usuarios', $usuario->id_usuarios)->get();

        // Calcula total usando o service
        $totais = $this->carrinhoService->calcularTotal($carrinho);

        $cupons = Cupom::where('ativo', 1)
            ->where(fn($q) => $q->whereNull('validade')->orWhere('validade', '>=', now()))
            ->get();

        $cupomAplicado = session('cupom_aplicado');

        $produtos = ProdutoFornecedor::ativos()
            ->with(['fornecedor:id_fornecedores,nome_empresa,foto'])
            ->inRandomOrder()
            ->take(4)
            ->get(['id_produtos', 'nome', 'slug', 'fotos', 'preco', 'id_fornecedores']);

        // Manter compatibilidade com views que esperam 'total'
        $total = $totais['total'];

        return view('usuarios.carrinho', compact(
            'carrinho',
            'total',
            'totais',
            'enderecos',
            'cupons',
            'cupomAplicado',
            'produtos'
        ));
    }

    /**
     * Remove um produto do carrinho.
     *
     * @param int $produtoId ID do produto
     * @param string $tamanho Tamanho do produto
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Exibe a página de finalização de compra.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function finalizarCompra()
    {
        $usuario = Auth::guard('usuarios')->user();
        $enderecos = EnderecoUsuario::where('id_usuarios', $usuario->id_usuarios)->get();

        $carrinho = Carrinho::where('id_usuarios', $usuario->id_usuarios)
            ->where('status', 'ativo')
            ->with(['itens.produto' => fn($q) => $q->ativos()->select('id_produtos', 'preco', 'nome')])
            ->first();

        if (!$carrinho || $carrinho->itens->isEmpty()) {
            return redirect()->route('carrinho.ver')->with('error', 'Você precisa ter pelo menos 1 produto no carrinho.');
        }

        $cupons = Cupom::where('ativo', 1)
            ->where(fn($q) => $q->whereNull('validade')->orWhere('validade', '>=', now()))
            ->get();

        $totais = $this->carrinhoService->calcularTotal($carrinho);
        $cupomAplicado = session('cupom_aplicado');

        return view('usuarios.selecionar_endereco', compact(
            'enderecos',
            'carrinho',
            'cupons',
            'totais',
            'cupomAplicado'
        ));
    }

    /**
     * Processa a finalização da compra.
     * 
     * Validação via ProcessarFinalizacaoRequest.
     * Lógica de negócio delegada ao CarrinhoService.
     *
     * @param ProcessarFinalizacaoRequest $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function processarFinalizacao(ProcessarFinalizacaoRequest $request)
    {
        $usuario = Auth::guard('usuarios')->user();

        $carrinho = Carrinho::where('id_usuarios', $usuario->id_usuarios)
            ->where('status', 'ativo')
            ->with('itens.produto')
            ->first();

        if (!$carrinho || $carrinho->itens->isEmpty()) {
            return redirect()->route('carrinho.ver')->with('error', 'Carrinho vazio.');
        }

        $dados = $this->carrinhoService->finalizarCompra(
            $carrinho,
            $request->validated()['id_endereco'],
            $usuario->email
        );

        $cupomAplicado = session('cupom_aplicado');

        return view('usuarios.pix', [
            'chavePix' => $dados['chavePix'],
            'total' => $dados['total'],
            'enderecoSelecionado' => $dados['endereco'],
            'desconto' => $dados['desconto'],
            'cupomAplicado' => $cupomAplicado
        ]);
    }

    /**
     * Lista os pedidos do usuário.
     *
     * @return \Illuminate\View\View
     */
    public function meusPedidos()
    {
        $usuario = Auth::guard('usuarios')->user();

        $pedidos = Carrinho::where('id_usuarios', $usuario->id_usuarios)
            ->where('status', 'finalizado')
            ->with([
                'itens' => fn($q) => $q->whereHas('produto', fn($q2) => $q2->ativos())->with('produto:id_produtos,nome,preco'),
                'endereco'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('usuarios.pedidos', compact('pedidos'));
    }

    /**
     * Exibe os detalhes de um pedido específico.
     *
     * @param int $pedidoId ID do pedido
     * @return \Illuminate\View\View
     */
    public function detalhePedido($pedidoId)
    {
        $usuario = Auth::guard('usuarios')->user();

        $pedido = Carrinho::where('id_usuarios', $usuario->id_usuarios)
            ->where('status', 'finalizado')
            ->with('itens.produto:id_produtos,nome,preco', 'endereco')
            ->findOrFail($pedidoId);

        $cupomAplicado = $pedido->cupom_aplicado ?? null;

        return view('usuarios.pedido_detalhe', compact('pedido', 'cupomAplicado'));
    }

    /**
     * Aplica um cupom ao carrinho.
     * 
     * Lógica de negócio delegada ao CarrinhoService.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function aplicarCupom(Request $request)
    {
        $request->validate([
            'codigo_cupom' => 'required|string'
        ]);

        $resultado = $this->carrinhoService->aplicarCupom($request->codigo_cupom);

        if ($resultado['success']) {
            return back()->with('success', $resultado['message']);
        }

        return back()->with('error', $resultado['message']);
    }
}
