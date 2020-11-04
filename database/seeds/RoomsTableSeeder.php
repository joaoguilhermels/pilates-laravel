<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Room::class, 2)->create()->each(function ($room) {
            $faker = Faker::create();

            $classTypes = App\ClassType::select(['id'])->pluck('id')->toArray();

            $room->classTypes()->sync($faker->randomElements($classTypes, 2));
        });
    }
}
