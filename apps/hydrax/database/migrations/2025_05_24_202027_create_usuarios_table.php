<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuarios');
            $table->string('nome_completo');
            $table->enum('sexo', ['M', 'F', 'O'])->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telefone')->nullable();
            $table->string('cpf')->unique()->nullable();
            $table->string('google_id')->nullable();
            $table->timestamp('data_exclusao_agendada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
