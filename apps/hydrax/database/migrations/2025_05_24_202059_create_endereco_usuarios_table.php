<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
      Schema::create('endereco_usuarios', function (Blueprint $table) {
    $table->id('id_endereco');
    $table->unsignedBigInteger('id_usuarios');
    $table->foreign('id_usuarios')->references('id_usuarios')->on('usuarios')->onDelete('cascade');
    $table->string('cidade');
    $table->string('cep');
    $table->string('bairro');
    $table->string('estado');
    $table->string('rua');
    $table->string('numero');
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('endereco_usuarios');
    }
};
