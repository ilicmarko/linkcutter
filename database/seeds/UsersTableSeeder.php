<?php

use Illuminate\Database\Seeder;
use App\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' =>       'Marko Ilic',
            'email' =>      'admin@admin.io',
            'stripe_id' => 'cus_D2wwe87mCARXcd',
            'password' =>   bcrypt('admin'),
            'admin' =>      true
        ]);
    }
}
