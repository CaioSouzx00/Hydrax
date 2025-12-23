<?php

namespace App\Services\Carrinho;

use App\Models\Carrinho;
use App\Models\CarrinhoItem;
use App\Models\ProdutoFornecedor;
use App\Models\EnderecoUsuario;
use App\Models\Cupom;
use App\Jobs\EnviarCarrinhoAbandonadoJob;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChavePixMail;

/**
 * Service responsável pela lógica de negócio relacionada ao carrinho de compras.
 * 
 * Centraliza operações de adicionar produtos, calcular totais,
 * aplicar cupons e finalizar compras.
 */
class CarrinhoService
{
    /**
     * Adiciona um produto ao carrinho do usuário.
     *
     * @param int $usuarioId ID do usuário
     * @param int $produtoId ID do produto
     * @param string $tamanho Tamanho do produto
     * @param int $quantidade Quantidade (padrão: 1)
     * @return Carrinho
     */
    public function adicionarProduto(int $usuarioId, int $produtoId, string $tamanho, int $quantidade = 1): Carrinho
    {
        // Buscar ou criar carrinho ativo
        $carrinho = Carrinho::firstOrCreate(
            [
                'id_usuarios' => $usuarioId,
                'status' => 'ativo'
            ],
            [
                'id_usuarios' => $usuarioId,
                'status' => 'ativo'
            ]
        );

        // Verificar se o item já existe
        $item = CarrinhoItem::where('carrinho_id', $carrinho->id)
            ->where('produto_id', $produtoId)
            ->where('tamanho', $tamanho)
            ->first();

        if ($item) {
            // Incrementar quantidade
            $item->increment('quantidade', $quantidade);
        } else {
            // Criar novo item
            CarrinhoItem::create([
                'carrinho_id' => $carrinho->id,
                'produto_id' => $produtoId,
                'tamanho' => $tamanho,
                'quantidade' => $quantidade,
            ]);
        }

        // Agendar job de carrinho abandonado
        EnviarCarrinhoAbandonadoJob::dispatch($carrinho->id)->delay(now()->addMinutes(1));

        return $carrinho->fresh(['itens.produto']);
    }

    /**
     * Calcula o total do carrinho.
     *
     * @param Carrinho $carrinho
     * @param float $taxaEntrega Taxa de entrega (padrão: 15.00)
     * @return array ['subtotal', 'entrega', 'desconto', 'total']
     */
    public function calcularTotal(Carrinho $carrinho, float $taxaEntrega = 15.00): array
    {
        $subtotal = $carrinho->itens->sum(function ($item) {
            return $item->produto->preco * $item->quantidade;
        });

        $cupomAplicado = session('cupom_aplicado');
        $desconto = 0;

        if ($cupomAplicado) {
            $totalComEntrega = $subtotal + $taxaEntrega;
            $desconto = $cupomAplicado['tipo'] === 'percentual'
                ? $totalComEntrega * ($cupomAplicado['valor'] / 100)
                : min($cupomAplicado['valor'], $totalComEntrega);
        }

        $total = $subtotal + $taxaEntrega - $desconto;

        return [
            'subtotal' => $subtotal,
            'entrega' => $taxaEntrega,
            'desconto' => $desconto,
            'total' => $total,
        ];
    }

    /**
     * Finaliza a compra do carrinho.
     *
     * @param Carrinho $carrinho
     * @param int $enderecoId ID do endereço de entrega
     * @param string $emailUsuario E-mail do usuário
     * @return array ['chavePix', 'total', 'endereco']
     */
    public function finalizarCompra(Carrinho $carrinho, int $enderecoId, string $emailUsuario): array
    {
        $endereco = EnderecoUsuario::findOrFail($enderecoId);
        
        $totais = $this->calcularTotal($carrinho);
        
        // Atualizar carrinho
        $carrinho->id_endereco = $enderecoId;
        $carrinho->status = 'finalizado';
        $carrinho->save();

        // Gerar chave PIX
        $chavePix = 'hydrax-pix-' . strtoupper(Str::random(10));

        // Enviar e-mail com chave PIX
        Mail::to($emailUsuario)->send(new ChavePixMail($chavePix, $totais['total']));

        // Criar novo carrinho ativo
        Carrinho::create([
            'id_usuarios' => $carrinho->id_usuarios,
            'status' => 'ativo'
        ]);

        // Limpar cupom da sessão
        session()->forget('cupom_aplicado');

        return [
            'chavePix' => $chavePix,
            'total' => $totais['total'],
            'desconto' => $totais['desconto'],
            'endereco' => $endereco,
        ];
    }

    /**
     * Aplica um cupom ao carrinho.
     *
     * @param string $codigoCupom Código do cupom
     * @return array ['success' => bool, 'message' => string]
     */
    public function aplicarCupom(string $codigoCupom): array
    {
        $cupom = Cupom::where('codigo', $codigoCupom)
            ->where('ativo', 1)
            ->where(function ($q) {
                $q->whereNull('validade')
                  ->orWhere('validade', '>=', now());
            })
            ->first();

        if (!$cupom) {
            return [
                'success' => false,
                'message' => 'Cupom inválido ou expirado.'
            ];
        }

        session(['cupom_aplicado' => [
            'codigo' => $cupom->codigo,
            'tipo' => $cupom->tipo,
            'valor' => $cupom->valor
        ]]);

        return [
            'success' => true,
            'message' => 'Cupom aplicado com sucesso!'
        ];
    }
}



