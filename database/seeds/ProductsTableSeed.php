<?php

use Illuminate\Database\Seeder;

class ProductsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Product::create([
           'id'     => 'prod_D1BDa14cKJ5N4A',
            'name'  => 'Basic',
        ]);
    }
}
