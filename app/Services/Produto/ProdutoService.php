<?php

namespace App\Services\Produto;

use App\Models\ProdutoFornecedor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * Service responsável pela lógica de negócio relacionada a produtos.
 * 
 * Centraliza operações de criação, atualização e exclusão de produtos,
 * incluindo tratamento de imagens e geração de slugs.
 */
class ProdutoService
{
    /**
     * Cria um novo produto.
     *
     * @param array $dados Dados validados do produto
     * @param int $fornecedorId ID do fornecedor
     * @return ProdutoFornecedor
     */
    public function criarProduto(array $dados, int $fornecedorId): ProdutoFornecedor
    {
        // Processar imagens de estoque
        if (isset($dados['estoque_imagem']) && is_array($dados['estoque_imagem'])) {
            $imagensEstoque = [];
            foreach ($dados['estoque_imagem'] as $file) {
                if (is_object($file) && method_exists($file, 'store')) {
                    $imagensEstoque[] = $file->store('produtos/estoque', 'public');
                }
            }
            $dados['estoque_imagem'] = !empty($imagensEstoque) ? json_encode($imagensEstoque) : null;
        }

        // Processar imagens principais
        if (isset($dados['fotos']) && is_array($dados['fotos'])) {
            $imagens = [];
            foreach ($dados['fotos'] as $file) {
                if (is_object($file) && method_exists($file, 'store')) {
                    $imagens[] = $file->store('produtos', 'public');
                }
            }
            $dados['fotos'] = !empty($imagens) ? json_encode($imagens) : null;
        }

        // Processar tamanhos disponíveis
        if (isset($dados['tamanhos_disponiveis']) && is_string($dados['tamanhos_disponiveis'])) {
            $dados['tamanhos_disponiveis'] = array_map('trim', explode(',', $dados['tamanhos_disponiveis']));
        }

        // Gerar slug único
        $dados['slug'] = Str::slug($dados['nome']) . '-' . uniqid();
        $dados['id_fornecedores'] = $fornecedorId;

        return ProdutoFornecedor::create($dados);
    }

    /**
     * Atualiza um produto existente.
     *
     * @param ProdutoFornecedor $produto
     * @param array $dados Dados validados
     * @return bool
     */
    public function atualizarProduto(ProdutoFornecedor $produto, array $dados): bool
    {
        // Processar tamanhos disponíveis
        if (isset($dados['tamanhos_disponiveis']) && is_string($dados['tamanhos_disponiveis'])) {
            $dados['tamanhos_disponiveis'] = array_map('trim', explode(',', $dados['tamanhos_disponiveis']));
        }

        // Atualizar fotos se enviadas
        if (isset($dados['fotos']) && is_array($dados['fotos'])) {
            $fotosPaths = [];
            foreach ($dados['fotos'] as $foto) {
                if (is_object($foto) && method_exists($foto, 'store')) {
                    $fotosPaths[] = $foto->store('produtos', 'public');
                }
            }
            if (!empty($fotosPaths)) {
                $dados['fotos'] = json_encode($fotosPaths);
            }
        }

        // Atualizar estoque_imagem se enviado
        if (isset($dados['estoque_imagem']) && is_array($dados['estoque_imagem'])) {
            $estoquePaths = [];
            foreach ($dados['estoque_imagem'] as $img) {
                if (is_object($img) && method_exists($img, 'store')) {
                    $estoquePaths[] = $img->store('produtos/estoque', 'public');
                }
            }
            if (!empty($estoquePaths)) {
                $dados['estoque_imagem'] = json_encode($estoquePaths);
            }
        }

        // Atualizar slug somente se o nome mudou
        if (isset($dados['nome']) && $produto->nome !== $dados['nome']) {
            $dados['slug'] = Str::slug($dados['nome']) . '-' . uniqid();
        }

        return $produto->update($dados);
    }

    /**
     * Exclui um produto e suas imagens associadas.
     *
     * @param ProdutoFornecedor $produto
     * @return bool
     */
    public function excluirProduto(ProdutoFornecedor $produto): bool
    {
        // Excluir fotos
        if (!empty($produto->fotos)) {
            $fotos = json_decode($produto->fotos, true);
            if (is_array($fotos)) {
                foreach ($fotos as $foto) {
                    Storage::disk('public')->delete($foto);
                }
            }
        }

        // Excluir imagens de estoque
        if (!empty($produto->estoque_imagem)) {
            $estoqueImgs = json_decode($produto->estoque_imagem, true);
            if (is_array($estoqueImgs)) {
                foreach ($estoqueImgs as $img) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        return $produto->delete();
    }

    /**
     * Alterna o status ativo/inativo de um produto.
     *
     * @param ProdutoFornecedor $produto
     * @return bool
     */
    public function toggleStatus(ProdutoFornecedor $produto): bool
    {
        $produto->ativo = !$produto->ativo;
        return $produto->save();
    }
}

