<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('venda_lancamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('fornecedor_id');
            $table->string('tamanho')->nullable();
            $table->unsignedInteger('quantidade');
            $table->decimal('preco_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamp('lancado_em')->useCurrent();
            $table->timestamps();

            $table->index(['fornecedor_id', 'lancado_em']);
            $table->index(['produto_id', 'lancado_em']);

            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('produto_id')->references('id_produtos')->on('produtos_fornecedores')->onDelete('restrict');
            $table->foreign('fornecedor_id')->references('id_fornecedores')->on('fornecedores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venda_lancamentos');
    }
};
