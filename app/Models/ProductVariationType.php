<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariationType extends Model
{
    /**
     * By convention laravel uses product_variation_types
     * as the table name. But I want to name every non-bridge
     * table as plural to keep it consistant.
     * https://laravel.com/docs/5.7/eloquent#defining-models
     *
     * @var string
     */
    protected $table = 'products_variations_types';
}
