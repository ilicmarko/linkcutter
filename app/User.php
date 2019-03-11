<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;


/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Subscription $sub
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Billable;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = ['sub.plan.features'];

    public function isAdmin()
    {
        return $this->admin;
    }

    public function sub()
    {
        return $this->hasOne('App\Subscription');
    }

    public function features()
    {
//        return User::join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
//            ->join('plans', 'plans.id', '=', 'subscriptions.stripe_plan')
//            ->join('feature_plan', 'feature_plan.plan_id', '=', 'plans.id')
//            ->join('features', 'features.id', '=', 'feature_plan.feature_id')
//            ->where('users.id', '=', $this->id)
//            ->get();
        if ($this->sub) {
            return $this->sub->plan->features;
        }
        return null;
    }

    public function hasFeature($feature_id)
    {
        if ($this->features()) {
            return $this->features()
                        ->where('slug', '=', $feature_id)
                        ->isNotEmpty();
        }

        return false;
    }

    public function subscriptionName()
    {
        if ($this->subscribed()) {
            $currPlanID = $this->subscription()->stripe_plan;
            $plan = Plan::where('id', '=', $currPlanID)->first();

            return $plan->name;
        }
        return null;
    }
}
