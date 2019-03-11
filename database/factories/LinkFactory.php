<?php

use Faker\Generator as Faker;

$factory->define(\App\Link::class, function (Faker $faker) {
    $hash = \App\Http\Controllers\URLFactory::generateUniqueHash();
    $userID = \App\User::first()->id;

    return [
        'hash'      => $hash,
        'link'      => $faker->url(),
        'tracked'   => 1,
        'user_id'   => $userID,
    ];
});
