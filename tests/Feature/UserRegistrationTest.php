<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\SaasPlans;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles and permissions for testing
        $this->createRolesAndPermissions();
        
        // Create SaaS plans for testing
        $this->createSaasPlans();
    }

    private function createRolesAndPermissions()
    {
        // Create roles
        Role::create(['name' => 'system_admin', 'guard_name' => 'web']);
        Role::create(['name' => 'studio_owner', 'guard_name' => 'web']);
        Role::create(['name' => 'studio_professional', 'guard_name' => 'web']);
        Role::create(['name' => 'studio_client', 'guard_name' => 'web']);

        // Create basic permissions
        Permission::create(['name' => 'view clients', 'guard_name' => 'web']);
        Permission::create(['name' => 'create clients', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit clients', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete clients', 'guard_name' => 'web']);
    }

    private function createSaasPlans()
    {
        SaasPlans::create([
            'name' => 'Profissional',
            'slug' => 'profissional',
            'description' => 'Para instrutores independentes',
            'monthly_price' => 97.00,
            'yearly_price' => 970.00,
            'max_clients' => 100,
            'max_professionals' => 1,
            'max_rooms' => null,
            'features' => [
                'clients_limit' => 100,
                'professionals_limit' => 1,
                'rooms_limit' => null
            ],
            'stripe_monthly_price_id' => 'price_test_monthly_prof',
            'stripe_yearly_price_id' => 'price_test_yearly_prof',
            'is_popular' => false,
            'is_active' => true,
            'trial_days' => 14
        ]);

        SaasPlans::create([
            'name' => 'Estúdio',
            'slug' => 'estudio',
            'description' => 'Para proprietários de estúdio',
            'monthly_price' => 297.00,
            'yearly_price' => 2970.00,
            'max_clients' => null,
            'max_professionals' => null,
            'max_rooms' => null,
            'features' => [
                'clients_limit' => null,
                'professionals_limit' => null,
                'rooms_limit' => null
            ],
            'stripe_monthly_price_id' => 'price_test_monthly_studio',
            'stripe_yearly_price_id' => 'price_test_yearly_studio',
            'is_popular' => true,
            'is_active' => true,
            'trial_days' => 14
        ]);
    }

    /** @test */
    public function it_can_register_a_new_user_with_studio_owner_role()
    {
        // Arrange
        $studioPlan = SaasPlans::where('slug', 'estudio')->first();
        
        $userData = [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'studio_name' => 'Estúdio Pilates João',
            'saas_plan_id' => $studioPlan->id,
            'billing_cycle' => 'monthly'
        ];

        // Act
        $response = $this->post('/register', $userData);

        // Assert
        $response->assertRedirect('/home');
        
        $user = User::where('email', 'joao@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('João Silva', $user->name);
        $this->assertEquals('Estúdio Pilates João', $user->studio_name);
        $this->assertTrue($user->hasRole('studio_owner'));
        $this->assertEquals($studioPlan->id, $user->saas_plan_id);
        $this->assertEquals('monthly', $user->billing_cycle);
    }

    /** @test */
    public function it_can_register_a_new_user_with_professional_role()
    {
        // Arrange
        $professionalPlan = SaasPlans::where('slug', 'profissional')->first();
        
        $userData = [
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'studio_name' => 'Maria Pilates',
            'saas_plan_id' => $professionalPlan->id,
            'billing_cycle' => 'yearly'
        ];

        // Act
        $response = $this->post('/register', $userData);

        // Assert
        $response->assertRedirect('/home');
        
        $user = User::where('email', 'maria@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Maria Santos', $user->name);
        $this->assertEquals('Maria Pilates', $user->studio_name);
        $this->assertTrue($user->hasRole('studio_professional'));
        $this->assertEquals($professionalPlan->id, $user->saas_plan_id);
        $this->assertEquals('yearly', $user->billing_cycle);
    }

    /** @test */
    public function it_requires_valid_saas_plan_id()
    {
        // Arrange
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'studio_name' => 'Test Studio',
            'saas_plan_id' => 999, // Invalid plan ID
            'billing_cycle' => 'monthly'
        ];

        // Act
        $response = $this->post('/register', $userData);

        // Assert
        $response->assertSessionHasErrors('saas_plan_id');
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    /** @test */
    public function it_requires_all_required_fields()
    {
        // Act
        $response = $this->post('/register', []);

        // Assert
        $response->assertSessionHasErrors([
            'name',
            'email',
            'password',
            'studio_name',
            'saas_plan_id',
            'billing_cycle'
        ]);
    }

    /** @test */
    public function it_sets_trial_period_correctly()
    {
        // Arrange
        $studioPlan = SaasPlans::where('slug', 'estudio')->first();
        
        $userData = [
            'name' => 'Trial User',
            'email' => 'trial@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'studio_name' => 'Trial Studio',
            'saas_plan_id' => $studioPlan->id,
            'billing_cycle' => 'monthly'
        ];

        // Act
        $response = $this->post('/register', $userData);

        // Assert
        $user = User::where('email', 'trial@example.com')->first();
        $this->assertNotNull($user->trial_ends_at);
        $this->assertTrue($user->is_trial);
        $this->assertTrue($user->is_active);
        
        // Trial should end in 14 days
        $expectedTrialEnd = now()->addDays(14)->format('Y-m-d');
        $actualTrialEnd = $user->trial_ends_at->format('Y-m-d');
        $this->assertEquals($expectedTrialEnd, $actualTrialEnd);
    }

    /** @test */
    public function it_handles_missing_role_gracefully()
    {
        // Arrange - Delete the studio_owner role to simulate the error
        Role::where('name', 'studio_owner')->delete();
        
        $studioPlan = SaasPlans::where('slug', 'estudio')->first();
        
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'studio_name' => 'Test Studio',
            'saas_plan_id' => $studioPlan->id,
            'billing_cycle' => 'monthly'
        ];

        // Act & Assert
        $this->expectException(\Spatie\Permission\Exceptions\RoleDoesNotExist::class);
        $response = $this->post('/register', $userData);
    }
}
