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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // leaving this here just to show how to correctly drop a foreign key column

        // Schema::table('products_variations', function (Blueprint $table) {
        //     $table->dropForeign('products_variations_product_variation_type_id_foreign');
        // });

        Schema::table('products_variations', function (Blueprint $table) {
             $table->dropColumn('product_variation_type_id');
        });
    }
}
