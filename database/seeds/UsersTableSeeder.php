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
            'email' =>      'ilic.marko.05@live.com',
            'stripe_id' => 'cus_D2wwe87mCARXcd',
            'password' =>   bcrypt('admin'),
            'admin' =>      true
        ]);
    }
}
