<?php

use \App\Http\Controllers\URLFactory;
use \App\Link;
use Faker\Generator as Faker;


$factory->define(\App\Visit::class, function (Faker $faker) {
    $url = $faker->url();
    $unique = $faker->boolean(20);

    if ($unique && \App\Visit::all()->isNotEmpty()) {
        $visit =\App\Visit::where('unique_visit', '=', 0)->inRandomOrder()->first();
        $sid = $visit->unique_id;
    } else {
        $sid = $faker->uuid();
    }
    return [
        'unique_id'     => $sid,
        'user_agent'    => $faker->userAgent(),
        'link_id'       => Link::all()->random()->id,
        'ip_address'    => $faker->ipv4(),
        'lat'           => $faker->latitude(),
        'lng'           => $faker->longitude(),
        'country'       => $faker->country(),
        'country_code'  => $faker->countryCode(),
        'city'          => $faker->city(),
        'unique_visit'  => $faker->boolean(),
        'is_vpn'        => $faker->boolean(10),
        'referer'       => $url,
        'referer_host'  => URLFactory::getHost($url),
        'created_at'    => \App\Helpers\Helper::getRandomDate(-6)
    ];
});
