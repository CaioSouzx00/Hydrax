<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('endereco_fornecedores', function (Blueprint $table) {
    $table->id('id_endereco');
    $table->unsignedBigInteger('id_fornecedores');
    $table->foreign('id_fornecedores')->references('id_fornecedores')->on('fornecedores')->onDelete('cascade');
    $table->string('cidade');
    $table->string('rua');
    $table->string('cep');
    $table->string('bairro');
    $table->string('estado');
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('endereco_fornecedores');
    }
};
