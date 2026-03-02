<?php

namespace App\Http\Requests\Carrinho;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdicionarProdutoRequest extends FormRequest
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
     * Regras de validação para adicionar produto ao carrinho.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tamanho' => 'required|string|max:10',
            'quantidade' => 'nullable|integer|min:1|max:99',
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
            'tamanho.required' => 'O tamanho é obrigatório.',
            'tamanho.max' => 'O tamanho não pode ter mais de 10 caracteres.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade mínima é 1.',
            'quantidade.max' => 'A quantidade máxima é 99.',
        ];
    }
}



