<?php

use Illuminate\Database\Seeder;

class VisitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // This is slow, but I need to create each separately because I need to
        // check if hash exists.
        $links = [];
        for ($i = 0; $i < 25; $i++) {
            $links[] = factory(\App\Link::class)->create();
        }

        foreach ($links as $link) {
            factory(\App\Visit::class, 200)->create([
                'link_id' => $link->id,
            ]);
        }
    }
}