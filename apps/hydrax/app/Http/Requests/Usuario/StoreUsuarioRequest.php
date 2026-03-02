<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
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
     * Regras de validação para o cadastro de usuário.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sexo'            => 'required|string|in:masculino,feminino,M,F',
            'nome_completo'   => 'required|string|max:50',
            'data_nascimento' => 'required|date|before:today',
            'email'           => 'required|email|unique:usuarios,email',
            'password'        => 'required|string|min:6',
            'telefone'        => 'required|string|max:20',
            'cpf'             => ['required', 'regex:/^\d{11}$/', 'unique:usuarios,cpf'],
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
            'sexo.in' => 'O sexo deve ser masculino ou feminino.',
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'nome_completo.max' => 'O nome completo não pode ter mais de 50 caracteres.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'telefone.required' => 'O telefone é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.regex' => 'O CPF deve conter exatamente 11 dígitos numéricos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'foto.image' => 'O arquivo deve ser uma imagem.',
            'foto.mimes' => 'A imagem deve ser jpg, jpeg ou png.',
            'foto.max' => 'A imagem não pode ter mais de 2MB.',
        ];
    }

    /**
     * Preparar dados para validação.
     * Normaliza o campo sexo antes da validação.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('sexo')) {
            $sexo = strtolower($this->input('sexo'));
            $sexoNormalizado = match($sexo) {
                'masculino', 'm' => 'M',
                'feminino', 'f' => 'F',
                default => $sexo
            };
            $this->merge(['sexo' => $sexoNormalizado]);
        }
    }
}



