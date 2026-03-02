<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('codigo_rastreio')->nullable()->after('cupom_aplicado');
            $table->string('url_rastreio')->nullable()->after('codigo_rastreio');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['codigo_rastreio', 'url_rastreio']);
        });
    }
};
