<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    protected $fillable = ['hash', 'link', 'tracked'];
    
    public function linksvisitors() {
        return $this->belongsTo(LinksVisitors::class);
    }
}
