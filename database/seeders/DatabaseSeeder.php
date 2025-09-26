<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientPlan;
use App\Models\ClassType;
use App\Models\ClassTypeStatus;
use App\Models\Professional;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call(RolePermissionSeeder::class);

        // Create demo users with different roles
        $demoUsers = [
            [
                'name' => 'Admin Sistema',
                'email' => 'admin@pilatesflow.com',
                'password' => bcrypt('admin123'),
                'role' => 'system_admin',
                'studio_name' => 'PilatesFlow HQ',
                'phone' => '(11) 99999-0001',
            ],
            [
                'name' => 'João Silva',
                'email' => 'dono@estudio.com',
                'password' => bcrypt('dono123'),
                'role' => 'studio_owner',
                'studio_name' => 'Estúdio Pilates Bem-Estar',
                'phone' => '(11) 99999-0002',
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'instrutora@estudio.com',
                'password' => bcrypt('instrutora123'),
                'role' => 'studio_professional',
                'studio_name' => 'Estúdio Pilates Bem-Estar',
                'phone' => '(11) 99999-0003',
            ],
            [
                'name' => 'Ana Costa',
                'email' => 'cliente@email.com',
                'password' => bcrypt('cliente123'),
                'role' => 'studio_client',
                'studio_name' => 'Estúdio Pilates Bem-Estar',
                'phone' => '(11) 99999-0004',
            ],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'role' => 'studio_owner',
                'studio_name' => 'Test Studio',
                'phone' => '(11) 99999-0000',
            ],
        ];

        foreach ($demoUsers as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                $user = User::factory()->create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                    'studio_name' => $userData['studio_name'],
                    'phone' => $userData['phone'],
                    'onboarding_completed' => true,
                    'email_verified_at' => now(),
                ]);
                
                $user->assignRole($userData['role']);
                echo "Created {$userData['role']} user: {$userData['name']} ({$userData['email']})\n";
            } else {
                echo "User {$userData['email']} already exists\n";
            }
        }

        // Create clients
        $clients = Client::factory(15)->create();
        echo "Created " . $clients->count() . " clients\n";

        // Create professionals
        $professionals = Professional::factory(5)->create();
        echo "Created " . $professionals->count() . " professionals\n";

        // Create rooms
        $rooms = Room::factory()->createMany([
            ['name' => 'Studio A'],
            ['name' => 'Studio B'],
            ['name' => 'Private Room 1'],
            ['name' => 'Private Room 2'],
            ['name' => 'Group Room'],
        ]);
        echo "Created " . $rooms->count() . " rooms\n";

        // Create class types with specific data
        $classTypes = collect([
            [
                'name' => 'Pilates Mat',
                'trial' => true,
                'trial_class_price' => 25.00,
                'max_number_of_clients' => 12,
                'duration' => 60,
                'extra_class' => true,
                'extra_class_price' => 35.00,
            ],
            [
                'name' => 'Pilates Reformer',
                'trial' => true,
                'trial_class_price' => 40.00,
                'max_number_of_clients' => 6,
                'duration' => 50,
                'extra_class' => true,
                'extra_class_price' => 55.00,
            ],
            [
                'name' => 'Private Session',
                'trial' => true,
                'trial_class_price' => 60.00,
                'max_number_of_clients' => 1,
                'duration' => 50,
                'extra_class' => true,
                'extra_class_price' => 80.00,
            ],
            [
                'name' => 'Pilates Cadillac',
                'trial' => false,
                'trial_class_price' => 0.00,
                'max_number_of_clients' => 4,
                'duration' => 45,
                'extra_class' => true,
                'extra_class_price' => 65.00,
            ],
        ])->map(function ($data) {
            return ClassType::factory()->create($data);
        });

        echo "Created " . $classTypes->count() . " class types\n";

        // Create plans for different class types
        $plans = collect();
        foreach ($classTypes as $classType) {
            // Create different plan options for each class type
            $planOptions = [
                [
                    'name' => 'Once a Week',
                    'times' => 1,
                    'times_type' => 'week',
                    'duration' => 1,
                    'duration_type' => 'month',
                    'price' => $classType->name === 'Private Session' ? 320.00 : 140.00,
                    'price_type' => 'month',
                ],
                [
                    'name' => 'Twice a Week',
                    'times' => 2,
                    'times_type' => 'week',
                    'duration' => 1,
                    'duration_type' => 'month',
                    'price' => $classType->name === 'Private Session' ? 600.00 : 260.00,
                    'price_type' => 'month',
                ],
                [
                    'name' => 'Three Times a Week',
                    'times' => 3,
                    'times_type' => 'week',
                    'duration' => 1,
                    'duration_type' => 'month',
                    'price' => $classType->name === 'Private Session' ? 840.00 : 360.00,
                    'price_type' => 'month',
                ],
                [
                    'name' => '8 Classes Package',
                    'times' => 8,
                    'times_type' => 'class',
                    'duration' => 2,
                    'duration_type' => 'month',
                    'price' => $classType->name === 'Private Session' ? 560.00 : 280.00,
                    'price_type' => 'package',
                ],
                [
                    'name' => '12 Classes Package',
                    'times' => 12,
                    'times_type' => 'class',
                    'duration' => 3,
                    'duration_type' => 'month',
                    'price' => $classType->name === 'Private Session' ? 780.00 : 390.00,
                    'price_type' => 'package',
                ],
            ];

            foreach ($planOptions as $planData) {
                $plan = \App\Models\Plan::create(array_merge($planData, [
                    'class_type_id' => $classType->id,
                ]));
                $plans->push($plan);
            }
        }
        echo "Created " . $plans->count() . " plans\n";

        // Create client plans (assign plans to clients)
        $clientPlans = collect();
        foreach ($clients as $client) {
            // Each client gets 1-3 random plans
            $numberOfPlans = rand(1, 3);
            $selectedPlans = $plans->random($numberOfPlans);
            
            foreach ($selectedPlans as $plan) {
                $clientPlan = ClientPlan::factory()->create([
                    'client_id' => $client->id,
                    'plan_id' => $plan->id,
                    'start_at' => fake()->dateTimeBetween('-6 months', '+1 month')->format('Y-m-d'),
                ]);
                $clientPlans->push($clientPlan);
            }
        }
        echo "Created " . $clientPlans->count() . " client plans\n";

        // Create class type statuses for each class type
        $statusData = [
            ['name' => 'Agendado', 'charge_client' => false, 'pay_professional' => false, 'color' => '#3B82F6'],
            ['name' => 'Realizado', 'charge_client' => true, 'pay_professional' => true, 'color' => '#10B981'],
            ['name' => 'Desmarcou', 'charge_client' => false, 'pay_professional' => false, 'color' => '#F59E0B'],
            ['name' => 'Faltou', 'charge_client' => true, 'pay_professional' => false, 'color' => '#EF4444'],
            ['name' => 'Reposição', 'charge_client' => false, 'pay_professional' => true, 'color' => '#8B5CF6'],
        ];

        $totalStatuses = 0;
        foreach ($classTypes as $classType) {
            foreach ($statusData as $status) {
                ClassTypeStatus::factory()->create(array_merge($status, [
                    'class_type_id' => $classType->id,
                ]));
                $totalStatuses++;
            }
        }
        echo "Created " . $totalStatuses . " class type statuses\n";

        // Create schedules for the next month
        $schedules = Schedule::factory(50)->create([
            'client_id' => fn() => $clients->random()->id,
            'class_type_id' => fn() => $classTypes->random()->id,
            'professional_id' => fn() => $professionals->random()->id,
            'room_id' => fn() => $rooms->random()->id,
            'class_type_status_id' => fn() => ClassTypeStatus::inRandomOrder()->first()->id,
        ]);
        echo "Created " . $schedules->count() . " schedules\n";

        // Create reschedules (makeup classes) for some clients
        $rescheduleCount = 0;
        $reposicaoStatus = ClassTypeStatus::where('name', 'Reposição')->first();
        $desmarcouStatus = ClassTypeStatus::where('name', 'Desmarcou')->first();
        $faltouStatus = ClassTypeStatus::where('name', 'Faltou')->first();
        
        if ($reposicaoStatus && ($desmarcouStatus || $faltouStatus)) {
            // Get some schedules that were cancelled or missed to create reschedules for
            $originalSchedules = $schedules->filter(function ($schedule) use ($desmarcouStatus, $faltouStatus) {
                return $schedule->class_type_status_id === $desmarcouStatus?->id || 
                       $schedule->class_type_status_id === $faltouStatus?->id;
            })->take(15); // Create reschedules for up to 15 cancelled/missed classes
            
            foreach ($originalSchedules as $originalSchedule) {
                // Create a reschedule (makeup class) for this cancelled/missed class
                $reschedule = Schedule::factory()->create([
                    'parent_id' => $originalSchedule->id, // Link to original schedule
                    'client_id' => $originalSchedule->client_id, // Same client
                    'class_type_id' => $originalSchedule->class_type_id, // Same class type
                    'professional_id' => $professionals->random()->id, // Could be different professional
                    'room_id' => $rooms->random()->id, // Could be different room
                    'class_type_status_id' => $reposicaoStatus->id, // Reschedule status
                    'trial' => $originalSchedule->trial,
                    'price' => 0.00, // Reschedules typically don't charge extra
                    'start_at' => fake()->dateTimeBetween('+1 day', '+2 months'), // Future date
                    'observation' => 'Reposição da aula de ' . $originalSchedule->start_at->format('d/m/Y H:i'),
                ]);
                $rescheduleCount++;
            }
        }
        echo "Created " . $rescheduleCount . " reschedule/makeup classes\n";

        // Create payment methods
        $paymentMethods = [
            ['name' => 'Dinheiro', 'enabled' => true],
            ['name' => 'Cartão de Crédito', 'enabled' => true],
            ['name' => 'Cartão de Débito', 'enabled' => true],
            ['name' => 'PIX', 'enabled' => true],
            ['name' => 'Transferência Bancária', 'enabled' => true],
            ['name' => 'Boleto', 'enabled' => true],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
        echo "Created " . count($paymentMethods) . " payment methods\n";

        // Create bank accounts
        $bankAccounts = [
            [
                'name' => 'Conta Principal',
                'bank' => 'Banco do Brasil',
                'agency' => '1234-5',
                'account' => '12345-6',
                'balance' => 10000.00,
            ],
            [
                'name' => 'Conta Poupança',
                'bank' => 'Caixa Econômica Federal',
                'agency' => '5678-9',
                'account' => '67890-1',
                'balance' => 5000.00,
            ],
            [
                'name' => 'Conta Digital',
                'bank' => 'Nubank',
                'agency' => '0001',
                'account' => '98765-4',
                'balance' => 2500.00,
            ],
        ];

        foreach ($bankAccounts as $account) {
            BankAccount::create($account);
        }
        echo "Created " . count($bankAccounts) . " bank accounts\n";

        echo "\n✅ Database seeding completed successfully!\n";
        echo "Summary:\n";
        echo "- Clients: " . Client::count() . "\n";
        echo "- Professionals: " . Professional::count() . "\n";
        echo "- Rooms: " . Room::count() . "\n";
        echo "- Class Types: " . ClassType::count() . "\n";
        echo "- Plans: " . \App\Models\Plan::count() . "\n";
        echo "- Client Plans: " . ClientPlan::count() . "\n";
        echo "- Class Type Statuses: " . ClassTypeStatus::count() . "\n";
        echo "- Schedules: " . Schedule::count() . "\n";
        echo "- Payment Methods: " . PaymentMethod::count() . "\n";
        echo "- Bank Accounts: " . BankAccount::count() . "\n";
    }
}
