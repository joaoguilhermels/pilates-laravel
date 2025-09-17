<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user for authentication if needed
        $this->user = User::factory()->create();
    }

    public function test_can_view_clients_index()
    {
        $this->actingAs($this->user);
        $clients = Client::factory()->count(3)->create();

        $response = $this->get('/clients');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_can_create_new_client()
    {
        $this->actingAs($this->user);
        $clientData = [
            'name' => 'John Doe',
            'phone' => '123456789',
            'email' => 'john@example.com',
            'observation' => 'New client'
        ];

        $response = $this->post('/clients', $clientData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', $clientData);
    }

    public function test_can_view_single_client()
    {
        $this->actingAs($this->user);
        $client = Client::factory()->create();

        $response = $this->get("/clients/{$client->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $client->id]);
    }

    public function test_can_update_client()
    {
        $this->actingAs($this->user);
        $client = Client::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'phone' => $client->phone,
            'email' => $client->email,
            'observation' => 'Updated observation'
        ];

        $response = $this->put("/clients/{$client->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Updated Name',
            'observation' => 'Updated observation'
        ]);
    }

    public function test_can_delete_client()
    {
        $this->actingAs($this->user);
        $client = Client::factory()->create();

        $response = $this->delete("/clients/{$client->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    public function test_client_validation_requires_name()
    {
        $this->actingAs($this->user);
        $clientData = [
            'phone' => '123456789',
            'email' => 'john@example.com'
        ];

        $response = $this->post('/clients', $clientData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    public function test_client_validation_requires_valid_email()
    {
        $this->actingAs($this->user);
        $clientData = [
            'name' => 'John Doe',
            'phone' => '123456789',
            'email' => 'invalid-email'
        ];

        $response = $this->post('/clients', $clientData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }
}
