<?php

namespace App\Services\Usuario;

use App\Models\Usuario;
use App\Models\PendingEmailChange;
use Illuminate\Support\Facades\Hash;
use App\Services\Novu\NovuService;
use Illuminate\Support\Str;

/**
 * Service responsável pela lógica de negócio relacionada a usuários.
 * 
 * Segue o princípio Single Responsibility (SRP) do SOLID,
 * extraindo toda a lógica de negócio dos controllers.
 */
class UsuarioService
{
    protected NovuService $novuService;

    public function __construct(NovuService $novuService)
    {
        $this->novuService = $novuService;
    }

    /**
     * Cria um novo usuário no sistema.
     *
     * @param array $dados Dados validados do usuário
     * @return Usuario
     */
    public function criarUsuario(array $dados): Usuario
    {
        // Hash da senha
        if (isset($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        }

        // Processar foto se existir (pode ser um arquivo UploadedFile)
        if (isset($dados['foto']) && is_object($dados['foto']) && method_exists($dados['foto'], 'store')) {
            $dados['foto'] = $dados['foto']->store('fotos_usuario_final', 'public');
        }

        return Usuario::create($dados);
    }

    /**
     * Atualiza o perfil do usuário.
     *
     * @param Usuario $usuario
     * @param array $dados Dados validados
     * @return bool
     */
    public function atualizarPerfil(Usuario $usuario, array $dados): bool
    {
        return $usuario->update($dados);
    }

    /**
     * Processa a solicitação de troca de e-mail.
     *
     * @param Usuario $usuario
     * @param string $novoEmail
     * @return void
     */
    public function solicitarTrocaEmail(Usuario $usuario, string $novoEmail): void
    {
        $token = bin2hex(random_bytes(30));

        PendingEmailChange::create([
            'usuario_id' => $usuario->id_usuarios,
            'novo_email' => $novoEmail,
            'token' => $token,
        ]);

        // Enviar email para o e-mail atual (não para o novo) usando Novu
        $link = url("/usuarios/email/confirmar/{$token}");
        $this->novuService->sendEmailChangeConfirmation(
            subscriberId: (string)$usuario->id_usuarios,
            email: $usuario->email,
            userName: $usuario->nome_completo ?? $usuario->nome,
            token: $token,
            confirmationLink: $link
        );
    }

    /**
     * Confirma a troca de e-mail usando o token.
     *
     * @param string $token Token de confirmação
     * @return bool True se a troca foi bem-sucedida, False caso contrário
     */
    public function confirmarTrocaEmail(string $token): bool
    {
        $pending = PendingEmailChange::where('token', $token)->first();

        if (!$pending) {
            return false;
        }

        $usuario = Usuario::find($pending->usuario_id);

        if (!$usuario) {
            return false;
        }

        // Atualiza e-mail do usuário
        $usuario->email = $pending->novo_email;
        $usuario->save();

        // Remove registro pendente
        $pending->delete();

        return true;
    }

    /**
     * Completa o cadastro do usuário com dados adicionais.
     *
     * @param Usuario $usuario
     * @param array $dados Dados validados
     * @return bool
     */
    public function completarCadastro(Usuario $usuario, array $dados): bool
    {
        return $usuario->update($dados);
    }
}

