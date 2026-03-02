<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carrinhos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuarios')
      ->constrained('usuarios', 'id_usuarios') // especifica a coluna exata
      ->onDelete('cascade');
            $table->enum('status', ['ativo', 'finalizado'])->default('ativo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrinhos');
    }
};
