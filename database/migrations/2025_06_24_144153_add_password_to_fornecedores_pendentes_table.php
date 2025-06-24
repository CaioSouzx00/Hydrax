<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fornecedores_pendentes', function (Blueprint $table) {
            $table->string('password');
        });
    }

    public function down(): void
    {
        Schema::table('fornecedores_pendentes', function (Blueprint $table) {
            $table->dropColumn('password');
        });
    }
};
