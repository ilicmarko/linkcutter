<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Plan;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now('utc')->toDateTimeString();
        $data = [
            [
                'id'                => 'plan_D1BPsfajJ65qZy',
                'name'              => 'Basic Monthly',
                'product_id'        => \App\Product::first()->id,
                'amount'            => 2,
                'interval'          => 'month',
                'interval_count'    => 1,
                'order'             => 1,

            ],
            [
                'id'                => 'plan_D1BRfKwXl5SugG',
                'name'              => 'Basic Yearly',
                'product_id'        => \App\Product::first()->id,
                'amount'            => 20,
                'interval'          => 'year',
                'interval_count'    => 1,
                'order'             => 2,

            ],
            [
                'id'                => 'plan_D2itQaA2vELeUg',
                'name'              => 'Ultimate monthly',
                'product_id'        => \App\Product::first()->id,
                'amount'            => 30,
                'interval'          => 'month',
                'interval_count'    => 1,
                'order'             => 3,

            ],
        ];

        foreach($data as $key => $item) {
            $data[$key]['created_at'] = $now;
            $data[$key]['updated_at'] = $now;
        }

        Plan::insert($data);

    }
}
