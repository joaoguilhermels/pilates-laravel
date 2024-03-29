<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProfessionalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Professional::class, 2)->create()->each(function ($professional) {
            $faker = Faker::create();

            $classTypes = App\ClassType::select(['id'])->pluck('id')->toArray();

            $professional->classTypes()->attach($faker->randomElement($classTypes), [
              'value' => '45',
              'value_type' => 'percentage',
            ]);
        });
    }
}
