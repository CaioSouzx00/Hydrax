<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produto_estoques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->string('tamanho');
            $table->unsignedInteger('quantidade')->default(0);
            $table->timestamps();

            $table->unique(['produto_id', 'tamanho']);

            $table->foreign('produto_id')
                ->references('id_produtos')
                ->on('produtos_fornecedores')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produto_estoques');
    }
};
