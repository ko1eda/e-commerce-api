<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /**
     * A category can have child categories
     *
     * @return void
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
