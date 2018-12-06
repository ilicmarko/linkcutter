<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinksVisitors extends Model
{
    protected $fillable = ['link_id', 'visitors_id'];

    public function links() {
        return $this->hasMany(Links::class);
    }

    public function visitors() {
        return $this->hasMany(Visitors::class);
    }
}
