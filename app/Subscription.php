<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Subscription
 *
 * @mixin \Eloquent
 * @property-read \App\Plan $plan
 */
class Subscription extends Model
{
    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'stripe_plan');

    }
}
