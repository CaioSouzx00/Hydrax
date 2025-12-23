<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEmailRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::guard('usuarios')->check();
    }

    /**
     * Regras de validação para troca de e-mail.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'novo_email' => 'required|email|unique:usuarios,email|unique:pending_email_changes,novo_email',
        ];
    }

    /**
     * Mensagens de erro personalizadas.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'novo_email.required' => 'O novo e-mail é obrigatório.',
            'novo_email.email' => 'O e-mail deve ser um endereço válido.',
            'novo_email.unique' => 'Este e-mail já está em uso ou já existe uma solicitação pendente para ele.',
        ];
    }
}



