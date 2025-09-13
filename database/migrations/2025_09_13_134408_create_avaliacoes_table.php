<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id('id_avaliacoes');
            
            $table->unsignedBigInteger('id_usuarios');
            $table->unsignedBigInteger('id_produtos');

            $table->tinyInteger('nota'); // 1 a 5
            $table->text('comentario')->nullable();

            // Novos campos da avaliação da Adidas
            $table->tinyInteger('conforto')->nullable();
            $table->tinyInteger('qualidade')->nullable();
            $table->tinyInteger('tamanho')->nullable();
            $table->tinyInteger('largura')->nullable();
            
            $table->timestamps();

            // Garante que só há 1 avaliação por usuário/produto
            $table->unique(['id_usuarios', 'id_produtos']);

            // Chaves estrangeiras
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};