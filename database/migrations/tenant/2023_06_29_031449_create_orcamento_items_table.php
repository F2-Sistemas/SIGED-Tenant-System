<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orcamento_items', function (Blueprint $table) {
            // $table->id();
            $table->uuid('id')->index()->unique();
            $table->timestamps();
            $table->integer('lei_tipo')->index()->nullable(); // enum: municipal|estadual|federal
            $table->string('lei_numero')->index()->nullable();
            $table->datetime('lei_data')->index()->nullable();
            $table->longText('content')->nullable();
            $table->json('aditional_data')->nullable();

            $table->foreignUuid('orcamento_id')
                ->index()
                ->references('id')
                ->on('orcamentos')->onDelete('cascade');

                /*
                Lei n° 422 de 18 de outubro de 2021

                Dispõe sobre a transposição, transferência e
                remanejamento de créditos orçamentários, no âmbito do
                Poder Executivo e Legislativo Municipal, no orçamento
                de 2022 e dá outras providências.

                Publicado no Diário Oficial Edição 157 – Pag 3

                2022 / 2022   |   Documento  |  Anexo
                */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamento_items');
    }
};
