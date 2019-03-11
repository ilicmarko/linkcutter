<?php

use Illuminate\Database\Seeder;
use App\Feature;
use Carbon\Carbon;

class FeaturesTableSeeder extends Seeder
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
                'name'          => 'Tracking',
                'description'   => 'Track user visits',
                'slug'          => 'tracking',
            ],
            [
                'name'          => 'Dashboard',
                'description'   => 'Get access to our interactive dashboard with latest stats.',
                'slug'          => 'dashboard',
            ],
            [
                'name'          => 'Unique visits',
                'description'   => 'Track unique visits and compare how many unique visitors you get.',
                'slug'          => 'unique-visits',
            ],
            [
                'name'          => 'Geo location',
                'description'   => 'See where users are coming from, we can group visits by country or even by city.',
                'slug'          => 'geo-location',
            ],
            [
                'name'          => 'Logger',
                'description'   => 'Get insights on all the users that visit you link, like IP address.',
                'slug'          => 'logger',
            ],
            [
                'name'          => 'VPN Detector',
                'description'   => 'Detect if a user is using a VPN, now with 99.99% accuracy!',
                'slug'          => 'vpn-detector',
            ],
            [
                'name'          => 'Custom link',
                'description'   => 'Don\'t let your life be a random string, enter your custom link name!',
                'slug'          => 'custom-link',
            ]

        ];

        foreach($data as $key => $item) {
            $data[$key]['created_at'] = $now;
            $data[$key]['updated_at'] = $now;
        }

        Feature::insert($data);
    }
}
