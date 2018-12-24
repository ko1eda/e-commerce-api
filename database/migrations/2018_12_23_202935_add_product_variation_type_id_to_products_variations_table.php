<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductVariationTypeIdToProductsVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_variations', function (Blueprint $table) {
            $table->unsignedInteger('product_variation_type_id')->index();

            $table->foreign('product_variation_type_id')
                ->references('id')
                ->on('products_variations_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_variations', function (Blueprint $table) {
            $table->dropForeign('products_variations_product_variation_type_id_foreign');
        });

        Schema::table('products_variations', function (Blueprint $table) {
             $table->dropColumn('product_variation_type_id');
        });
    }
}
