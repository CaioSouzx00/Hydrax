<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('produtos_fornecedores', function (Blueprint $table) {
    $table->id('id_produtos');
    $table->string('nome');
    $table->text('descricao');
    $table->float('preco', 8, 2);
    $table->text('estoque_imagem')->nullable();
    $table->text('caracteristicas');
    $table->string('cor', 50);
    $table->text('historico_modelos')->nullable();
    $table->json('tamanhos_disponiveis')->nullable();
    $table->enum('genero', ['MASCULINO', 'FEMININO', 'UNISSEX']);
    $table->string('categoria');
    $table->json('fotos')->nullable();

    $table->unsignedBigInteger('id_fornecedores');
    $table->foreign('id_fornecedores')->references('id_fornecedores')->on('fornecedores')->onDelete('cascade');

    $table->string('slug')->unique();
    $table->boolean('ativo')->default(true);
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('produtos_fornecedores');
    }
};
