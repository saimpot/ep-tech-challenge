<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Booking;
use App\Journal;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Journal::class, function (Faker $faker) {
    return [
        'date' => $faker->date,
        'text' => $faker->text,
    ];
});
