<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
    protected $fillable = ['ip_address', 'unique_id', 'user_agent', 'lat', 'lng', 'country', 'country_code', 'city', 'unique_visit', 'link_id'];
}
