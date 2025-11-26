<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministradorPadraoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('administradores')->insert([
            'nome_usuario' => 'admin',
            'password' => Hash::make('123456'), // senha padrão
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
