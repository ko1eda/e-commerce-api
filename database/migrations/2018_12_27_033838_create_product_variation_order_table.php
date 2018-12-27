<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation_order', function (Blueprint $table) {
            $table->unsignedInteger('product_variation_id')->index();
            $table->unsignedInteger('order_id')->index();
            $table->unsignedInteger('quantity_ordered');
            $table->timestamps();

            // $table->unique(['order_id', 'product_variation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation_order');
    }
}
