<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CompletarCadastroRequest extends FormRequest
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
     * Regras de validação para completar cadastro.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $usuarioId = Auth::guard('usuarios')->id();

        return [
            'sexo' => 'required|in:M,F,O',
            'cpf' => 'required|digits:11|unique:usuarios,cpf,' . $usuarioId . ',id_usuarios',
            'data_nascimento' => 'required|date|before:today',
            'telefone' => 'required|string|max:20',
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
            'sexo.required' => 'O campo sexo é obrigatório.',
            'sexo.in' => 'O sexo deve ser M, F ou O.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.digits' => 'O CPF deve conter exatamente 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'telefone.required' => 'O telefone é obrigatório.',
        ];
    }
}



