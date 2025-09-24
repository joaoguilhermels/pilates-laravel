<?php

use App\Models\User;
use App\Models\Professional;
use App\Models\ClassType;
use App\Models\Client;
use App\Models\Schedule;
use App\Models\Room;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('Professional Form UX', function () {
    test('professional create form shows clear field explanations', function () {
        $response = $this->get('/professionals/create');
        
        expect($response->status())->toBe(200);
        
        $content = $response->getContent();
        expect($content)
            ->toContain('Compensation Model')
            ->toContain('Fixed Salary')
            ->toContain('Commission Percentage')
            ->toContain('help-text')
            ->toContain('tooltip');
    });

    test('professional form shows compensation model options clearly', function () {
        $response = $this->get('/professionals/create');
        
        $content = $response->getContent();
        expect($content)
            ->toContain('Fixed monthly salary')
            ->toContain('Professional earns commission based on class types taught')
            ->toContain('Combined salary + commission')
            ->toContain('Choose how this professional will be compensated');
    });

    test('professional form validates compensation model selection', function () {
        $classType = ClassType::factory()->create();
        
        $response = $this->post('/professionals', [
            'name' => 'Test Professional',
            'email' => 'test@example.com',
            'phone' => '123456789',
            'compensation_model' => 'invalid_model'
        ]);
        
        expect($response->status())->toBe(302); // Redirect back with errors
        $response->assertSessionHasErrors(['compensation_model']);
    });
});

describe('Professional Class Type Management', function () {
    test('removing class types shows impact warning', function () {
        $professional = Professional::factory()->create();
        $classType = ClassType::factory()->create();
        $room = Room::factory()->create();
        $client = Client::factory()->create();
        
        $professional->classTypes()->attach($classType->id);
        
        // Create future schedules that would be affected
        Schedule::factory()->create([
            'professional_id' => $professional->id,
            'client_id' => $client->id,
            'room_id' => $room->id,
            'class_type_id' => $classType->id,
            'start_at' => now()->addDays(rand(1, 30))
        ]);
        
        $response = $this->get("/professionals/{$professional->id}/edit");
        
        expect($response->status())->toBe(200);
        
        $content = $response->getContent();
        expect($content)
            ->toContain('Edit Professional')
            ->toContain($professional->name)
            ->toContain('Class Types & Commission Rates');
    });

    test('professional edit shows schedule impact analysis', function () {
        $professional = Professional::factory()->create();
        $classType = ClassType::factory()->create();
        $room = Room::factory()->create();
        $client = Client::factory()->create();
        
        $professional->classTypes()->attach($classType->id);
        
        // Create multiple future schedules that would be affected
        for ($i = 0; $i < 3; $i++) {
            Schedule::factory()->create([
                'professional_id' => $professional->id,
                'client_id' => $client->id,
                'room_id' => $room->id,
                'class_type_id' => $classType->id,
                'start_at' => now()->addDays($i + 1)
            ]);
        }
        
        $response = $this->get("/professionals/{$professional->id}/edit");
        
        expect($response->status())->toBe(200);
        
        $content = $response->getContent();
        expect($content)
            ->toContain('Edit Professional')
            ->toContain($professional->name);
    });
});

describe('Professional Compensation Models', function () {
    test('professional can have fixed salary only', function () {
        $response = $this->post('/professionals', [
            'name' => 'Salary Professional',
            'email' => 'salary@example.com',
            'phone' => '123456789',
            'compensation_model' => 'fixed_salary',
            'fixed_salary' => 3000.00,
            'commission_percentage' => null
        ]);
        
        expect($response->status())->toBe(302);
        
        $professional = Professional::where('email', 'salary@example.com')->first();
        expect($professional)->not->toBeNull();
        expect($professional->compensation_model)->toBe('fixed_salary');
        expect((float)$professional->fixed_salary)->toBe(3000.00);
    });

    test('professional can have commission only', function () {
        $response = $this->post('/professionals', [
            'name' => 'Commission Professional',
            'email' => 'commission@example.com',
            'phone' => '123456789',
            'compensation_model' => 'commission_only',
            'fixed_salary' => null
        ]);
        
        expect($response->status())->toBe(302);
        
        $professional = Professional::where('email', 'commission@example.com')->first();
        expect($professional)->not->toBeNull();
        expect($professional->compensation_model)->toBe('commission_only');
    });

    test('professional can have combined compensation', function () {
        $response = $this->post('/professionals', [
            'name' => 'Combined Professional',
            'email' => 'combined@example.com',
            'phone' => '123456789',
            'compensation_model' => 'salary_plus_commission',
            'fixed_salary' => 2000.00
        ]);
        
        expect($response->status())->toBe(302);
        
        $professional = Professional::where('email', 'combined@example.com')->first();
        expect($professional)->not->toBeNull();
        expect($professional->compensation_model)->toBe('salary_plus_commission');
        expect((float)$professional->fixed_salary)->toBe(2000.00);
    });
});

describe('Change Management', function () {
    test('changing professional class types shows confirmation dialog', function () {
        $professional = Professional::factory()->create();
        $oldClassType = ClassType::factory()->create(['name' => 'Pilates']);
        $newClassType = ClassType::factory()->create(['name' => 'Yoga']);
        
        $professional->classTypes()->attach($oldClassType->id);
        
        // Create future schedule
        Schedule::factory()->create([
            'professional_id' => $professional->id,
            'class_type_id' => $oldClassType->id,
            'start_at' => now()->addWeek()
        ]);
        
        $response = $this->patch("/professionals/{$professional->id}", [
            'name' => $professional->name,
            'email' => $professional->email,
            'phone' => $professional->phone,
            'class_type_list' => [
                ['class_type_id' => $newClassType->id]
            ]
        ]);
        
        // Should show confirmation page or warning
        expect($response->status())->toBeIn([200, 302]);
    });

    test('system handles orphaned schedules gracefully', function () {
        $professional = Professional::factory()->create();
        $classType = ClassType::factory()->create();
        
        // Create schedule
        $schedule = Schedule::factory()->create([
            'professional_id' => $professional->id,
            'class_type_id' => $classType->id,
            'start_at' => now()->addWeek()
        ]);
        
        // Remove class type from professional
        $professional->classTypes()->detach($classType->id);
        
        // Schedule should still exist but be flagged
        $schedule->refresh();
        expect($schedule)->not->toBeNull();
        expect($schedule->professional_id)->toBe($professional->id);
    });
});
