<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $guarded = [];
    protected $keyType = 'string';
}
