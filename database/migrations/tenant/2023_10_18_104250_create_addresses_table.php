<?php

use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->timestamps();
            $table->uuid('id')->unique()->primary();
            $table->uuid('city_id')->nullable()->index();
            $table->integer('place_type')->nullable()->index();
            $table->string('place')->nullable();
            $table->string('place_number')->nullable();
            $table->string('extra_info_1')->nullable();
            $table->string('extra_info_2')->nullable();

            $table->foreign('city_id')->references('id')
                ->on(
                    get_model_table(City::class),
                )->onDelete('set null'); // cascade|set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
