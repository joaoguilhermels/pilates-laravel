<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProfessionalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Professional', 2)->create()->each(function($professional) {
            $faker = Faker::create();

            $classTypes = App\ClassType::all()->lists('id')->toArray();
            
            $professional->classTypes()->attach($faker->randomElement($classTypes), [
              'value' => '45',
              'value_type' => 'percentage'
            ]);
        });
    }
}
