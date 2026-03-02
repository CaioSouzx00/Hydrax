<?php

namespace App\Http\Requests\Cupom;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCupomRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     * Apenas administradores podem criar cupons.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Regras de validação para criação de cupom.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo' => 'required|string|max:50|unique:cupons,codigo',
            'tipo' => 'required|in:percentual,valor',
            'valor' => 'required|numeric|min:0.01',
            'validade' => 'nullable|date|after_or_equal:today',
            'uso_maximo' => 'nullable|integer|min:1',
            'ativo' => 'nullable|boolean',
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
            'codigo.required' => 'O código do cupom é obrigatório.',
            'codigo.max' => 'O código não pode ter mais de 50 caracteres.',
            'codigo.unique' => 'Este código de cupom já existe.',
            'tipo.required' => 'O tipo do cupom é obrigatório.',
            'tipo.in' => 'O tipo deve ser percentual ou valor.',
            'valor.required' => 'O valor do cupom é obrigatório.',
            'valor.numeric' => 'O valor deve ser um número.',
            'valor.min' => 'O valor mínimo é 0.01.',
            'validade.date' => 'A validade deve ser uma data válida.',
            'validade.after_or_equal' => 'A validade deve ser hoje ou uma data futura.',
            'uso_maximo.integer' => 'O uso máximo deve ser um número inteiro.',
            'uso_maximo.min' => 'O uso máximo deve ser pelo menos 1.',
            'ativo.boolean' => 'O status ativo deve ser verdadeiro ou falso.',
        ];
    }
}



