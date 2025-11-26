<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioPadraoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('usuarios')->insert([
            'nome_completo' => 'Usuário Padrão',
            'sexo' => 'M',
            'data_nascimento' => '2000-01-01',
            'email' => 'user@teste.com',
            'password' => Hash::make('123456'),
            'telefone' => '0000000000',
            'cpf' => '00000000000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
