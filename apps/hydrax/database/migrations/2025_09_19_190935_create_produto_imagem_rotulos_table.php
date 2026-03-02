<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produto_imagem_rotulos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_produto');
            $table->string('imagem'); // nome do arquivo da imagem
            $table->string('categoria'); // basquete, lifestyle, vôlei
            $table->string('estilo'); // casual, agressivo
            $table->enum('genero', ['MASCULINO', 'FEMININO', 'UNISSEX']);
            $table->string('marca'); // Nike, Adidas, Puma
            $table->timestamps();

            $table->foreign('id_produto')
                  ->references('id_produtos')
                  ->on('produtos_fornecedores')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produto_imagem_rotulos');
    }
};
