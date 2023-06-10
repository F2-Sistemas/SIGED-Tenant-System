<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('product_id')->index();
            $table->longText('description')->nullable();
            $table->string('code')->index();

            $table->boolean('is_free')->default(false);

            $table->string('price')->nullable()->index();
            $table->string('promo_price')->nullable()->index();
            $table->boolean('promo_price_enabled')->default(false);

            $table->boolean('main')->default(false);
            $table->boolean('enabled')->default(true);

            $table->boolean('need_to_control_stock')->default(false);
            $table->bigInteger('stock')->nullable()->index();
            $table->boolean('show_if_out_stock')->default(true);
            $table->boolean('show_out_stock_message')->default(true);

            $table->boolean('available')->default(true);
            $table->boolean('show_if_unavailable')->default(true);
            $table->boolean('show_unavailable_message')->default(true);

            $table->json('meta_info')->nullable();

            $table->foreign('product_id')->references('id')
                ->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variations');
    }
};
