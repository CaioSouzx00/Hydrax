<?php

namespace App\Http\Requests\ProdutoFornecedor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProdutoFornecedorRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::guard('fornecedores')->check();
    }

    /**
     * Regras de validação para criação de produto.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'estoque_imagem.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caracteristicas' => 'required|string',
            'cor' => 'required|string|max:50',
            'historico_modelos' => 'nullable|string',
            'tamanhos_disponiveis' => 'nullable|string',
            'genero' => 'required|in:MASCULINO,FEMININO,UNISSEX',
            'categoria' => 'required|string|max:100',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativo' => 'required|boolean',
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
            'nome.required' => 'O nome do produto é obrigatório.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',
            'descricao.required' => 'A descrição é obrigatória.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um número.',
            'preco.min' => 'O preço não pode ser negativo.',
            'estoque_imagem.*.image' => 'Os arquivos de estoque devem ser imagens.',
            'estoque_imagem.*.mimes' => 'As imagens de estoque devem ser jpeg, png, jpg ou gif.',
            'estoque_imagem.*.max' => 'Cada imagem de estoque não pode ter mais de 2MB.',
            'caracteristicas.required' => 'As características são obrigatórias.',
            'cor.required' => 'A cor é obrigatória.',
            'cor.max' => 'A cor não pode ter mais de 50 caracteres.',
            'genero.required' => 'O gênero é obrigatório.',
            'genero.in' => 'O gênero deve ser MASCULINO, FEMININO ou UNISSEX.',
            'categoria.required' => 'A categoria é obrigatória.',
            'categoria.max' => 'A categoria não pode ter mais de 100 caracteres.',
            'fotos.*.image' => 'Os arquivos devem ser imagens.',
            'fotos.*.mimes' => 'As imagens devem ser jpeg, png, jpg ou gif.',
            'fotos.*.max' => 'Cada imagem não pode ter mais de 2MB.',
            'ativo.required' => 'O status ativo é obrigatório.',
            'ativo.boolean' => 'O status ativo deve ser verdadeiro ou falso.',
        ];
    }
}



