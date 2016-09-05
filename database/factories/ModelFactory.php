<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/*
  $factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});
*/


$factory->define(App\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'observation' => $faker->paragraph,
    ];
});


$factory->define(App\ClassType::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Class ' . $faker->name,
        'max_number_of_clients' => rand(1, 3),
        'duration' => 60,
        'extra_class_price' => rand(50, 70)
    ];
});

$factory->define(App\ClassTypeStatus::class, function (Faker\Generator $faker) {
    return [
      'name' => $faker->boolean,
      'charge_client' => $faker->boolean,
      'pay_professional' => $faker->boolean,
      'color' => $faker->hexcolor,
    ];
});


$factory->define(App\Room::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Room ' . $faker->name,
    ];
});


$factory->define(App\Professional::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
    ];
});


$factory->define(App\Plan::class, function (Faker\Generator $faker) {
    $classTypes = App\ClassType::select(['id'])->pluck('id')->toArray();

    return [
        'name'          => 'Plan ' . $faker->name,
        'class_type_id' => $faker->randomElement($classTypes),
        'times'         => $faker->randomElement([1, 3]),
        'times_type'    => $faker->randomElement(['week', 'month']),
        'duration'      => $faker->randomElement([1, 3, 6, 12]),
        'duration_type' => $faker->randomElement(['week', 'month']),
        'price'         => $faker->randomFloat(0, 340, 400),
        'price_type'    => $faker->randomElement(['class', 'month'])
    ];
});

$factory->define(App\ClientPlan::class, function (Faker\Generator $faker) {
    $clients = App\Client::select(['id'])->pluck('id')->toArray();
    $classes = App\ClassType::select(['id'])->pluck('id')->toArray();
    $plans = App\Plan::select(['id'])->pluck('id')->toArray();

    return [
        'client_id' => $faker->randomElement($clients),
        'class_type_id' => $faker->randomElement($classes),
        'plan_id' => $faker->randomElement($plans),
        'start_at' => $faker->dateTime()
    ];
});
