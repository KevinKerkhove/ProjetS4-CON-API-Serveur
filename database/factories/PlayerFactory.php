<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\Personne;
use App\Modeles\Player;
use Faker\Generator as Faker;

$factory->define(Player::class, function (Faker $faker) {
    $createAt = $faker->dateTimeInInterval(
        $startDate = '-6 months',
        $interval = '+ 180 days',
        $timezone = date_default_timezone_get()
    );
    return [
        'name' => $faker->name(),
        'bestScore' => $faker->randomNumber(),
        'totalPlayTime' => $faker->time('H:i:s'),
        'bio' => $faker->text(),
        'created_at' => $createAt,
        'updated_at' => $faker->dateTimeInInterval(
            $startDate = $createAt,
            $interval = $createAt->diff(new DateTime('now'))->format("%R%a days"),
            $timezone = date_default_timezone_get()
        ),
    ];
});
