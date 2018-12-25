<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Priceable;

class ProductVariation extends Model
{

    use Priceable;

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
     * Append these dynamic attributes to
     * the model
     *
     * @var array
     */
    protected $appends = ['hasParentPrice'];

    /**
     * Override this method from Priceable trait.
     * If the price on a variation is null
     * then return the parent price (which is already a money object)
     * otherwise create a new money object with the variation price
     *
     * @return Money;
     */
    public function getPriceAttribute($value)
    {
        if (! isset($value)) {
            return $this->product->price;
        }

        return new \App\Cart\Money($value);
    }

    /**
     * If the variation does not have an image
     * return its partent image.
     *
     * @return String
     */
    public function getImagePathAttribute($value)
    {
        return $value ?? $this->product->image_path;
    }

    /**
     * Return true or false
     * depending on if the variations
     * shares the same price as its parent
     *
     * @throws \Exception
     * @return bool
     */
    public function getHasParentPriceAttribute() : bool
    {
        if (! $this->price->amount()->isSameCurrency($this->product->price->amount())) {
            throw new \Exception('Currency Mismatch Exception');
        }

        return $this->price->amount()->equals($this->product->price->amount());
    }

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
