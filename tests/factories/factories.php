<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(\GeorgeHanson\SaaS\Tests\Resources\User::class, function (Faker $faker) {
    return [
       'name' => $faker->name,
       'email' => $faker->email,
       'password' => 'mypassword'
    ];
});
