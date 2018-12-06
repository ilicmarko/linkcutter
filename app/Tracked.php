<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracked extends Model
{
    protected $fillable = ['email', 'hash', 'unique_id', 'link_id'];
}
