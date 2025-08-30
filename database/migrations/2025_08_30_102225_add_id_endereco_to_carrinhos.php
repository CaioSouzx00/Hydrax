<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('carrinhos', function (Blueprint $table) {
        $table->unsignedBigInteger('id_endereco')->nullable()->after('id_usuarios');
        $table->foreign('id_endereco')->references('id_endereco')->on('endereco_usuarios')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('carrinhos', function (Blueprint $table) {
        $table->dropForeign(['id_endereco']);
        $table->dropColumn('id_endereco');
    });
}

};
