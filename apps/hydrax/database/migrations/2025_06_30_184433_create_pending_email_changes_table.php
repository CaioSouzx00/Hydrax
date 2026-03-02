<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingEmailChangesTable extends Migration
{
    public function up()
    {
        Schema::create('pending_email_changes', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('usuario_id');

    $table->string('novo_email')->unique();
    $table->string('token')->unique();
    $table->timestamps();

    // Aqui referencia a coluna id_usuarios, que é sua PK personalizada
    $table->foreign('usuario_id')->references('id_usuarios')->on('usuarios')->onDelete('cascade');
});

    }

    public function down()
    {
        Schema::dropIfExists('pending_email_changes');
    }
}