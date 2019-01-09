<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsVariationsStocksView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ## This selectes all product variations
        ## Left joins them with the stock for each variation (if there is one)
        ## Then left joins that with the total quantity purchased of each variation from the orders column
        ## https://stackoverflow.com/questions/3316950/create-if-not-exists-view Or replace because migration was getting messed up
        \DB::statement(
            "CREATE OR REPLACE VIEW products_variations_stocks_view AS
            SELECT 
                pv.product_id, 
                pv.id AS product_variation_id, 
                pv.name AS product_variation_name,
                IFNULL(stocks.quantity, 0) - IFNULL(orders.quantity, 0) as stock,
                IF(IFNULL(stocks.quantity, 0) - IFNULL(orders.quantity, 0) <> 0, true, false) as in_stock
            FROM 
                products_variations AS pv
            LEFT JOIN 
            (
                SELECT 
                    stocks.product_variation_id as id,
                    SUM(stocks.quantity) as quantity
                FROM 
                    stocks
                GROUP BY 
                    stocks.product_variation_id
            ) AS stocks USING (id)
            LEFT JOIN 
            (
                SELECT 
                    product_variation_order.product_variation_id as id,
                    SUM(product_variation_order.quantity_ordered) as quantity
                FROM 
                    product_variation_order
                GROUP BY 
                    product_variation_order.product_variation_id
            ) AS orders USING (id)
            GROUP BY 
                product_variation_id"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP VIEW IF EXISTS products_variations_stocks_view');
    }
}
