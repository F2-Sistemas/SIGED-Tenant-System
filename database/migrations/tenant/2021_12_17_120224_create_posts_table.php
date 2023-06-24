<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            // $table->id();
            $table->uuid('id')->index()->unique();
            $table->string('title');
            $table->string('slug')->index()->unique();
            $table->longText('content')->nullable();
            $table->timestamp('published_at')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
