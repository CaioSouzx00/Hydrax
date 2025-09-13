<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id('id_avaliacoes');
            
            $table->unsignedBigInteger('id_usuarios');
            $table->unsignedBigInteger('id_produtos');

            $table->tinyInteger('nota'); // 1 a 5
            $table->text('comentario')->nullable();

            $table->timestamps();

            // só 1 avaliação por usuário/produto
            $table->unique(['id_usuarios', 'id_produtos']);

            $table->foreign('id_usuarios')
                  ->references('id_usuarios')
                  ->on('usuarios')
                  ->onDelete('cascade');

            $table->foreign('id_produtos')
                  ->references('id_produtos')
                  ->on('produtos_fornecedores')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
