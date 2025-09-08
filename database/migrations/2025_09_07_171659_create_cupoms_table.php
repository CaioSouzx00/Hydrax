<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cupons', function (Blueprint $table) {
            $table->id('id_cupom');                // ID do cupom
            $table->string('codigo')->unique();     // Código do cupom
            $table->enum('tipo', ['percentual', 'valor']); // Tipo de desconto
            $table->decimal('valor', 8, 2);        // Valor do desconto ou percentual
            $table->date('validade')->nullable();  // Validade do cupom
            $table->integer('uso_maximo')->nullable(); // Quantas vezes pode ser usado
            $table->boolean('ativo')->default(true);   // Se o cupom está ativo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cupons');
    }
};
