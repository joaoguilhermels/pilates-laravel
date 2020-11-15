<?php

use Illuminate\Database\Seeder;

class ClientPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientsCount = App\Client::count();

        /*factory('App\ClientPlan', $clientsCount)->create()->each(functoon ($clientPlan) {
            for($i = $clientPlan->plan->) {

            }
        });*/
    }
}
