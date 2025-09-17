<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for different modules
        $permissions = [
            // Client Management
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',
            'manage client plans',
            
            // Schedule Management
            'view schedules',
            'create schedules',
            'edit schedules',
            'delete schedules',
            'manage own schedules',
            
            // Professional Management
            'view professionals',
            'create professionals',
            'edit professionals',
            'delete professionals',
            'manage professional payments',
            
            // Room Management
            'view rooms',
            'create rooms',
            'edit rooms',
            'delete rooms',
            
            // Class Type Management
            'view class types',
            'create class types',
            'edit class types',
            'delete class types',
            
            // Plan Management
            'view plans',
            'create plans',
            'edit plans',
            'delete plans',
            
            // Financial Management
            'view financial reports',
            'manage payments',
            'view revenue',
            'export financial data',
            
            // Studio Management
            'manage studio settings',
            'view studio analytics',
            'manage studio users',
            
            // System Administration (SaaS)
            'manage all studios',
            'view system analytics',
            'manage system settings',
            'manage subscriptions',
            'impersonate users',
            
            // Calendar Management
            'view calendar',
            'manage calendar',
            'view group calendar',
            
            // Profile Management
            'view own profile',
            'edit own profile',
            'change own password',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        echo "Created " . count($permissions) . " permissions\n";

        // Create roles and assign permissions
        
        // 1. System Admin (SaaS Admin) - Full system access
        $systemAdmin = Role::create(['name' => 'system_admin']);
        $systemAdmin->givePermissionTo(Permission::all());
        echo "Created System Admin role with all permissions\n";

        // 2. Studio Owner - Full studio management
        $studioOwner = Role::create(['name' => 'studio_owner']);
        $studioOwner->givePermissionTo([
            // Client Management
            'view clients', 'create clients', 'edit clients', 'delete clients', 'manage client plans',
            
            // Schedule Management
            'view schedules', 'create schedules', 'edit schedules', 'delete schedules',
            
            // Professional Management
            'view professionals', 'create professionals', 'edit professionals', 'delete professionals', 'manage professional payments',
            
            // Room Management
            'view rooms', 'create rooms', 'edit rooms', 'delete rooms',
            
            // Class Type Management
            'view class types', 'create class types', 'edit class types', 'delete class types',
            
            // Plan Management
            'view plans', 'create plans', 'edit plans', 'delete plans',
            
            // Financial Management
            'view financial reports', 'manage payments', 'view revenue', 'export financial data',
            
            // Studio Management
            'manage studio settings', 'view studio analytics', 'manage studio users',
            
            // Calendar Management
            'view calendar', 'manage calendar', 'view group calendar',
            
            // Profile Management
            'view own profile', 'edit own profile', 'change own password',
        ]);
        echo "Created Studio Owner role with management permissions\n";

        // 3. Studio Professional - Limited studio access
        $studioProfessional = Role::create(['name' => 'studio_professional']);
        $studioProfessional->givePermissionTo([
            // Client Management (view only)
            'view clients',
            
            // Schedule Management (own schedules + view others)
            'view schedules', 'manage own schedules',
            
            // Room Management (view only)
            'view rooms',
            
            // Class Type Management (view only)
            'view class types',
            
            // Plan Management (view only)
            'view plans',
            
            // Calendar Management
            'view calendar', 'view group calendar',
            
            // Profile Management
            'view own profile', 'edit own profile', 'change own password',
        ]);
        echo "Created Studio Professional role with limited permissions\n";

        // 4. Studio Client - Very limited access
        $studioClient = Role::create(['name' => 'studio_client']);
        $studioClient->givePermissionTo([
            // Schedule Management (view own only)
            'manage own schedules',
            
            // Calendar Management (view only)
            'view calendar',
            
            // Profile Management
            'view own profile', 'edit own profile', 'change own password',
        ]);
        echo "Created Studio Client role with client permissions\n";

        // Assign roles to existing users
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            $testUser->assignRole('studio_owner');
            echo "Assigned Studio Owner role to test user\n";
        }

        echo "\n✅ Roles and permissions seeded successfully!\n";
        echo "Roles created:\n";
        echo "- System Admin: " . Role::where('name', 'system_admin')->count() . "\n";
        echo "- Studio Owner: " . Role::where('name', 'studio_owner')->count() . "\n";
        echo "- Studio Professional: " . Role::where('name', 'studio_professional')->count() . "\n";
        echo "- Studio Client: " . Role::where('name', 'studio_client')->count() . "\n";
        echo "Total permissions: " . Permission::count() . "\n";
    }
}
