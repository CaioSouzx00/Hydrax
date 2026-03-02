<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lista_desejos', function (Blueprint $table) {
            $table->id('id_lista');

            // FK usuário
            $table->unsignedBigInteger('id_usuarios');
            $table->foreign('id_usuarios')
                  ->references('id_usuarios')
                  ->on('usuarios')
                  ->onDelete('cascade');

            // FK produto
            $table->unsignedBigInteger('id_produtos');
            $table->foreign('id_produtos')
                  ->references('id_produtos')
                  ->on('produtos_fornecedores')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lista_desejos');
    }
};
