<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            'Nike',
            'Adidas',
            'Puma',
            'New Balance',
            'Mizuno',
            'Asics',
            'Converse',
            'Vans',
            'Reebok',
            'Fila',
        ];

        $now = now();

        $payload = array_map(function (string $nome) use ($now) {
            return [
                'nome' => $nome,
                'slug' => Str::slug($nome),
                'ativo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $marcas);

        DB::table('marcas')->upsert($payload, ['nome'], ['slug', 'ativo', 'updated_at']);
    }
}
