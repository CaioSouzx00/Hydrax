<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FornecedorPadraoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fornecedores')->insert([
            'nome_empresa' => 'Fornecedor Padrão',
            'cnpj' => '00000000000000',
            'telefone' => '0000000000',
            'foto' => null,
            'email' => 'fornecedor@teste.com',
            'status' => 'ATIVO',
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
