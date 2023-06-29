<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->uuid('id')->index()->unique();
            $table->timestamps();
            $table->integer('tipo')->index(); // App\Enums\OrcamentoTipoEnum
            $table->integer('ano_vigencia_inicio')->index();
            $table->integer('ano_vigencia_fim')->nullable()->index();
            $table->boolean('ative')->index()->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};
