<?php

namespace App\Services\Endereco;

use App\Models\EnderecoUsuario;

/**
 * Service responsável pela lógica de negócio relacionada a endereços.
 * 
 * Centraliza validações de negócio e operações de CRUD de endereços.
 */
class EnderecoService
{
    /**
     * Limite máximo de endereços por usuário.
     */
    const LIMITE_ENDERECOS = 3;

    /**
     * Cria um novo endereço para o usuário.
     *
     * @param int $usuarioId ID do usuário
     * @param array $dados Dados validados do endereço
     * @return EnderecoUsuario
     * @throws \Exception Se o limite de endereços foi atingido
     */
    public function criarEndereco(int $usuarioId, array $dados): EnderecoUsuario
    {
        // Verificar limite de endereços
        $quantidadeEnderecos = EnderecoUsuario::where('id_usuarios', $usuarioId)->count();

        if ($quantidadeEnderecos >= self::LIMITE_ENDERECOS) {
            throw new \Exception('Você já cadastrou o número máximo de ' . self::LIMITE_ENDERECOS . ' endereços.');
        }

        // Verificar se o endereço já existe
        $enderecoExistente = EnderecoUsuario::where('id_usuarios', $usuarioId)
            ->where('cidade', $dados['cidade'])
            ->where('cep', $dados['cep'])
            ->where('bairro', $dados['bairro'])
            ->where('estado', $dados['estado'])
            ->where('rua', $dados['rua'])
            ->where('numero', $dados['numero'])
            ->exists();

        if ($enderecoExistente) {
            throw new \Exception('Este endereço já está cadastrado.');
        }

        $endereco = new EnderecoUsuario($dados);
        $endereco->id_usuarios = $usuarioId;
        $endereco->save();

        return $endereco;
    }

    /**
     * Atualiza um endereço existente.
     *
     * @param EnderecoUsuario $endereco
     * @param array $dados Dados validados
     * @return bool
     */
    public function atualizarEndereco(EnderecoUsuario $endereco, array $dados): bool
    {
        return $endereco->update($dados);
    }

    /**
     * Verifica se o endereço pertence ao usuário.
     *
     * @param EnderecoUsuario $endereco
     * @param int $usuarioId ID do usuário
     * @return bool
     */
    public function pertenceAoUsuario(EnderecoUsuario $endereco, int $usuarioId): bool
    {
        return $endereco->id_usuarios === $usuarioId;
    }
}



