<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('endereco_id')->nullable();

            $table->enum('status', ['finalizado', 'criado', 'aguardando_pagamento', 'pago', 'enviado', 'entregue', 'cancelado', 'reembolsado'])->default('finalizado');

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('taxa_entrega', 10, 2)->default(0);
            $table->decimal('desconto', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->string('chave_pix')->nullable()->unique();
            $table->json('cupom_aplicado')->nullable();

            $table->timestamps();

            $table->foreign('usuario_id')
                ->references('id_usuarios')
                ->on('usuarios')
                ->onDelete('cascade');

            $table->foreign('endereco_id')
                ->references('id_endereco')
                ->on('endereco_usuarios')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
