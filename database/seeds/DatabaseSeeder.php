<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(FeaturesTableSeeder::class);
        $this->call(ProductsTableSeed::class);
        $this->call(PlansTableSeeder::class);
        $this->call(FeaturePlanTableSeeder::class);
        $this->call(SubscriptionsTableSeeder::class);
        $this->call(VisitsTableSeeder::class);
    }
}
