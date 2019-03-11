<?php

use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Subscription::create([
            'user_id'       => 1,
            'name'          => 'default',
            'stripe_id'     => 'sub_D2wwxlf2lhNxeD',
            'stripe_plan'   => 'plan_D2itQaA2vELeUg',
            'quantity'      => 1
        ]);
    }
}
