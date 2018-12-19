<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasChildren;

class Category extends Model
{
    use HasChildren;

    protected $fillable = [
        'name',
        'order',
        'slug'
    ];


    /**
     * A category can have child categories
     *
     * @return void
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    
    /**
     * A category has many products
     *
     * @return void
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
