<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Override the default route key
     *
     * @return String
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
