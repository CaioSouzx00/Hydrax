<?php

namespace App\Http\Requests\Fornecedor;

use Illuminate\Foundation\Http\FormRequest;

class StoreFornecedorRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Rota pública de cadastro
    }

    /**
     * Regras de validação para cadastro de fornecedor.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome_empresa' => 'required|string|max:255',
            'cnpj' => 'required|string|min:14|max:18|unique:fornecedores_pendentes,cnpj',
            'email' => 'required|email|unique:fornecedores_pendentes,email',
            'telefone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'nome_empresa.required' => 'O nome da empresa é obrigatório.',
            'nome_empresa.max' => 'O nome da empresa não pode ter mais de 255 caracteres.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.min' => 'O CNPJ deve ter pelo menos 14 caracteres.',
            'cnpj.max' => 'O CNPJ não pode ter mais de 18 caracteres.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
            'foto.image' => 'O arquivo deve ser uma imagem.',
            'foto.mimes' => 'A imagem deve ser jpeg, png, jpg, gif ou svg.',
            'foto.max' => 'A imagem não pode ter mais de 2MB.',
        ];
    }
}



