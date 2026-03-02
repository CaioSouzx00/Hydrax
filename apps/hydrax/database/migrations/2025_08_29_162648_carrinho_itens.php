<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carrinho_itens', function (Blueprint $table) {
            $table->id(); // id do item do carrinho
            $table->unsignedBigInteger('carrinho_id'); // referencia carrinhos
            $table->unsignedBigInteger('produto_id'); // referencia produtos_fornecedores
            $table->integer('quantidade')->default(1);
            $table->string('tamanho')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('carrinho_id')
                  ->references('id')
                  ->on('carrinhos')
                  ->onDelete('cascade');

            $table->foreign('produto_id')
                  ->references('id_produtos')
                  ->on('produtos_fornecedores')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrinho_itens');
    }
};
