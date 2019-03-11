<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Visit
 *
 * @mixin \Eloquent
 * @property-read \App\Link $link
 */
class Visit extends Model
{
    protected $guarded = [];

    public function link()
    {
        return $this->belongsTo('\App\Link');
    }
}
