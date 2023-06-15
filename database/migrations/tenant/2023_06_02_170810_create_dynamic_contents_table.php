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
        Schema::create('dynamic_contents', function (Blueprint $table) {
            $table->uuid('id')->index()->unique();
            $table->uuid('organization_id')->index()->nullable(); // TODO: colocar FK da organização aqui (nova mig?)
            $table->string('slug')->index();
            $table->string('title')->index();
            $table->string('cover_image')->nullable();
            $table->string('small_description')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('active')->index()->default(false);
            $table->longText('css_code')->nullable();
            $table->longText('js_code')->nullable();
            $table->longText('html_code')->nullable();
            $table->datetime('show_from')->index()->nullable();
            $table->datetime('show_to')->index()->nullable();
            $table->json('search_tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_contents');
    }
};
