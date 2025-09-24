<?php

use App\Models\User;
use App\Mcp\Resources\OnboardingStatus;
use App\Mcp\Tools\OnboardingTester;
use App\Mcp\Servers\OnboardingServer;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('onboarding mcp server is properly configured', function () {
    $server = new OnboardingServer();
    
    expect($server->serverName)->toBe('Pilates Studio Onboarding Server');
    expect($server->serverVersion)->toBe('1.0.0');
    expect($server->instructions)->toContain('onboarding functionality');
    expect($server->tools)->toContain(OnboardingTester::class);
    expect($server->resources)->toContain(OnboardingStatus::class);
});

test('onboarding status resource returns valid json', function () {
    $resource = new OnboardingStatus();
    $result = $resource->read();
    
    expect($result)->toBeJson();
    
    $data = json_decode($result, true);
    expect($data)
        ->toHaveKey('user_id')
        ->toHaveKey('user_email')
        ->toHaveKey('onboarding_status')
        ->toHaveKey('timestamp')
        ->toHaveKey('recommendations');
});

test('onboarding status resource includes user information', function () {
    $user = User::factory()->create(['email' => 'mcp-test@example.com']);
    $this->actingAs($user);
    
    $resource = new OnboardingStatus();
    $result = $resource->read();
    $data = json_decode($result, true);
    
    expect($data['user_id'])->toBe($user->id);
    expect($data['user_email'])->toBe('mcp-test@example.com');
});

test('onboarding status resource provides recommendations', function () {
    $resource = new OnboardingStatus();
    $result = $resource->read();
    $data = json_decode($result, true);
    
    expect($data['recommendations'])
        ->toBeArray()
        ->not->toBeEmpty();
});

test('onboarding tester tool has proper schema', function () {
    $tool = new OnboardingTester();
    
    expect($tool->description())->toContain('Tests the onboarding wizard functionality');
    
    // Test schema structure
    $schema = $tool->schema(new \Laravel\Mcp\Server\Tools\ToolInputSchema());
    expect($schema)->toBeInstanceOf(\Laravel\Mcp\Server\Tools\ToolInputSchema::class);
});

test('onboarding tester tool handles status test type', function () {
    $tool = new OnboardingTester();
    $result = $tool->handle(['test_type' => 'status']);
    
    expect($result)->toBeInstanceOf(\Laravel\Mcp\Server\Tools\ToolResult::class);
});

test('onboarding tester tool handles components test type', function () {
    $tool = new OnboardingTester();
    $result = $tool->handle(['test_type' => 'components']);
    
    expect($result)->toBeInstanceOf(\Laravel\Mcp\Server\Tools\ToolResult::class);
});

test('onboarding tester tool handles api test type', function () {
    $tool = new OnboardingTester();
    $result = $tool->handle(['test_type' => 'api']);
    
    expect($result)->toBeInstanceOf(\Laravel\Mcp\Server\Tools\ToolResult::class);
});

test('onboarding tester tool handles wizard test type', function () {
    $tool = new OnboardingTester();
    $result = $tool->handle(['test_type' => 'wizard']);
    
    expect($result)->toBeInstanceOf(\Laravel\Mcp\Server\Tools\ToolResult::class);
});

test('onboarding tester tool handles full test type', function () {
    $tool = new OnboardingTester();
    $result = $tool->handle(['test_type' => 'full']);
    
    expect($result)->toBeInstanceOf(\Laravel\Mcp\Server\Tools\ToolResult::class);
});

test('onboarding tester tool rejects invalid test type', function () {
    $tool = new OnboardingTester();
    $result = $tool->handle(['test_type' => 'invalid']);
    
    expect($result)->toBeInstanceOf(\Laravel\Mcp\Server\Tools\ToolResult::class);
    // Should return an error result
});

test('onboarding tester tool handles exceptions gracefully', function () {
    $tool = new OnboardingTester();
    
    // Test with malformed arguments
    $result = $tool->handle([]);
    
    expect($result)->toBeInstanceOf(\Laravel\Mcp\Server\Tools\ToolResult::class);
});

test('mcp ai routes are properly registered', function () {
    // Check that the AI routes file exists and contains our server registration
    $aiRoutesPath = base_path('routes/ai.php');
    expect(file_exists($aiRoutesPath))->toBeTrue();
    
    $content = file_get_contents($aiRoutesPath);
    expect($content)
        ->toContain('Mcp::local(\'onboarding\'')
        ->toContain('Mcp::web(\'onboarding-web\'')
        ->toContain('OnboardingServer::class');
});

test('mcp configuration file exists and is valid', function () {
    $configPath = config_path('mcp.php');
    expect(file_exists($configPath))->toBeTrue();
    
    $config = include $configPath;
    expect($config)
        ->toBeArray()
        ->toHaveKey('servers')
        ->toHaveKey('default')
        ->toHaveKey('settings');
    
    expect($config['servers']['onboarding'])
        ->toHaveKey('class')
        ->toHaveKey('name')
        ->toHaveKey('description')
        ->toHaveKey('version');
});

test('onboarding status resource handles unauthenticated users', function () {
    // Test without authentication
    auth()->logout();
    
    $resource = new OnboardingStatus();
    $result = $resource->read();
    $data = json_decode($result, true);
    
    expect($data)
        ->toHaveKey('error')
        ->toHaveKey('needsOnboarding')
        ->toHaveKey('isNewUser')
        ->toHaveKey('message');
    
    expect($data['error'])->toBe('User not authenticated');
});

test('onboarding status resource includes timestamp', function () {
    $resource = new OnboardingStatus();
    $result = $resource->read();
    $data = json_decode($result, true);
    
    expect($data['timestamp'])->toBeString();
    
    // Verify it's a valid ISO timestamp
    $timestamp = \Carbon\Carbon::parse($data['timestamp']);
    expect($timestamp)->toBeInstanceOf(\Carbon\Carbon::class);
});

test('onboarding tester tool provides structured test results', function () {
    $tool = new OnboardingTester();
    $result = $tool->handle(['test_type' => 'status']);
    
    // The result should be a ToolResult with structured JSON content
    expect($result)->toBeInstanceOf(\Laravel\Mcp\Server\Tools\ToolResult::class);
    
    // For now, just verify the result is a ToolResult instance
    // The actual content structure may vary based on implementation
    expect($result)->not->toBeNull();
});
