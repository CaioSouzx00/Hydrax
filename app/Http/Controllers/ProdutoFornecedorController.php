<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoFornecedor\StoreProdutoFornecedorRequest;
use App\Http\Requests\ProdutoFornecedor\UpdateProdutoFornecedorRequest;
use App\Services\Produto\ProdutoService;
use App\Models\ProdutoFornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsável pelas operações relacionadas a produtos do fornecedor.
 * 
 * Refatorado seguindo Clean Code e SOLID:
 * - Validações movidas para Form Requests
 * - Lógica de negócio extraída para ProdutoService
 * - Controller mantém apenas orquestração e respostas HTTP
 */
class ProdutoFornecedorController extends Controller
{
    /**
     * Service de produto injetado via construtor.
     *
     * @var ProdutoService
     */
    protected ProdutoService $produtoService;

    /**
     * Construtor com injeção de dependência do Service.
     *
     * @param ProdutoService $produtoService
     */
    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    /**
     * Exibe o formulário de criação de produto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('fornecedores.produtos.partials.create');
    }

    /**
     * Armazena um novo produto.
     * 
     * Validação via StoreProdutoFornecedorRequest.
     * Lógica de negócio delegada ao ProdutoService.
     *
     * @param StoreProdutoFornecedorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProdutoFornecedorRequest $request)
    {
        $fornecedor = Auth::guard('fornecedores')->user();
        $dados = $request->validated();

        // Incluir arquivos de imagem se existirem
        if ($request->hasFile('fotos')) {
            $dados['fotos'] = $request->file('fotos');
        }

        if ($request->hasFile('estoque_imagem')) {
            $dados['estoque_imagem'] = $request->file('estoque_imagem');
        }

        $this->produtoService->criarProduto($dados, $fornecedor->id_fornecedores);

        return redirect()->route('fornecedores.produtos.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    /**
     * Atualiza um produto existente.
     * 
     * Validação via UpdateProdutoFornecedorRequest.
     * Lógica de negócio delegada ao ProdutoService.
     *
     * @param UpdateProdutoFornecedorRequest $request
     * @param int $id ID do produto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProdutoFornecedorRequest $request, $id)
    {
        $produto = ProdutoFornecedor::findOrFail($id);
        $dados = $request->validated();

        // Incluir arquivos de imagem se existirem
        if ($request->hasFile('fotos')) {
            $dados['fotos'] = $request->file('fotos');
        }

        if ($request->hasFile('estoque_imagem')) {
            $dados['estoque_imagem'] = $request->file('estoque_imagem');
        }

        $this->produtoService->atualizarProduto($produto, $dados);

        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Lista todos os produtos do fornecedor logado.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $fornecedor = Auth::guard('fornecedores')->user();

        $produtos = ProdutoFornecedor::with('rotulos')
            ->where('id_fornecedores', $fornecedor->id_fornecedores)
            ->get();

        return view('fornecedores.produtos.index', compact('produtos'));
    }

    /**
     * Lista produtos em formato JSON para AJAX.
     *
     * @return \Illuminate\View\View
     */
    public function listar()
    {
        $fornecedor = Auth::guard('fornecedores')->user();

        $produtos = ProdutoFornecedor::where('id_fornecedores', $fornecedor->id_fornecedores)->get();

        // Decodificar JSONs para exibição
        foreach ($produtos as $produto) {
            $produto->tamanhos_disponiveis = is_array($produto->tamanhos_disponiveis)
                ? $produto->tamanhos_disponiveis
                : json_decode($produto->tamanhos_disponiveis ?? '[]', true);

            $produto->fotos = is_array($produto->fotos)
                ? $produto->fotos
                : json_decode($produto->fotos ?? '[]', true);

            $produto->estoque_imagem = is_array($produto->estoque_imagem)
                ? $produto->estoque_imagem
                : json_decode($produto->estoque_imagem ?? '[]', true);
        }

        return view('fornecedores.produtos.partials.listar', compact('produtos'));
    }

    /**
     * Exibe o formulário de edição de produto.
     *
     * @param int $id ID do produto
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $produto = ProdutoFornecedor::findOrFail($id);

        // Decodificar JSON antes de mandar para a view
        $produto->tamanhos_disponiveis = is_array($produto->tamanhos_disponiveis)
            ? $produto->tamanhos_disponiveis
            : json_decode($produto->tamanhos_disponiveis ?? '[]', true);

        $produto->fotos = is_array($produto->fotos)
            ? $produto->fotos
            : json_decode($produto->fotos ?? '[]', true);

        $produto->estoque_imagem = is_array($produto->estoque_imagem)
            ? $produto->estoque_imagem
            : json_decode($produto->estoque_imagem ?? '[]', true);

        return view('fornecedores.produtos.partials.edit', compact('produto'));
    }

    /**
     * Exclui um produto.
     * 
     * Lógica de negócio delegada ao ProdutoService.
     *
     * @param int $id ID do produto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $produto = ProdutoFornecedor::findOrFail($id);
        $this->produtoService->excluirProduto($produto);

        return redirect()->back()->with('success', 'Produto excluído com sucesso!');
    }

    /**
     * Alterna o status ativo/inativo de um produto.
     * 
     * Lógica de negócio delegada ao ProdutoService.
     *
     * @param int $id ID do produto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleProduto($id)
    {
        $produto = ProdutoFornecedor::findOrFail($id);
        $this->produtoService->toggleStatus($produto);

        $statusTexto = $produto->ativo ? 'ATIVO' : 'INATIVO';

        return redirect()->back()->with('success', "Produto atualizado para {$statusTexto} com sucesso!");
    }
}
