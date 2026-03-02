<?php

namespace App\Http\Requests\Carrinho;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProcessarFinalizacaoRequest extends FormRequest
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
     * Regras de validação para finalizar compra.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_endereco' => 'required|exists:endereco_usuarios,id_endereco',
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
            'id_endereco.required' => 'Você precisa selecionar um endereço para finalizar a compra.',
            'id_endereco.exists' => 'O endereço selecionado não existe.',
        ];
    }
}



