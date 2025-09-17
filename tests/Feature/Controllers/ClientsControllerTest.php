<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;

class ClientsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method displays clients list.
     */
    public function test_index_displays_clients_list(): void
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create some clients
        $clients = Client::factory()->count(3)->create();
        
        // Act as the user and get the clients index page
        $response = $this->actingAs($user)->get(route('clients.index'));
        
        // Assert response is successful
        $response->assertStatus(200);
        
        // Assert view contains clients
        $response->assertViewHas('clients');
    }

    /**
     * Test the show method displays a client.
     */
    public function test_show_displays_a_client(): void
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a client
        $client = Client::factory()->create();
        
        // Act as the user and get the client show page
        $response = $this->actingAs($user)->get(route('clients.show', $client));
        
        // Assert response is successful
        $response->assertStatus(200);
        
        // Assert view contains client
        $response->assertViewHas('client');
    }

    /**
     * Test the create method displays the create form.
     */
    public function test_create_displays_form(): void
    {
        // Create a user
        $user = User::factory()->create();
        
        // Act as the user and get the create form
        $response = $this->actingAs($user)->get(route('clients.create'));
        
        // Assert response is successful
        $response->assertStatus(200);
    }

    /**
     * Test the store method creates a new client.
     */
    public function test_store_creates_new_client(): void
    {
        // Create a user
        $user = User::factory()->create();
        
        // Client data
        $clientData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ];
        
        // Act as the user and post the client data
        $response = $this->actingAs($user)->post(route('clients.store'), $clientData);
        
        // Assert client was created in the database
        $this->assertDatabaseHas('clients', [
            'name' => $clientData['name'],
            'email' => $clientData['email'],
        ]);
        
        // Assert redirection to clients index
        $response->assertRedirect(route('clients.index'));
    }

    /**
     * Test the edit method displays the edit form.
     */
    public function test_edit_displays_form(): void
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a client
        $client = Client::factory()->create();
        
        // Act as the user and get the edit form
        $response = $this->actingAs($user)->get(route('clients.edit', $client));
        
        // Assert response is successful
        $response->assertStatus(200);
        
        // Assert view contains client
        $response->assertViewHas('client');
    }

    /**
     * Test the update method updates a client.
     */
    public function test_update_updates_client(): void
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a client
        $client = Client::factory()->create();
        
        // Updated client data
        $updatedData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ];
        
        // Act as the user and put the updated client data
        $response = $this->actingAs($user)->put(route('clients.update', $client), $updatedData);
        
        // Assert client was updated in the database
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => $updatedData['name'],
            'email' => $updatedData['email'],
        ]);
        
        // Assert redirection to clients index
        $response->assertRedirect(route('clients.index'));
    }

    /**
     * Test the destroy method deletes a client.
     */
    public function test_destroy_deletes_client(): void
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a client
        $client = Client::factory()->create();
        
        // Act as the user and delete the client
        $response = $this->actingAs($user)->delete(route('clients.destroy', $client));
        
        // Assert client was deleted from the database
        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
        
        // Assert redirection to clients index
        $response->assertRedirect(route('clients.index'));
    }
} 