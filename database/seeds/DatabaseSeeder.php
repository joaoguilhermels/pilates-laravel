<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $toDelete = [
        'class_type_professional',
        'class_type_statuses',
        'class_types',
        'class_type_room',
        'rooms',
        'professionals',
        'client_plans',
        'clients',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->toDelete as $table) {
            DB::table($table)->delete();
        }

        $this->call(ClientsTableSeeder::class);
        $this->call(ClassTypesTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
        $this->call(ProfessionalsTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(ClientPlansTableSeeder::class);
        //$this->call(PaymentMethodSeeder::class);
        //$this->call(BankAccountSeeder::class);
    }
}
