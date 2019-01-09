<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation_user', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('product_variation_id')->index();
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();

            // Add covering index
            // https://stackoverflow.com/questions/50857254/speeding-up-joins-with-indexes
            // $table->index(['user_id', 'product_variation_id', 'quantity']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation_user');
    }
}
