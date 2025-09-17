<?php

namespace Tests\Unit\Models;

use App\Models\Client;
use App\Models\ClientPlan;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_be_created_with_valid_data()
    {
        $clientData = [
            'name' => 'John Doe',
            'phone' => '123456789',
            'email' => 'john@example.com',
            'observation' => 'Test observation'
        ];

        $client = Client::create($clientData);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals($clientData['name'], $client->name);
        $this->assertEquals($clientData['phone'], $client->phone);
        $this->assertEquals($clientData['email'], $client->email);
        $this->assertEquals($clientData['observation'], $client->observation);
    }

    public function test_client_has_many_client_plans()
    {
        $client = Client::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $client->clientPlans());
    }

    public function test_client_has_many_schedules()
    {
        $client = Client::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $client->schedules());
    }

    public function test_client_filter_scope_by_name()
    {
        $client1 = Client::factory()->create(['name' => 'John Doe']);
        $client2 = Client::factory()->create(['name' => 'Jane Smith']);

        $results = Client::filter(['name' => 'John'])->get();

        $this->assertCount(1, $results);
        $this->assertEquals($client1->id, $results->first()->id);
    }

    public function test_client_filter_scope_by_email()
    {
        $client1 = Client::factory()->create(['email' => 'john@example.com']);
        $client2 = Client::factory()->create(['email' => 'jane@example.com']);

        $results = Client::filter(['email' => 'john@example.com'])->get();

        $this->assertCount(1, $results);
        $this->assertEquals($client1->id, $results->first()->id);
    }

    public function test_client_filter_scope_by_phone()
    {
        $client1 = Client::factory()->create(['phone' => '123456789']);
        $client2 = Client::factory()->create(['phone' => '987654321']);

        $results = Client::filter(['phone' => '123456789'])->get();

        $this->assertCount(1, $results);
        $this->assertEquals($client1->id, $results->first()->id);
    }

    public function test_client_filter_scope_ignores_empty_parameters()
    {
        $client1 = Client::factory()->create();
        $client2 = Client::factory()->create();

        $results = Client::filter(['name' => '', 'email' => '   ', 'phone' => null])->get();

        $this->assertCount(2, $results);
    }
}
