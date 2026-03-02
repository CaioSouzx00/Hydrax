<?php

namespace App\Http\Requests\Endereco;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEnderecoRequest extends FormRequest
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
     * Regras de validação para criação de endereço.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cidade' => 'required|string|max:60',
            'cep' => 'required|string|max:10',
            'bairro' => 'required|string|max:60',
            'estado' => 'required|string|size:2',
            'rua' => 'required|string|max:60',
            'numero' => 'required|string|max:10',
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
            'cidade.required' => 'A cidade é obrigatória.',
            'cidade.max' => 'A cidade não pode ter mais de 60 caracteres.',
            'cep.required' => 'O CEP é obrigatório.',
            'cep.max' => 'O CEP não pode ter mais de 10 caracteres.',
            'bairro.required' => 'O bairro é obrigatório.',
            'bairro.max' => 'O bairro não pode ter mais de 60 caracteres.',
            'estado.required' => 'O estado é obrigatório.',
            'estado.size' => 'O estado deve ter exatamente 2 caracteres.',
            'rua.required' => 'A rua é obrigatória.',
            'rua.max' => 'A rua não pode ter mais de 60 caracteres.',
            'numero.required' => 'O número é obrigatório.',
            'numero.max' => 'O número não pode ter mais de 10 caracteres.',
        ];
    }
}



