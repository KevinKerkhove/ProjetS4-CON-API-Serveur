<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Modeles\Player;
use Faker\Generator as Faker;

$factory->define(Player::class, function (Faker $faker) {
    $createAt = $faker->dateTimeInInterval(
        $startDate = '-6 months',
        $interval = '+ 180 days',
        $timezone = date_default_timezone_get()
    );
    return [
        'playerName' => $faker->name(),
        'bestScore' => $faker->numberBetween(0,5000),
        'playTime' => $faker->numberBetween(0,360000),
        'created_at' => $createAt,
        //'user_id' => User::where('user.id','=','player.id')->get(),
        'updated_at' => $faker->dateTimeInInterval(
            $startDate = $createAt,
            $interval = $createAt->diff(new DateTime('now'))->format("%R%a days"),
            $timezone = date_default_timezone_get()
        ),
    ];
});
