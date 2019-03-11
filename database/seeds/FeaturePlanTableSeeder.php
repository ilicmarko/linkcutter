<?php

use Illuminate\Database\Seeder;
use \App\Plan;

class FeaturePlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = Plan::all();

        foreach ($plans as $plan) {
            switch ($plan->id) {
                case 'plan_D1BPsfajJ65qZy': $plan->features()->attach([1]); break;
                case 'plan_D1BRfKwXl5SugG': $plan->features()->attach([1, 2]); break;
                case 'plan_D2itQaA2vELeUg': $plan->features()->attach([1, 2, 3, 4, 5, 6, 7]); break;
            }
        }
    }
}
