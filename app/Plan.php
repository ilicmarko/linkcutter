<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Plan
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Feature[] $features
 * @mixin \Eloquent
 */
class Plan extends Model
{
    protected $guarded = [];

    public $incrementing = false;
    public $keyType = 'string';

    public function features()
    {
        return $this->belongsToMany('App\Feature')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function subscription()
    {
        $this->belongsTo(Subscription::class);
    }

    public function price()
    {
        return $this->amount . '$';
    }
}
