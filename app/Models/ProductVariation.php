<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    /**
     * By convention laravel uses product_variations
     * as the table name. But I want to name every non-bridge
     * table as plural to keep it consistant.
     * https://laravel.com/docs/5.7/eloquent#defining-models
     *
     * @var string
     */
    protected $table = 'products_variations';


    /**
     * A product variation belongs to a product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * A product variation has one type associated with it
     * ex: vans shoe -- red (red is the varition) the type would be Color
     *
     * note: the second argument is the foreign key
     *  Thisits saying that when this relationship is called,
     *  it will look at the id column on products_variations_types
     *  and match it the local key of this table which is product_variation_type
     *
     *  by default it would use this method name + _id
     *  so type_id as the foreign key and id as the local key
     *  https://laravel.com/docs/5.7/eloquent-relationships#one-to-many (see one-to-many-inverse)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }
}
