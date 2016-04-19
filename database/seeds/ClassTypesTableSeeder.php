<?php

use Illuminate\Database\Seeder;

class ClassTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ClassType::class, 2)->create()->each(function($classType) {
            $classType->statuses()->save(factory(App\ClassTypeStatus::class)->create([
                'class_type_id' => $classType->id,
                'name' => 'OK',
                'charge_client' => TRUE,
                'pay_professional' => TRUE,
                'color' => '#6FCB6D'
            ]));

            $classType->statuses()->save(factory(App\ClassTypeStatus::class)->create([
                'class_type_id' => $classType->id,
                'name' => 'Desmarcou',
                'charge_client' => NULL,
                'pay_professional' => NULL,
                'color' => '#00B9FE'
            ]));

            $classType->statuses()->save(factory(App\ClassTypeStatus::class)->create([
                'class_type_id' => $classType->id,
                'name' => 'Faltou',
                'charge_client' => TRUE,
                'pay_professional' => NULL,
                'color' => '#FF1E00'
            ]));

            $classType->statuses()->save(factory(App\ClassTypeStatus::class)->create([
                'class_type_id' => $classType->id,
                'name' => 'Reposição',
                'charge_client' => TRUE,
                'pay_professional' => TRUE,
                'color' => '#685DFF'
            ]));
        });
    }
}
