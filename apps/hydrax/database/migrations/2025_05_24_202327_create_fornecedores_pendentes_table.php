<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fornecedores_pendentes', function (Blueprint $table) {
            $table->id('id_fornecedores');
            $table->string('nome_empresa')->unique();
            $table->string('cnpj')->unique();
            $table->string('email')->unique();
            $table->string('telefone');
            $table->string('foto')->nullable();
            $table->string('password');
            $table->enum('status', ['PENDENTE', 'REJEITADO'])->default('PENDENTE');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fornecedores_pendentes');
    }
};
